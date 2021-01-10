<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierStoreRequest;
use App\Http\Requests\SupplierUpdateRequest;
use App\Supplier;
use Illuminate\Http\Request;

/**
 * SupplierController
 *
 * @package Controller
 * @author Satya Wibawa <i.g.b.n.satyawibawa@gmail.com>
 */
class SupplierController extends Controller
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
        return view('supplier.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('supplier.create');
    }

    /**
     * @param \App\Http\Requests\SupplierStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierStoreRequest $request)
    {
        $supplier = Supplier::create($request->all());

        $request->session()->flash('supplier.name', $supplier->name);

        return redirect()->route('supplier.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Supplier $supplier)
    {
        return view('supplier.show', compact('supplier'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Supplier $supplier)
    {
        return view('supplier.edit', compact('supplier'));
    }

    /**
     * @param \App\Http\Requests\SupplierUpdateRequest $request
     * @param \App\Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierUpdateRequest $request, Supplier $supplier)
    {
        $supplier->update($request->only(['name', 'address', 'phone', 'description']));

        $request->session()->flash('supplier.name', $supplier->name);

        return redirect()->route('supplier.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Supplier $supplier)
    {
        $request->session()->flash('supplier.name', $supplier->name);

        $supplier->delete();

        return redirect()->route('supplier.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Supplier $supplier
     * @return \Illuminate\Http\Response
     **/
    public function datatables(Request $request)
    {
        $data = Supplier::query();

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($supplier) {
                $btn = '';
                // $btn = "<button data-remote='" . route('supplier.show', $supplier->slug) . "' type='button' class='btn btn-sm btn-danger' title='Hapus Data'><i class='fa fa-trash'></i></button> ";
                $btn .= " <a href='" . route('supplier.edit', $supplier->slug) . "' class='edit btn btn-warning btn-sm' title='Ubah Data'><i class='fa fa-edit'></i></a>";

                return $btn;
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
