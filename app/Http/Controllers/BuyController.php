<?php

namespace App\Http\Controllers;

use App\Buy;
use Illuminate\Http\Request;
use App\Suplier;
use App\Item;
use App\Helpers\BadgeHelper;
use App\BuyDetail;
use Illuminate\Support\Facades\DB;
use App\StockLog;
use App\Http\Requests\BuyStoreRequest;

class BuyController extends Controller
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
        $options['SUPLIER'] = Suplier::all();
        return response()->view('buy.create', compact('options'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BuyStoreRequest $request)
    {
        $data = [];

        try {
            DB::beginTransaction();

            $suplier_id = $request->input('suplier_id');
            $buy_prices = $request->input('buy_price');
            $note       = $request->input('note');
            $qty  = $request->input('qty');
            $item_id = $request->input('items_id');
            $total = 0;
            // dd($qty);

            $buy = Buy::create([
                'user_id'       => auth()->user()->id,
                'suplier_id'    => $suplier_id,
                'summary'       => $total,
                'note'          => $note,
            ]);

            foreach ($buy_prices as $i => $buy_price){

                $item = Item::findOrFail($item_id[$i]);

                $new_buy_price = $buy_price;
                if ($item->is_stock_active) {
                    $old_stock = $item->stock;
                    $new_stock = $old_stock + $qty[$i];
                    $item->stock = $new_stock;
                }

                $item->buy_price = $new_buy_price;
                $item->save();
                
                $data = array(
                    'buy_id'    => $buy->id,
                    'item_id'   => $item_id[$i],
                    'buy_price' => $buy_price,
                    'qty'       => $qty[$i],
                );

                BuyDetail::create($data);

                $total +=$buy_price * $qty[$i];

                $log = array(
                    'ref_uniq_id'       => $buy->uniq_id,
                    'cause'             => 'BUY',
                    'in_out_position'   => 'IN',
                    'qty'               => $qty[$i],
                    'old_stock'         => $old_stock,
                    'new_stock'         => $new_stock,
                    'buy_price'         => $new_buy_price,
                    'sell_price'        => $item->sell_price,
                    'item_id'           => $item_id[$i],
                );

                StockLog::create($log);

            }

            $buy->summary = $total;
            $buy->save();

            DB::commit();
            $request->session()->flash('buy.summary', $buy->summary);
            return redirect()->back()
                ->with('message', "Data berhasil tersimpan.");
        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()
                ->with('message', $exception)
                ->withInput();
        }
 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Buy  $buy
     * @return \Illuminate\Http\Response
     */
    public function show(Buy $buy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Buy  $buy
     * @return \Illuminate\Http\Response
     */
    public function edit(Buy $buy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Buy  $buy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Buy $buy)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Buy  $buy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Buy $buy)
    {
        //
    }

    public function select(Request $request)
    {
        $flag = $request->flag;
        if ($flag == 'suplier') {
            $id = $request->suplier_id;
            return response()->json([
                'suplier' => Suplier::findOrFail($id)
            ]);
        }
        else if ($flag == 'barcode'){
            $id = $request->item;
            
            $item = Item::where('barcode',$id)->get();
            if ($item != null) {
                
                return response()->json([
                    'status' => 'valid',
                    'row' => $item
                ]);
            } else {
                return response()->json([
                    'status' => 'invalid'
                ]);
            }
        } else {
            $id = $request->item;
            return response()->json([
                'row' => Item::findOrFail($id)
            ]);
        }
    }


    public function datatables()
    {
        $data = Item::with('categories')->selectRaw('distinct items.*');
        return datatables()
        ->of($data)
        ->addIndexColumn()
        ->addColumn('categories', function ($item) {
            return $item->categories->map(function ($item) {
                return join('', ["<span class='badge ", BadgeHelper::getBadgeClass($item->id), "'>", $item->name, '</span>']); //Customize warna badge
            })->implode(' ');
        })
        ->addColumn('action', function ($item) {
            $btn = "";
            $btn .= '<button data-id="'.$item->id.'" class="btn btn-primary btn-sm my_btn"><i class="fa fa-plus"></i></button>';
            return $btn;
        })
        ->rawColumns(['action', 'categories'])
            ->make(true);
    }
}
