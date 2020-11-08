<?php

namespace App\Http\Controllers;

use App\Buy;
use App\BuyPaymentHs;
use DB;
use Exception;
use Illuminate\Http\Request;

class BuyPaymentHsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->view('buy_payment_hs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $buy = Buy::with('user', 'suplier', 'buyDetails', 'buyDetails.item', 'buyPaymentHs', 'buyPaymentHs.user')->findOrFail($id);
        $buy->kode = "PB-" . str_pad($buy->id, 5, '0', STR_PAD_LEFT);
        $buy->status_text = $buy->statusText();
        return response()->json([
            'buy' => $buy,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $buyId = $id;
        $summary = Buy::findOrFail($buyId)->summary;
        $sumPaymentAmount = BuyPaymentHs::where('buy_id', $buyId)->sum('amount');
        $amountLeft = $summary - $sumPaymentAmount;

        $isAmountGreaterThanAmountLeft = $request->amount > $amountLeft;
        if ($isAmountGreaterThanAmountLeft) {
            return response()->json([
                'status' => 'error',
                'pesan' => 'Nominal Tagihan melebihi sisa hutang',
            ]);
        } else {
            try {
                DB::beginTransaction();
    
                BuyPaymentHs::create([
                    'buy_id' => $buyId,
                    'user_id' => auth()->user()->id,
                    'amount' => $request->amount,
                    'note' => $request->note,
                    'payment_date' => date('Y-m-d H:i:s'),
                ]);

                //update status on buy table
                $sumPaymentAmount = BuyPaymentHs::where('buy_id', $buyId)->sum('amount');
                $isPaidOut = $sumPaymentAmount === $summary;
                if ($isPaidOut) {
                    $buy = Buy::findOrFail($buyId);
                    $buy->buy_status = 'PO';
                    $buy->save();
                    // Buy::findOrFail($buyId)->update([
                    //     'buy_status' => 'PO',
                    //     ]);
                    // dd($buy->buy_status);
                }
    
                DB::commit();
                return response()->json([
                    'status' => 'valid',
                    'pesan' => 'Pembayaran hutang berhasil disimpan',
                ]);
    
            } catch (Exception $exc) {
                DB::rollBack();
                return response()->json([
                    'status' => 'error',
                    'pesan' => $exc->getMessage(),
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function datatables(Request $request)
    {
        $buys = Buy::select([
                'buys.id',
                DB::raw("CONCAT('PJ-', LPAD(buys.id, 5, '0')) AS _id"),
                DB::raw("DATE_FORMAT(buys.updated_at, '%d %b %Y') AS _updated_at"),
                'supliers.name AS _suplier_name',
                'buys.summary',
                'users.name AS _user_name',
                'buys.buy_status',
                'look_ups.label as _status',
            ])
            ->leftJoin('supliers', 'supliers.id', '=', 'buys.suplier_id')
            ->leftJoin('users', 'users.id', '=', 'buys.user_id')
            ->leftJoin('look_ups', function ($join) {
                $join->on('look_ups.key', '=', 'buys.buy_status');
                $join->where('look_ups.group_code', '=', 'BUY_STATUS');
            })
            ->where('buys.buy_status', 'DE');

        if ($request->filter['date_start'] != null && $request->filter['date_end'] != null) {
            $buys->where('buys.updated_at', '>=', $request->filter['date_start'])
                ->where('buys.updated_at', '<=', $request->filter['date_end'] . " 23:59:59");
        }

        return datatables()
            ->of($buys)
            ->addIndexColumn()
            ->filterColumn('_id', function ($query, $keyword) {
                $sql = "CONCAT('PJ-', LPAD(buys.id, 5, '0')) like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('_updated_at', function ($query, $keyword) {
                $sql = "DATE_FORMAT(buys.updated_at, '%d %b %Y') like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('_suplier_name', function ($query, $keyword) {
                $sql = "supliers.name like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('_user_name', function ($query, $keyword) {
                $sql = "users.name like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('_status', function ($query, $keyword) {
                $sql = "look_ups.label like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->addColumn('_status_raw', function ($buy) {
                if ($buy->buy_status == 'PO') {
                    return '<p class="text-success">' . $buy->_status . '</p>';
                } else {
                    return '<p class="text-warning">' . $buy->_status . '</p>';
                }
            })
            ->addColumn('_action_raw', function ($buy) {
                $btn = '<button data-remote_get="' . route('buy_payment_hs.show', $buy->id) . '" data-remote_set="' . route('buy_payment_hs.update', $buy->id) . '" type="button" class="btn btn-primary btn-sm addBtn" title="Tambah"><i class="fas fa-plus fa-fw"></i></button> ';
                $btn .= '<button data-remote_get="' . route('buy_payment_hs.show', $buy->id) . '" type="button" class="btn btn-info btn-sm openBtn" title="Lihat"><i class="fas fa-eye fa-fw"></i></button> ';
                return $btn;
            })
            ->rawColumns(['_action_raw', '_status_raw'])
            ->toJson();
    }    
}
