<?php

namespace App\Http\Controllers;

use App\Item;
use App\Opname;
use App\OpnameDetail;
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
            'new_stock' => 'required|number',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'invalid',
                'validators' => $validator->errors(),
            ]);
        }

        try {
            DB::beginTransaction();

            // $isExist = Opname::where('status', 'ONGO')->exists();
            $isExist = false;

            if ($isExist) {
                DB::rollBack();
                return response()->json([
                    'status' => 'invalid',
                    'pesan' => 'Selesaikan terlebih dahulu opname sebelumnya',
                ]);
            } else {
                $itemsObj = json_decode($request->items);
                dd($itemsObj);
                OpnameDetail::create([
                    'opname_id' => $request->opname_id,
                    'item_id' => $itemsObj->id,
                    'old_stock' => $itemsObj->stock,
                    'new_stock' => $request->new_stock,
                    'buy_price' => $itemsObj->buy_price,
                    'sell_price' => $itemsObj->sell_price
                ]);
                DB::commit();

                return response()->json([
                    'status' => 'valid',
                    'pesan' => 'Barang berhasil diopname',
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
        $opname = Opname::with('user')->findOrFail($id);
        return response()->json([
            'opname' => $opname,
            'statusText' => $opname->statusText(),
            'count_item' => Item::count(),
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
        $opnames = Opname::leftJoin('look_ups', 'look_ups.key', '=', 'opnames.status')
            ->select([
                'opnames.id',
                DB::raw("DATE_FORMAT(opnames.created_at, '%d %b %Y') AS created_at_idn"),
                'opnames.uniq_id',
                'opnames.created_by',
                'opnames.status',
                'look_ups.label as status_text',
            ]);
        return datatables()
            ->of($opnames)
            ->addIndexColumn()
            ->addColumn('action', function ($opname) {
                $btn = '';
                $btn = '<button data-remote_destroy="' . route('opname.destroy', $opname->id) . '" type="button" class="btn btn-danger btn-sm btnDelete" title="Hapus"><i class="fas fa-trash"></i></button> ';
                $btn .= '<button data-remote_show="' . route('opname.show', $opname->id) . '" data-remote_store_opaname_detail="' . route('opname.store_opname_detail') . '" type="button" class="btn btn-warning btn-sm btnEdit" title="Kerjakan Opname Ini"><i class="fas fa-plus"></i></button> ';
                return $btn;
            })
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
}
