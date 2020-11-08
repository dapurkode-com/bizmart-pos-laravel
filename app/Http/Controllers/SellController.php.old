<?php

namespace App\Http\Controllers;

use App\Sell;
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
        return response()->view('sell.index');
    }

    public function list()
    {
        return response()->view('sell.list');
    }

    public function datatables(Request $request)
    {
        $sells = Sell::leftJoin('members','members.id','=','sells.id')->select([
            'sells.*',
            'members.name',
            'members.phone',

        ]);
        return datatables()
            ->of($sells)
            ->addIndexColumn()
            ->addColumn('action', function ($sell) {
                $btn     = '<div class="btn-group">';
                $btn    .= '<button data-remote_show="' . route('sell.show', $sell->id) . '" type="button" class="btn btn-default btn-sm btnDetail" title="Detail"><i class="fas fa-folder-open"></i></button> ';
                $btn    .= '<button data-remote_show="' . route('sell.show', $sell->id) . '" data-remote_update="' . route('sell.update', $sell->id) . '" type="button" class="btn btn-default btn-sm btnEdit" title="Edit"><i class="fas fa-pencil-alt"></i></button> ';
                $btn    .= '<button data-remote_destroy="' . route('sell.destroy', $sell->id) . '" type="button" class="btn btn-default btn-sm btnDelete" title="Hapus"><i class="fas fa-trash"></i></button> ';
                $btn    .= '</div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->toJson();
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
}
