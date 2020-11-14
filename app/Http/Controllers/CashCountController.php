<?php

namespace App\Http\Controllers;

use App\CashCount;
use App\Http\Requests\CashCountStoreRequest;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Http\Request;

class CashCountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tglNow = Carbon::now()->toDateString();
        return response()->view('cash_count.index', compact('tglNow'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('cash_count.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CashCountStoreRequest $request)
    {
        /*
        request {
            counted_amount,
        }
        */

        $sumAmounts = DB::select(DB::raw("
                SELECT
                    MIN(io_cash) AS io_cash,
                    IF(io_cash = 'I', SUM(amount), (SUM(amount) * -1)) AS sum_amount
                FROM cashflows
                WHERE trx_date >= CONCAT(DATE(NOW()),' 00:00:00')
                AND trx_date <= CONCAT(DATE(NOW()),' 23:59:59')
                GROUP BY io_cash
            "));

        $countedSystem = 0;    
        if ($sumAmounts) {
            foreach ($sumAmounts as $i => $sumAmount) {
                $countedSystem += $sumAmount->sum_amount;
            }
        }
        $deviation = $countedSystem - $request->counted_amount;

        try {
            DB::beginTransaction();

            // store to sell payment history
            CashCount::create([
                'user_id' => auth()->user()->id,
                'count_date' => Carbon::now(),
                'counted_amount' => $request->counted_amount,
                'counted_system' => $countedSystem,
                'deviation' => $deviation,
            ]);

            DB::commit();

            $isDeviationZero = $deviation == 0;
            if ($isDeviationZero) {
                return response()->json([
                    'status' => 'valid',
                    'pesan' => 'Hitung kas berhasil disimpan',
                    'is_selisih' => false,
                ]);
            } else {
                return response()->json([
                    'status' => 'valid',
                    'pesan' => "Terdapat selisih saldo senilai $deviation",
                    'is_selisih' => true,
                ]);
            }

        } catch (Exception $exc) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'pesan' => $exc->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CashCount  $cashCount
     * @return \Illuminate\Http\Response
     */
    public function show(CashCount $cashCount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CashCount  $cashCount
     * @return \Illuminate\Http\Response
     */
    public function edit(CashCount $cashCount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CashCount  $cashCount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CashCount $cashCount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CashCount  $cashCount
     * @return \Illuminate\Http\Response
     */
    public function destroy(CashCount $cashCount)
    {
        //
    }

    /**
     * Display a listing of the resource in form of datatable.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function datatables(Request $request)
    {
        $cashCounts = DB::select(DB::raw("
                SELECT
                    CONCAT('HK-', LPAD(cc.`id`, 5, '0')) AS kode,
                    DATE_FORMAT(cc.`count_date`, '%e %b %Y %H:%i') AS `date`,
                    cc.`counted_amount`,
                    cc.`counted_system`,
                    cc.`deviation`,
                    u.`name` AS `user`
                FROM cash_counts cc
                LEFT JOIN users u ON u.`id` = cc.`user_id`
                WHERE cc.`count_date` >= '" . $request->filter['date_start'] . " 00:00:00'
                AND cc.`count_date` <= '" . $request->filter['date_end'] . " 23:59:59'
            "));
        return datatables()
            ->of($cashCounts)
            ->addIndexColumn()
            ->toJson();
    }
}