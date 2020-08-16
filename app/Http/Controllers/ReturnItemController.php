<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReturnItemStoreRequest;
use App\Http\Requests\ReturnItemValidateAddItemRequest;
use App\Item;
use App\ReturnItem;
use App\ReturnItemDetail;
use App\StockLog;
use App\Suplier;
use DB;
use Exception;
use Illuminate\Http\Request;

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

            $returnItemArr = $request->only('suplier_id', 'summary', 'note');
            $returnItemArr['user_id'] = auth()->user()->id;

            ReturnItem::create($returnItemArr);

            $thisReturnItemObj = ReturnItem::where($returnItemArr)->orderBy('id', 'desc')->first();
            $returnItemId = $thisReturnItemObj->id;
            $returnItemUniqId = $thisReturnItemObj->uniq_id;

            // details
            foreach ($request->items as $i => $itemObj) {
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
            }

            DB::commit();
            return response()->json([
                'status' => 'valid',
                'pesan' => 'Retur Barang berhasil ditambah',
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
            DB::raw("DATE_FORMAT(return_items.updated_at, '%d %b %Y') AS updated_at_idn"),
            'return_items.uniq_id',
            'supliers.name AS suplier_name',
            DB::raw("FORMAT(return_items.summary, 2) AS summary_iso"),
            'users.name as user_name',
        ])
            ->leftJoin('users', 'users.id', '=', 'return_items.user_id')
            ->leftJoin('supliers', 'supliers.id', '=', 'return_items.suplier_id');

        return datatables()
            ->of($returnItems)
            ->addIndexColumn()
            ->filterColumn('updated_at_idn', function ($query, $keyword) {
                $sql = "DATE_FORMAT(return_items.updated_at, '%d %b %Y') like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('suplier_name', function ($query, $keyword) {
                $sql = "supliers.name like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('summary_iso', function ($query, $keyword) {
                $sql = "FORMAT(return_items.summary, 2) like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('user_name', function ($query, $keyword) {
                $sql = "users.name like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->addColumn('action', function ($opname) {
                $btn = '<button data-remote_destroy="' . route('opname.destroy', $opname->id) . '" type="button" class="btn btn-danger btn-sm btnDelete" title="Hapus"><i class="fas fa-trash fa-fw"></i></button> ';
                $btn .= '<button data-remote_show="' . route('opname.show', $opname->id) . '" type="button" class="btn btn-info btn-sm btnOpen" title="Lihat"><i class="fas fa-eye fa-fw"></i></button> ';
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

        $suppliers = Suplier::select('*')
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
            ->where('barcode', 'like', "%$search%")
            ->orWhere('name', 'like', "%$search%")
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
     * Validate request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function validateAddItem(ReturnItemValidateAddItemRequest $request)
    {
        return response()->json([
            'status' => 'valid',
        ]);
    }
}
