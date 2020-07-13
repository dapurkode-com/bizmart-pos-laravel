<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use Illuminate\Http\Request;

/**
 * CategoryController
 *
 * @package Controller
 * @author Satya Wibawa <i.g.b.n.satyawibawa@gmail.com>
 */
class CategoryController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('category.index');
    }

    public function show(Category $category)
    {
        return response()->json($category);
    }

    /**
     * @param \App\Http\Requests\CategoryStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreRequest $request)
    {
        $category = Category::create($request->only('name'));

        $request->session()->flash('category.name', $category->name);

        return redirect()->route('category.index');
    }

    /**
     * @param \App\Http\Requests\CategoryUpdateRequest $request
     * @param \App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $category->update($request->only('name'));

        $request->session()->flash('category.name', $category->name);

        return redirect()->route('category.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Category $category)
    {
        $request->session()->flash('category.name', $category->name);

        $category->delete();

        return redirect()->route('category.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     **/
    public function datatables(Request $request)
    {
        $data = Category::query();

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($category) {
                $btn = "<button data-remote='" . route('category.show', $category->id) . "' type=button' class='btn btn-sm btn-danger delete' title='Hapus Data'><i class='fa fa-trash'></i></button> ";
                $btn .= "<button data-remote='" . route('category.show', $category->id) . "' class='edit btn btn-warning btn-sm' data-toggle='modal' data-target='#editCategory' title='Update Data'><i class='fa fa-edit'></i></button>";

                return $btn;
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
