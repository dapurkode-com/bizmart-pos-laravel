<?php

namespace App\Http\Controllers;

use App\Http\Requests\SellPaymentHsUpdateRequest;
use App\Sell;
use App\SellPaymentHs;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Http\Request;

class SellPaymentHsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->view('sell_payment_hs.index');
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
        $sell = Sell::with('user', 'member', 'sellDetails', 'sellDetails.item', 'sellPaymentHs', 'sellPaymentHs.user')->findOrFail($id);
        $sell->kode = $sell->sellCode();
        $sell->status_text = $sell->statusText();
        return response()->json([
            'sell' => $sell,
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
    public function update(SellPaymentHsUpdateRequest $request, $id)
    {
        /*
        request {
            amount,
            note,
        }
        */
        $sellId = $id;
        $summary = Sell::findOrFail($sellId)->summary;
        $sumPaymentAmount = SellPaymentHs::where('sell_id', $sellId)->sum('amount');
        $amountLeft = $summary - $sumPaymentAmount;

        $isAmountGreaterThanAmountLeft = $request->amount > $amountLeft;
        if ($isAmountGreaterThanAmountLeft) {
            return response()->json([
                'status' => 'error',
                'pesan' => 'Nominal Tagihan melebihi sisa piutang',
            ]);
        } else {
            try {
                DB::beginTransaction();

                SellPaymentHs::create([
                    'sell_id' => $sellId,
                    'user_id' => auth()->user()->id,
                    'amount' => $request->amount,
                    'note' => $request->note,
                    'payment_date' => Carbon::now(),
                ]);

                //update status on sell table
                $sumPaymentAmount = SellPaymentHs::where('sell_id', $sellId)->sum('amount');
                $isPaidOut = $sumPaymentAmount === $summary;
                if ($isPaidOut) {
                    Sell::findOrFail($sellId)->update([
                        'sell_status' => 'PO',
                    ]);
                }

                DB::commit();
                return response()->json([
                    'status' => 'valid',
                    'pesan' => 'Penagihan piutang berhasil disimpan',
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

    /**
     * Display a listing of the resource in form of datatable.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function datatables(Request $request)
    {
        $sells = Sell::select([
            'sells.id',
            'sells.updated_at',
            DB::raw("'HT-' || LPAD(sells.id::text, 5, '0') AS _id"),
            DB::raw("TO_CHAR(sells.updated_at, 'DD-MON-YYYY') AS _updated_at"),
            'members.name AS _member_name',
            'sells.summary',
            'users.name AS _user_name',
            'sells.sell_status',
            'look_ups.label as _status',
        ])
            ->leftJoin('members', 'members.id', '=', 'sells.member_id')
            ->leftJoin('users', 'users.id', '=', 'sells.user_id')
            ->leftJoin('look_ups', function ($join) {
                $join->on('look_ups.key', '=', 'sells.sell_status');
                $join->where('look_ups.group_code', '=', 'SELL_STATUS');
            })
            ->where('sells.sell_status', 'RE');

        if ($request->filter['date_start'] != null && $request->filter['date_end'] != null) {
            $sells->where('sells.updated_at', '>=', $request->filter['date_start'])
                ->where('sells.updated_at', '<=', $request->filter['date_end'] . " 23:59:59");
        }

        return datatables()
            ->of($sells)
            ->addIndexColumn()
            ->filterColumn('_id', function ($query, $keyword) {
                $sql = "'HT-' || LPAD(sells.id::text, 5, '0') like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('_updated_at', function ($query, $keyword) {
                $sql = "TO_CHAR(sells.updated_at, 'DD-MON-YYYY') like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('_member_name', function ($query, $keyword) {
                $sql = "members.name like ?";
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
            ->editColumn('_id', function ($sell) {
                return $sell->sellCode();
            })
            ->editColumn('summary', function ($sell) {
                return number_format($sell->summary);
            })
            ->editColumn('_updated_at', function ($sell) {
                return $sell->updated_at->isoFormat('dddd, D MMMM Y');
            })
            ->addColumn('_status_raw', function ($sell) {
                if ($sell->sell_status == 'PO') {
                    return '<p class="text-success">' . $sell->_status . '</p>';
                } else {
                    return '<p class="text-warning">' . $sell->_status . '</p>';
                }
            })
            ->addColumn('_action_raw', function ($sell) {
                $btn = auth()->user()->privilege_code == 'EM' ? '<button data-remote_get="' . route('sell_payment_hs.show', $sell->id) . '" data-remote_set="' . route('sell_payment_hs.update', $sell->id) . '" type="button" class="btn btn-primary btn-sm addBtn" title="Tambah"><i class="fas fa-plus fa-fw"></i></button> ' : '';
                $btn .= '<button data-remote_get="' . route('sell_payment_hs.show', $sell->id) . '" type="button" class="btn btn-info btn-sm openBtn" title="Lihat"><i class="fas fa-eye fa-fw"></i></button> ';
                return $btn;
            })
            ->rawColumns(['_action_raw', '_status_raw'])
            ->toJson();
    }
}
