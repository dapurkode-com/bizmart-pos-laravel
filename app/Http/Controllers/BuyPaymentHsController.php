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
        $buy = Buy::with('user', 'supplier', 'buyDetails', 'buyDetails.item', 'buyPaymentHs', 'buyPaymentHs.user')->findOrFail($id);
        $buy->kode = $buy->buyCode();
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
                    $buy->paid_amount +=  $request->amount;
                    $buy->save();
                } else {
                    $buy = Buy::findOrFail($buyId);
                    $buy->paid_amount +=  $request->amount;
                    $buy->save();
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
            'buys.updated_at',
            DB::raw("'HT-' || LPAD(buys.id::text, 5, '0') AS _id"),
            DB::raw("TO_CHAR(buys.updated_at, 'DD-MON-YYYY') AS _updated_at"),
            'suppliers.name AS _supplier_name',
            'buys.summary',
            'users.name AS _user_name',
            'buys.buy_status',
            'look_ups.label as _status',
        ])
            ->leftJoin('suppliers', 'suppliers.id', '=', 'buys.supplier_id')
            ->leftJoin('users', 'users.id', '=', 'buys.user_id')
            ->leftJoin('look_ups', function ($join) {
                $join->on('look_ups.key', '=', 'buys.buy_status');
                $join->where('look_ups.group_code', '=', 'BUY_STATUS');
            })
            ->where('buys.buy_status', 'DE');

        if ($request->filter['date_start'] != null && $request->filter['date_end'] != null) {
            $buys->where('buys.updated_at', '>=', $request->filter['date_start'] . " 00:00:00")
                ->where('buys.updated_at', '<=', $request->filter['date_end'] . " 23:59:59");
        }

        return datatables()
            ->of($buys)
            ->addIndexColumn()
            ->filterColumn('_id', function ($query, $keyword) {
                $sql = "'HT-' || LPAD(buys.id::text, 5, '0') like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('_updated_at', function ($query, $keyword) {
                $sql = "TO_CHAR(buys.updated_at, 'DD-MON-YYYY') like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('_supplier_name', function ($query, $keyword) {
                $sql = "suppliers.name like ?";
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
            ->editColumn('_id', function ($buy) {
                return $buy->buyCode();
            })
            ->editColumn('summary', function ($buy) {
                return number_format($buy->summary);
            })
            ->editColumn('_updated_at', function ($buy) {
                return $buy->updated_at->isoFormat('dddd, D MMMM Y');
            })
            ->addColumn('_action_raw', function ($buy) {
                $btn = auth()->user()->privilege_code == 'EM' ? '<button data-remote_get="' . route('buy_payment_hs.show', $buy->id) . '" data-remote_set="' . route('buy_payment_hs.update', $buy->id) . '" type="button" class="btn btn-primary btn-sm addBtn" title="Tambah"><i class="fas fa-plus fa-fw"></i></button> ' : '';
                $btn .= '<button data-remote_get="' . route('buy_payment_hs.show', $buy->id) . '" type="button" class="btn btn-info btn-sm openBtn" title="Lihat"><i class="fas fa-eye fa-fw"></i></button> ';
                return $btn;
            })
            ->rawColumns(['_action_raw', '_status_raw'])
            ->toJson();
    }
}
