<?php

namespace App\Http\Controllers;

use App\Http\Requests\SellStoreRequest;
use App\Item;
use App\Member;
use App\Sell;
use App\SellDetail;
use App\SellPaymentHs;
use App\StockLog;
use DB;
use Exception;
use Illuminate\Http\Request;

class SellController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->view('sell.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('sell.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SellStoreRequest $request)
    {
        /*
        request {
            member_id,
            summary,
            tax,
            note,
            paid_amount,
            sell_details {
                [
                    item_id,
                    qty,
                    sell_price,
                ]
            }
        }
        */

        try {
            DB::beginTransaction();

            $isSummaryGreaterThanPaidAmount = $request->summary > $request->paid_amount;
            
            $sellStatus = ($isSummaryGreaterThanPaidAmount) ? 'RE' : 'PO';

            $sellItemArr = [
                'user_id' => auth()->user()->id,
                'member_id' => $request->member_id,
                'summary' => $request->summary,
                'tax' => $request->tax,
                'note' => $request->note,
                'paid_amount' => $request->paid_amount,
                'sell_status' => $sellStatus,
            ];

            Sell::create($sellItemArr);

            $newSellObj = Sell::where($sellItemArr)->orderBy('id', 'desc')->first();
            $sellId = $newSellObj->id;
            $sellUniqId = $newSellObj->uniq_id;

            // details
            foreach ($request->sell_details as $i => $sellDetailItemArr) {
                $itemId = $sellDetailItemArr['item_id'];

                $itemObj = Item::findOrFail($itemId);

                SellDetail::create([
                    'sell_id' => $sellId,
                    'item_id' => $itemId,
                    'qty' => $sellDetailItemArr['qty'],
                    'sell_price' => $sellDetailItemArr['sell_price'],
                ]);

                // store to stock log
                StockLog::create([
                    'ref_uniq_id' => $sellUniqId,
                    'cause' => 'SELL',
                    'in_out_position' => 'OUT',
                    'qty' => $sellDetailItemArr['qty'],
                    'old_stock' => $itemObj['stock'],
                    'new_stock' => $itemObj['stock'] - $sellDetailItemArr['qty'],
                    'buy_price' => $itemObj['buy_price'],
                    'sell_price' => $sellDetailItemArr['sell_price'],
                    'item_id' => $itemId,
                ]);

                // update stock on item
                Item::findOrFail($itemId)->update([
                    'stock' => $itemObj['stock'] - $sellDetailItemArr['qty'],
                ]);
            }

            // store to sell payment history
            SellPaymentHs::create([
                'sell_id' => $sellId,
                'user_id' => auth()->user()->id,
                'amount' => $request->paid_amount,
                'note' => $request->note,
                'payment_date' => date('Y-m-d H:i:s'),
            ]);

            DB::commit();
            return response()->json([
                'status' => 'valid',
                'pesan' => 'Penjualan berhasil disimpan',
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
        //
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
     * Display a listing of items in form of select2.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getItems(Request $request)
    {
        $page = $request->page;
        $search = $request->term;
        $limit = 25;
        $offset = ($page - 1) * $limit;

        $items = Item::select('*')
            ->where('stock', '>', '0')
            ->orWhere('is_stock_active', '0')
            ->where(function($query) use ($search){
                $query->where('barcode', 'like', "%$search%")
                      ->orWhere('name', 'like', "%$search%");
            })
            ->orderby('name', 'asc')
            ->skip($offset)->take($limit)
            ->get();

        $results = [];
        foreach ($items as $i => $item) {
            $results[] = array(
                'id' => json_encode($item),
                'text' => "$item->barcode - $item->name",
            );
        }

        if (count($results) < $limit) {
            $more_pages = false;
        } else {
            $more_pages = true;
        }

        return response()->json([
            "results" => $results,
            "pagination" => [
                "more" => $more_pages,
            ],
        ]);
    }

    /**
     * Display a listing of members in form of select2.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getMembers(Request $request)
    {
        $page = $request->page;
        $search = $request->term;
        $limit = 25;
        $offset = ($page - 1) * $limit;

        $members = Member::select('*')
            ->where('name', 'like', "%$search%")
            ->orderby('name', 'asc')
            ->skip($offset)->take($limit)
            ->get();

        $results = [];
        foreach ($members as $i => $member) {
            $results[] = array(
                'id' => json_encode($member),
                'text' => "$member->name",
            );
        }

        if (count($results) < $limit) {
            $more_pages = false;
        } else {
            $more_pages = true;
        }

        return response()->json([
            "results" => $results,
            "pagination" => [
                "more" => $more_pages,
            ],
        ]);
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
            });

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
                $btn = '<button data-remote_get="' . route('sell.show', $sell->id) . '" type="button" class="btn btn-info btn-sm openBtn" title="Lihat"><i class="fas fa-eye fa-fw"></i></button> ';
                return $btn;
            })
            ->rawColumns(['_action_raw', '_status_raw'])
            ->toJson();
    }
}
