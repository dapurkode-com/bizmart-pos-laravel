<?php

namespace App\Http\Controllers;

use App\Opname;
use App\OpnameDetail;
use Auth;
use DB;
use Exception;
use Illuminate\Http\Request;

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

            // check is there any record with status on going
            $isExist = Opname::where('status', 'On Going')->exists();

            if($isExist){
                return response()->json([
                    'status' => 'invalid',
                    'pesan' => 'Selesaikan terlebih dahulu opname sebelumnya',
                ]);
            } else{
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json([
            'opnames' => Opname::findOrFail($id)
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

            if($isIdExistOnOpnameDetails){
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
            'id',
            DB::raw("DATE_FORMAT(`created_at`,'%d %b %Y') AS `created_at_idn`"),
            'uniq_id',
            'created_by',
            'status',
        ]);
        return datatables()
            ->of($opnames)
            ->addIndexColumn()
            ->addColumn('action', function ($opname) {
                $btn = '';
                $btn = '<button data-remote_destroy="' . route('opname.destroy', $opname->id) . '" type="button" class="btn btn-danger btn-sm btnDelete" title="Hapus"><i class="fas fa-trash"></i></button> ';
                $btn .= '<button data-remote_show="' . route('opname.show', $opname->id) . '" type="button" class="btn btn-warning btn-sm btnEdit" title="Kerjakan Opname Ini"><i class="fas fa-plus"></i></button> ';
                return $btn;
            })
            ->addColumn('status_color', function ($opname) {
                if($opname->status == 'On Going'){
                    return '<p class="text-warning">'.$opname->status.'</p>';
                }else{
                    return '<p class="text-success">'.$opname->status.'</p>';
                }
            })
            ->rawColumns(['action', 'status_color'])
            ->filterColumn('created_at_idn', function($query, $keyword) {
                $sql = "DATE_FORMAT(`created_at`,'%d %b %Y') like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->toJson();
    }
}
