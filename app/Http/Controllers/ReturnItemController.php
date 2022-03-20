<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReturnItemStoreRequest;
use App\Item;
use App\ReturnItem;
use App\ReturnItemDetail;
use App\StockLog;
use App\Supplier;
use App\SystemParam;
use DB;
use Dompdf\Dompdf;
use Exception;
use Illuminate\Http\Request;

use function GuzzleHttp\json_decode;

class ReturnItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('return_item.index');
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
    public function store(ReturnItemStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $returnItemArr = $request->only('supplier_id', 'summary', 'note');
            $returnItemArr['user_id'] = auth()->user()->id;

            ReturnItem::create($returnItemArr);

            $thisReturnItemObj = ReturnItem::where($returnItemArr)->orderBy('id', 'desc')->first();
            $returnItemId = $thisReturnItemObj->id;
            $returnItemUniqId = $thisReturnItemObj->uniq_id;

            // details
            $isSuccess = true;
            foreach ($request->items as $i => $itemObj) {
                //check stock
                $isQtyReturnGreaterThanStock = ($itemObj['qty'] > $itemObj['stock']) ? true : false;
                if ($isQtyReturnGreaterThanStock === false) {
                    // store to return item detail
                    ReturnItemDetail::create([
                        'return_item_id' => $returnItemId,
                        'item_id' => $itemObj['id'],
                        'qty' => $itemObj['qty'],
                        'buy_price' => $itemObj['buy_price']
                    ]);

                    // store to stock log
                    StockLog::create([
                        'ref_uniq_id' => $returnItemUniqId,
                        'cause' => 'RTR',
                        'in_out_position' => 'OUT',
                        'qty' => $itemObj['qty'],
                        'old_stock' => $itemObj['stock'],
                        'new_stock' => $itemObj['stock'] - $itemObj['qty'],
                        'buy_price' => $itemObj['buy_price'],
                        'sell_price' => $itemObj['sell_price'],
                        'item_id' => $itemObj['id']
                    ]);

                    // update stock on item
                    Item::findOrFail($itemObj['id'])->update([
                        'stock' => $itemObj['stock'] - $itemObj['qty']
                    ]);
                } else {
                    $isSuccess = false;
                    $itemName = $itemObj['name'];
                    $pesan = "Qty retur dari barang $itemName melebihi stock";
                    break;
                }
            }

            if ($isSuccess === true) {
                DB::commit();
                return response()->json([
                    'status' => 'valid',
                    'pesan' => 'Retur Barang berhasil ditambah',
                ]);
            } else {
                DB::rollBack();
                return response()->json([
                    'status' => 'error',
                    'pesan' => $pesan,
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $returnItem = ReturnItem::with('user', 'supplier', 'details.item')->findOrFail($id);
        $returnItem->kode = "RT-" . str_pad($returnItem->id, 5, 0, STR_PAD_LEFT);
        return response()->json([
            'return_item' => $returnItem,
            'url_pdf' => route('return_item.generate_pdf', $id)
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
     * Display a listing of the resource in form of datatable.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function datatables(Request $request)
    {
        $returnItems = ReturnItem::select([
            'return_items.id',
            DB::raw("TO_CHAR(return_items.updated_at, 'DD-MON-YYYY') AS updated_at_idn"),
            DB::raw("'RT-' || LPAD(return_items.id::text, 5, '0') AS kode"),
            'suppliers.name AS supplier_name',
            DB::raw("TO_CHAR(return_items.summary, 'fm999G999D99') AS summary_iso"),
            'users.name as user_name',
        ])
            ->leftJoin('users', 'users.id', '=', 'return_items.user_id')
            ->leftJoin('suppliers', 'suppliers.id', '=', 'return_items.supplier_id');

        return datatables()
            ->of($returnItems)
            ->addIndexColumn()
            ->filterColumn('kode', function ($query, $keyword) {
                $sql = "'RT-' || LPAD(return_items.id::text, 5, '0') like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('updated_at_idn', function ($query, $keyword) {
                $sql = "TO_CHAR(return_items.updated_at, 'DD-MON-YYYY') like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('supplier_name', function ($query, $keyword) {
                $sql = "suppliers.name like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('summary_iso', function ($query, $keyword) {
                $sql = "TO_CHAR(return_items.summary, 'fm999G999D99') like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('user_name', function ($query, $keyword) {
                $sql = "users.name like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->addColumn('action', function ($returnItem) {
                $btn = '<button data-remote_show="' . route('return_item.show', $returnItem->id) . '" type="button" class="btn btn-info btn-sm btnOpen" title="Lihat"><i class="fas fa-eye fa-fw"></i></button> ';
                return $btn;
            })
            ->toJson();
    }

    /**
     * Display a listing of items in form of select2.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getSuppliers(Request $request)
    {
        $page = $request->page;
        $search = $request->term;
        $limit = 25;
        $offset = ($page - 1) * $limit;

        $suppliers = Supplier::select('*')
            ->where('name', 'like', "%$search%")
            ->orderby('name', 'asc')
            ->skip($offset)->take($limit)
            ->get();

        $results = [];
        foreach ($suppliers as $i => $supplier) {
            $results[] = array(
                'id' => json_encode($supplier),
                'text' => "$supplier->name",
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
            ->where(function ($query) use ($search) {
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
     * Display a spesifict data in form of PDF.
     *
     * @param  int  $id
     * @return Dompdf\Dompdf
     */
    public function generatePdf($id)
    {
        $sys_param = json_decode(json_encode([
            'mrch_name' => SystemParam::where('param_code', 'MRCH_NAME')->first()->param_value,
            'mrch_addr' => SystemParam::where('param_code', 'MRCH_ADDR')->first()->param_value,
        ]));
        $return_item = ReturnItem::with('user', 'supplier', 'details.item')->findOrFail($id);

        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('return_item.pdf', compact('sys_param', 'return_item'))->render());
        $dompdf->setPaper('A5', 'landscape');
        $dompdf->render();
        $dompdf->stream("Retur Barang $return_item->uniq_id SIPDS.pdf", array("Attachment" => true));

        exit(0);
    }
}
