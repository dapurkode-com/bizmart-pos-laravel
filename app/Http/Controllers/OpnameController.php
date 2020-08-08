<?php

namespace App\Http\Controllers;

use App\Item;
use App\Opname;
use App\OpnameDetail;
use App\StockLog;
use Auth;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OpnameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('opname.index');
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
        try {
            DB::beginTransaction();

            // check is there any record with status ONGO
            $isExist = Opname::where('status', 'ONGO')->exists();

            if ($isExist) {
                DB::rollBack();
                return response()->json([
                    'status' => 'invalid',
                    'pesan' => 'Selesaikan terlebih dahulu opname sebelumnya',
                ]);
            } else {
                Opname::create([
                    'user_id' => auth()->user()->id
                ]);
                DB::commit();

                return response()->json([
                    'status' => 'valid',
                    'pesan' => 'Opname berhasil ditambah',
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeOpnameDetail(Request $request)
    {
        // validate the request
        $validator = Validator::make($request->all(), [
            'items' => 'required',
            'new_stock' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'invalid',
                'validators' => $validator->errors(),
            ]);
        }

        try {
            DB::beginTransaction();

            $itemsObj = json_decode($request->items);

            $isExist = OpnameDetail::where([
                'opname_id' => $request->opname_id,
                'item_id' => $itemsObj->id,
            ])->exists();

            if ($isExist) {
                DB::rollBack();
                return response()->json([
                    'status' => 'exist',
                    'pesan' => 'Barang ini sudah diopname',
                ]);
            } else {
                $item = Item::findOrFail($itemsObj->id);
                $oldStock = $item->stock;
                $newStock = $request->new_stock;

                OpnameDetail::create([
                    'opname_id' => $request->opname_id,
                    'item_id' => $item->id,
                    'old_stock' => $oldStock,
                    'new_stock' => $newStock,
                    'buy_price' => $item->buy_price,
                    'sell_price' => $item->sell_price
                ]);
                DB::commit();

                $isNewStockAndOldStockSame = ($newStock == $oldStock) ? true : false;

                // update status opname
                if($isNewStockAndOldStockSame === true) {
                    $this->updateStatusOnOpname($request->opname_id);
                }

                $opname = Opname::with('user')->findOrFail($request->opname_id);
                return response()->json([
                    'status' => 'valid',
                    'pesan' => 'Barang berhasil diopname',
                    'is_new_stock_and_old_stock_same' => $isNewStockAndOldStockSame,
                    'opname_id' => $request->opname_id,
                    'item' => [
                        'old_stock' => $oldStock,
                        'new_stock' => $newStock,
                        'id' => $item->id,
                        'name' => $item->name,
                        'barcode' => $item->barcode,
                        'buy_price' => $item->buy_price,
                        'sell_price' => $item->sell_price,
                    ],
                    'opname' => $opname,
                    'statusText' => $opname->statusText(),
                    'count_item' => Item::count(),
                    'count_item_in_opname_detail' => OpnameDetail::where('opname_id', $request->opname_id)->count(),
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeStockLog(Request $request)
    {
        // validate the request
        $validator = Validator::make($request->all(), [
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'invalid',
                'validators' => $validator->errors(),
            ]);
        }

        try {
            DB::beginTransaction();
            
            // update opname detail
            OpnameDetail::where([
                'opname_id' => $request->opname_id,
                'item_id' => $request->item_id,
            ])->update([
                'description' => $request->description
            ]);

            // store data to stock log
            $stockDeviation = $request->old_stock - $request->new_stock;
            $inOutPosition = ($stockDeviation > 0) ? 'OUT' : 'IN';
            $stockDeviationAbs = abs($stockDeviation);
            StockLog::create([
                'ref_uniq_id' => $request->ref_uniq_id,
                'cause' => 'ADJ',
                'in_out_position' => $inOutPosition,
                'qty' => $stockDeviationAbs,
                'old_stock' => $request->old_stock,
                'new_stock' => $request->new_stock,
                'buy_price' => $request->buy_price,
                'sell_price' => $request->sell_price,
                'item_id' => $request->item_id
            ]);

            // adjust stock on item
            Item::findOrFail($request->item_id)->update([
                'stock' => $request->new_stock
            ]);

            // update status opname
            $this->updateStatusOnOpname($request->opname_id);

            DB::commit();
            
            $opname = Opname::with('user')->findOrFail($request->opname_id);
            return response()->json([
                'status' => 'valid',
                'pesan' => 'Alasan berhasil disimpan',
                'opname' => $opname,
                'statusText' => $opname->statusText(),
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
        $opname = Opname::with('user')->findOrFail($id);
        return response()->json([
            'opname' => $opname,
            'statusText' => $opname->statusText(),
            'count_item' => Item::count(),
            'count_item_in_opname_detail' => OpnameDetail::where('opname_id', $id)->count(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showOpnameDetail($id)
    {
        $opnameDetail = OpnameDetail::with('item')->findOrFail($id);
        return response()->json([
            'status' => 'valid',
            'pesan' => 'Opname Detail berhasil ditampilkan',
            'opname_detail' => $opnameDetail,
            'opname_id' => $opnameDetail->opname_id,
            'item' => [
                'old_stock' => $opnameDetail->old_stock,
                'new_stock' => $opnameDetail->new_stock,
                'id' => $opnameDetail->item_id,
                'name' => $opnameDetail->item->name,
                'barcode' => $opnameDetail->item->barcode,
                'buy_price' => $opnameDetail->buy_price,
                'sell_price' => $opnameDetail->sell_price,
            ],
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
        try {
            DB::beginTransaction();

            $isIdExistOnOpnameDetails = OpnameDetail::where('opname_id', $id)->exists();

            if ($isIdExistOnOpnameDetails) {
                DB::rollBack();
                return response()->json([
                    'status' => 'invalid',
                    'pesan' => 'Opname yang sudah diproses tidak boleh dihapus',
                ]);
            } else {
                Opname::findOrFail($id)->delete();
                DB::commit();

                return response()->json([
                    'status' => 'valid',
                    'pesan' => 'Opname berhasil dihapus',
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
     * Display a listing of the resource in form of datatable.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function datatables(Request $request)
    {
        $opnames = Opname::select([
                'opnames.id',
                DB::raw("DATE_FORMAT(opnames.created_at, '%d %b %Y') AS created_at_idn"),
                'opnames.uniq_id',
                'opnames.created_by',
                'opnames.status',
                'look_ups.label as status_text',
            ])
            ->leftJoin('look_ups', 'look_ups.key', '=', 'opnames.status');
            
        return datatables()
            ->of($opnames)
            ->addIndexColumn()
            ->addColumn('status_color', function ($opname) {
                if ($opname->status == 'ONGO') {
                    return '<p class="text-warning">' . $opname->status_text . '</p>';
                } else {
                    return '<p class="text-success">' . $opname->status_text . '</p>';
                }
            })
            ->rawColumns(['action', 'status_color'])
            ->filterColumn('created_at_idn', function ($query, $keyword) {
                $sql = "DATE_FORMAT(opnames.created_at, '%d %b %Y') like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->addColumn('action', function ($opname) {
                $btn = '<button data-remote_destroy="' . route('opname.destroy', $opname->id) . '" type="button" class="btn btn-danger btn-sm btnDelete" title="Hapus"><i class="fas fa-trash fa-fw"></i></button> ';

                if ($opname->status == 'ONGO') {
                    $btn .= '<button data-remote_show="' . route('opname.show', $opname->id) . '" data-remote_store_opaname_detail="' . route('opname.store_opname_detail') . '" type="button" class="btn btn-warning btn-sm btnEdit" title="Kerjakan Opname Ini"><i class="fas fa-plus fa-fw"></i></button> ';
                } else {
                    $btn .= '<button data-remote_show="' . route('opname.show', $opname->id) . '" type="button" class="btn btn-info btn-sm btnOpen" title="Lihat Opname Ini"><i class="fas fa-eye fa-fw"></i></button> ';
                }
                return $btn;
            })
            ->toJson();
    }

    /**
     * Display a listing of the resource in form of datatable.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function datatablesOpnameDetail(Request $request)
    {
        $opnameDetails = OpnameDetail::select([
                'opname_details.id',
                DB::raw("DATE_FORMAT(opname_details.updated_at, '%d %b %Y %H:%i:%s') AS updated_at_idn"),
                'opname_details.opname_id',
                'opname_details.item_id',
                'items.barcode',
                'items.name',
                'opname_details.old_stock',
                'opname_details.new_stock',
                'opname_details.buy_price',
                'opname_details.sell_price',
                DB::raw("COALESCE(opname_details.description, '-') AS description"),
            ])
            ->leftJoin('items', 'items.id', '=', 'opname_details.item_id')
            ->where('opname_id', $request->opname_id);

        return datatables()
            ->of($opnameDetails)
            ->addIndexColumn()
            ->filterColumn('updated_at_idn', function ($query, $keyword) {
                $sql = "DATE_FORMAT(opname_details.updated_at, '%d %b %Y %H:%i:%s') like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('description', function ($query, $keyword) {
                $sql = "COALESCE(opname_details.description, '-') like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('barcode', function ($query, $keyword) {
                $sql = "items.barcode like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('name', function ($query, $keyword) {
                $sql = "items.name like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->addColumn('action', function ($opnameDetail) {
                if($opnameDetail->description == '-'){
                    $isNewStockAndOldStockSame = ($opnameDetail->new_stock == $opnameDetail->old_stock) ? true : false;
                    if($isNewStockAndOldStockSame){
                        $btn = '-';
                    }
                    else{
                        $btn = '<button type="button" data-remote_show_opname_detail="'.route('opname.show_opname_detail', $opnameDetail->id).'" class="btn btn-warning btn-sm btnEdit" title="Tambahkan alasan perbedaan stock opname"><i class="fas fa-plus"></i></button> ';
                    }
                }
                else{
                    $btn = '-';
                }
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
    public function getItems(Request $request)
    {
        $page = $request->page;
        $search = $request->term;
        $limit = 25;
        $offset = ($page - 1) * $limit;

        $items = Item::orderby('name', 'asc')
            ->select(['*'])
            ->where('barcode', 'like', '%' . $search . '%')
            ->orWhere('name', 'like', '%' . $search . '%')
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
     * Private
     * Update status field on opnames
     *
     * @param $opname_id
     */
    private function updateStatusOnOpname($opname_id)
    {
        $count_item = Item::count();
        $count_item_in_opname_detail = OpnameDetail::where('opname_id', $opname_id)->count();

        if($count_item == $count_item_in_opname_detail) {
            Opname::where('id', $opname_id)
                ->update([
                    'status' => 'DONE'
                ]);
        }
    }
}
