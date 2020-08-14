<?php

namespace App\Http\Controllers;

use App\ReturnItem;
use DB;
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
    public function store(Request $request)
    {
        //
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
}
