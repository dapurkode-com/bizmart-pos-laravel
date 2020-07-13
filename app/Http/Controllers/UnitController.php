<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitStoreRequest;
use App\Http\Requests\UnitUpdateRequest;
use App\Unit;
use Illuminate\Http\Request;

/**
 * UnitController
 *
 * @package Controller
 * @author Satya Wibawa <i.g.b.n.satyawibawa@gmail.com>
 */
class UnitController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('unit.index');
    }

    public function show(Unit $unit)
    {
        return response()->json($unit);
    }

    /**
     * @param \App\Http\Requests\UnitStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnitStoreRequest $request)
    {
        $unit = Unit::create($request->only(['name', 'description']));

        $request->session()->flash('unit.name', $unit->name);

        return redirect()->route('unit.index');
    }

    /**
     * @param \App\Http\Requests\UnitUpdateRequest $request
     * @param \App\Unit $unit
     * @return \Illuminate\Http\Response
     */
    public function update(UnitUpdateRequest $request, Unit $unit)
    {
        $unit->update($request->only(['name', 'description']));

        $request->session()->flash('unit.name', $unit->name);

        return redirect()->route('unit.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Unit $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Unit $unit)
    {
        $request->session()->flash('unit.name', $unit->name);

        $unit->delete();

        return redirect()->route('unit.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     **/
    public function datatables(Request $request)
    {
        $data = Unit::query();

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($unit) {
                $btn = "<button data-remote='" . route('unit.show', $unit->id) . "' type='button' class='btn btn-sm btn-danger delete' title='Hapus Data'><i class='fa fa-trash'></i></button> ";
                $btn .= "<button data-remote='" . route('unit.show', $unit->id) . "' class='edit btn btn-warning btn-sm' data-toggle='modal' data-target='#editUnit' title='Ubah Data'><i class='fa fa-edit'></i></button>";

                return $btn;
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
