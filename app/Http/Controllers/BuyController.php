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
use App\BuyPaymentHs;
use App\Http\Requests\BuyStoreRequest;
use App\SystemParam;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Exception;

class BuyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->view('buy.index');
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
            $paid_amount = $request->input('paid_amount');
            $total = 0;
            // dd($paid_amount);
            // dd($qty);

            $buy = Buy::create([
                'user_id'       => auth()->user()->id,
                'suplier_id'    => $suplier_id,
                'summary'       => $total,
                'note'          => $note,
            ]);

            foreach ($buy_prices as $i => $buy_price) {

                $item = Item::findOrFail($item_id[$i]);

                $new_buy_price = $buy_price;
                if ($item->is_stock_active) {
                    $old_stock = $item->stock;
                    $new_stock = $old_stock + $qty[$i];
                    $item->stock = $new_stock;
                }

                $item->buy_price = $new_buy_price;
                $item->last_buy_at = Carbon::now();
                $item->save();

                $dataDetail = array(
                    'buy_id'    => $buy->id,
                    'item_id'   => $item_id[$i],
                    'buy_price' => $buy_price,
                    'qty'       => $qty[$i],
                );

                BuyDetail::create($dataDetail);

                $total += $buy_price * $qty[$i];

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

            if ($paid_amount > $total) {
                DB::rollBack();
                return redirect()->back()
                    ->with('message', "Nominal tidak boleh melebihi total pembelian.");
            } elseif ($paid_amount == $total) {
                $buy->paid_amount = $paid_amount;
                $buy->buy_status = 'PO';
                $buy->save();

                $dataPayment = array(
                    'buy_id' => $buy->id,
                    'user_id' => auth()->user()->id,
                    'payment_date'  => $buy->created_at,
                    'amount'        => $paid_amount,
                );

                BuyPaymentHs::create($dataPayment);

                DB::commit();
                $request->session()->flash('buy.summary', $buy->summary);
                return redirect()->back()
                    ->with('message', "Data berhasil tersimpan.");
            } else {
                $buy->paid_amount = $paid_amount;
                $buy->save();

                $dataPayment = array(
                    'buy_id' => $buy->id,
                    'user_id' => auth()->user()->id,
                    'payment_date'  => $buy->created_at,
                    'amount'        => $paid_amount,
                );

                BuyPaymentHs::create($dataPayment);

                DB::commit();
                $request->session()->flash('buy.summary', $buy->summary);
                return redirect()->back()
                    ->with('message', "Data berhasil tersimpan.");
            }
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
    public function show($uniq_id)
    {
        $buys = Buy::with('suplier')->where('uniq_id', $uniq_id)->first();
        // dd($buys);
        $mrch_name = SystemParam::where('param_code', 'MRCH_NAME')->first();
        $mrch_addr = SystemParam::where('param_code', 'MRCH_ADDR')->first();
        $mrch_phone = SystemParam::where('param_code', 'MRCH_PHONE')->first();

        return view('buy.show', compact('buys', 'mrch_name', 'mrch_addr', 'mrch_phone'));
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
        } else if ($flag == 'barcode') {
            $id = $request->item;

            $item = Item::where('barcode', $id)->get();
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

    public function printReport($uniq_id)
    {
        $buys = Buy::with('suplier')->where('uniq_id', $uniq_id)->first();
        $details = BuyDetail::with('item')->where('buy_id', $buys->id)->get();
        $mrch_name = SystemParam::where('param_code', 'MRCH_NAME')->first();
        $mrch_addr = SystemParam::where('param_code', 'MRCH_ADDR')->first();
        $mrch_phone = SystemParam::where('param_code', 'MRCH_PHONE')->first();

        return view('buy.print', compact('buys', 'details', 'mrch_name', 'mrch_addr', 'mrch_phone'));
    }

    public function generatePdfReport($uniq_id)
    {
        $buys = Buy::with('suplier')->where('uniq_id', $uniq_id)->first();
        $details = BuyDetail::with('item')->where('buy_id', $buys->id)->get();
        $mrch_name = SystemParam::where('param_code', 'MRCH_NAME')->first();
        $mrch_addr = SystemParam::where('param_code', 'MRCH_ADDR')->first();
        $mrch_phone = SystemParam::where('param_code', 'MRCH_PHONE')->first();

        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('buy.pdf', compact('buys', 'details', 'mrch_name', 'mrch_addr', 'mrch_phone'))->render());
        $dompdf->setPaper('A5', 'landscape');
        $dompdf->render();
        $dompdf->stream("Pembelian $uniq_id bizmart.pdf", array("Attachment" => false));
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
                $btn .= '<button data-id="' . $item->id . '" class="btn btn-primary btn-sm my_btn"><i class="fa fa-plus"></i></button>';
                return $btn;
            })
            ->rawColumns(['action', 'categories'])
            ->make(true);
    }

    public function datatablesReport(Request $request)
    {
        $start_date = $request->filter["start_date"];
        $end_date = $request->filter["end_date"];
        $data = Buy::with('suplier');

        if ($start_date != null && $end_date != null) {
            $data->whereBetween('created_at', [$start_date . " 00:00:00", $end_date . " 23:59:59"]);
        }

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->editColumn('buy_code', function ($buy) {
                return $buy->buyCode();
            })
            ->editColumn('buy_status', function ($buy) {
                return $buy->statusText();
            })
            ->editColumn('id', function ($buy) {
                return $buy->buyCode();
            })
            ->editColumn('summary', function ($buy) {
                return number_format($buy->summary);
            })
            ->editColumn('created_at', function ($buy) {
                return $buy->created_at->isoFormat('dddd, D MMMM Y');
            })
            ->addColumn('action', function ($buy) {
                $btn = '<a href="' . route('buy.show', $buy->uniq_id) . '" class=" btn btn-info btn-sm" title="Lihat Data"><i class="fa fa-eye"></i></a>';

                // $btn .= '<button data-remote_delete="'. route('buy.delete', $buy->id).'" class="btn btn-danger btn-sm my_btn"><i class="fa fa-trash"></i></button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function datatablesReportDetail(Request $request)
    {
        $buy = Buy::where('uniq_id', $request->uniq_id)->first();
        $data = BuyDetail::with('item')->where('buy_id', $buy->id)->get();
        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->editColumn('buy_price', function ($buy_detail) {
                return number_format($buy_detail->buy_price);
            })
            ->addColumn('subtotal', function ($buy_detail) {
                $subtotal = $buy_detail->qty * $buy_detail->buy_price;
                return number_format($subtotal);
            })
            ->make(true);
    }
}
