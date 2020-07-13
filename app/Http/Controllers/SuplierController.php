<?php

namespace App\Http\Controllers;

use App\Http\Requests\SuplierStoreRequest;
use App\Http\Requests\SuplierUpdateRequest;
use App\Suplier;
use Illuminate\Http\Request;

/**
 * SuplierController
 *
 * @package Controller
 * @author Satya Wibawa <i.g.b.n.satyawibawa@gmail.com>
 */
class SuplierController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('suplier.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('suplier.create');
    }

    /**
     * @param \App\Http\Requests\SuplierStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SuplierStoreRequest $request)
    {
        $suplier = Suplier::create($request->all());

        $request->session()->flash('suplier.name', $suplier->name);

        return redirect()->route('suplier.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Suplier $suplier
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Suplier $suplier)
    {
        return view('suplier.show', compact('suplier'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Suplier $suplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Suplier $suplier)
    {
        return view('suplier.edit', compact('suplier'));
    }

    /**
     * @param \App\Http\Requests\SuplierUpdateRequest $request
     * @param \App\Suplier $suplier
     * @return \Illuminate\Http\Response
     */
    public function update(SuplierUpdateRequest $request, Suplier $suplier)
    {
        $suplier->update($request->only(['name', 'address', 'phone', 'description']));

        $request->session()->flash('suplier.name', $suplier->name);

        return redirect()->route('suplier.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Suplier $suplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Suplier $suplier)
    {
        $request->session()->flash('suplier.name', $suplier->name);

        $suplier->delete();

        return redirect()->route('suplier.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Suplier $suplier
     * @return \Illuminate\Http\Response
     **/
    public function datatables(Request $request)
    {
        $data = Suplier::query();

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($suplier) {
                $btn = "<button data-remote='" . route('suplier.show', $suplier->slug) . "' type='button' class='btn btn-sm btn-danger' title='Hapus Data'><i class='fa fa-trash'></i></button> ";
                $btn .= " <a href='" . route('suplier.edit', $suplier->slug) . "' class='edit btn btn-warning btn-sm' title='Ubah Data'><i class='fa fa-edit'></i></a>";

                return $btn;
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
