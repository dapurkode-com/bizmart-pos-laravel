<?php

namespace App\Http\Controllers;

use App\Item;
use App\Sell;
use App\SellDetail;
use App\StockLog;
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
       //
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
    public function store(Request $request)
    {
        /*
        request {
            summary,
            tax,
            note,
            paid_amount,
            sell_details {
                items_id,
                qty,
                sell_price,
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
                $itemId = $sellDetailItemArr['items_id'];

                $itemObj = Item::findOrFail($itemId);

                SellDetail::create([
                    'items_id' => $itemId,
                    'qty' => $sellDetailItemArr['qty'],
                    'sell_price' => $itemObj->sell_price,
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
                    'sell_price' => $itemObj['sell_price'],
                    'item_id' => $itemId,
                ]);

                // update stock on item
                Item::findOrFail($itemId)->update([
                    'stock' => $itemObj['stock'] - $sellDetailItemArr['qty'],
                ]);
            }

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
        //
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
}
