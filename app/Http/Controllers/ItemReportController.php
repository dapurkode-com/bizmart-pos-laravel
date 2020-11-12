<?php

namespace App\Http\Controllers;

use App\Helpers\BadgeHelper;
use App\Item;
use Illuminate\Http\Request;

class ItemReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->view('item_report.index');
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

    public function itemDatatables(Request $request)
    {
        $data = Item::with('categories', 'unit')->selectRaw('distinct items.*');

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->addColumn('categories', function ($item) {
                return $item->categories->map(function ($item) {
                    return join('', ["<span class='badge ", BadgeHelper::getBadgeClass($item->id), "'>", ucfirst($item->name), '</span>']); //Customize warna badge
                })->implode(' ');
            })
            ->rawColumns(['action', 'categories', 'barcode'])
            ->make(true);
    }
}
