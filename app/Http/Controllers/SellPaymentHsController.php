<?php

namespace App\Http\Controllers;

use App\Sell;
use App\SellPaymentHs;
use DB;
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
        $sell->kode = "PJ-" . str_pad($sell->id, 5, '0', STR_PAD_LEFT);
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
    public function update(Request $request, $id)
    {
        $sellId = $id;
        /*
        request {
            amount,
            note,
        }
        */

        //todo amount harus di check ke sisa

        try {
            DB::beginTransaction();

            SellPaymentHs::create([
                'sell_id' => $sellId,
                'user_id' => auth()->user()->id,
                'amount' => $request->amount,
                'note' => $request->note,
                'payment_date' => date('Y-m-d H:i:s'),
            ]);

            DB::commit();
            return response()->json([
                'status' => 'valid',
                'pesan' => 'Pembayaran piutang berhasil disimpan',
            ]);

        } catch (Exception $exc) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'pesan' => $exc->getMessage(),
            ]);
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
                DB::raw("CONCAT('PJ-', LPAD(sells.id, 5, '0')) AS _id"),
                DB::raw("DATE_FORMAT(sells.updated_at, '%d %b %Y') AS _updated_at"),
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
                $sql = "CONCAT('PJ-', LPAD(sells.id, 5, '0')) like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('_updated_at', function ($query, $keyword) {
                $sql = "DATE_FORMAT(sells.updated_at, '%d %b %Y') like ?";
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
            ->addColumn('_status_raw', function ($sell) {
                if ($sell->sell_status == 'PO') {
                    return '<p class="text-success">' . $sell->_status . '</p>';
                } else {
                    return '<p class="text-warning">' . $sell->_status . '</p>';
                }
            })
            ->addColumn('_action_raw', function ($sell) {
                $btn = '<button data-remote_get="' . route('sell_payment_hs.show', $sell->id) . '" type="button" class="btn btn-primary btn-sm addBtn" title="Tambah"><i class="fas fa-plus fa-fw"></i></button> ';
                $btn .= '<button data-remote_get="' . route('sell_payment_hs.show', $sell->id) . '" type="button" class="btn btn-info btn-sm openBtn" title="Lihat"><i class="fas fa-eye fa-fw"></i></button> ';
                return $btn;
            })
            ->rawColumns(['_action_raw', '_status_raw'])
            ->toJson();
    }
}
