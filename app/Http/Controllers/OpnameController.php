<?php

namespace App\Http\Controllers;

use App\Opname;
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
        // store the request
        try {
            DB::beginTransaction();
            Opname::create([
                'user_id' => auth()->user()->id
            ]);
            DB::commit();

            return response()->json([
                'status' => 'valid',
                'pesan' => 'Opname berhasil ditambah',
            ]);
        } catch (Exception $exc) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'pesan' => $exc->getMessage(),
            ]);
        }
        // store the request
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
        $opnames = Opname::query();
        return datatables()
            ->of($opnames)
            ->addIndexColumn()
            ->addColumn('action', function ($opname) {
                $btn = '';
                // $btn = '<button data-remote_destroy="' . route('user.destroy', $user->id) . '" type="button" class="btn btn-danger btn-sm btnDelete" title="Hapus"><i class="fas fa-trash"></i></button> ';
                // $btn .= '<button data-remote_show="' . route('user.show', $user->id) . '" data-remote_update="' . route('user.update', $user->id) . '" type="button" class="btn btn-warning btn-sm btnEdit" title="Edit"><i class="fas fa-pencil-alt"></i></button> ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
