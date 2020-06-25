<?php

namespace App\Http\Controllers;

use App\Item;
use App\Unit;
use App\LookUp;
use App\Category;
use App\Helpers\BadgeHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ItemStoreRequest;
use App\Http\Requests\ItemUpdateRequest;

/**
 * ItemController
 *
 * @package Controller
 * @author Satya Wibawa <i.g.b.n.satyawibawa@gmail.com>
 */
class ItemController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('item.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $options['STCK_ACTV'] = LookUp::where('group_code', 'STCK_ACTV')->get(); //option untuk is_stock_active
        $options['SLL_PRC_DTRM'] = LookUp::where('group_code', 'SLL_PRC_DTRM')->get(); //option untuk sell_price_determinant
        $options['UNITS'] = Unit::all(); //option satuan barang
        return view('item.create', compact('options'));
    }

    /**
     * @param \App\Http\Requests\ItemStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ItemStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            //Menyimpan data barang
            $item = Item::create($request->only([
                'name',
                'barcode',
                'description',
                'is_stock_active',
                'min_stock',
                'profit',
                'sell_price_determinant',
                'margin',
                'markup',
                'unit_id',
                'buy_price',
                'sell_price',
                'stock'
            ]));

            //Menyimpan kategori barang
            $categories_list = [];
            $categories      = explode(',', $request->categories);
            if ($categories != null) {
                foreach ($categories as $value) {
                    $category = Category::firstOrCreate([
                        'name' => strtolower(trim($value)),
                    ]);

                    array_push($categories_list, $category->id);
                }
            }
            if ($categories_list) {
                $item->categories()->sync($categories_list);
            }

            DB::commit();
            $request->session()->flash('item.name', $item->name);
            return redirect()->route('item.index');
        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('message', $exception)->withInput();
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Item $item
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Item $item)
    {
        return view('item.show', compact('item'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Item $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Item $item)
    {
        $categories = join(',', $item->categories()->get()->pluck('name')->toArray());

        $options['STCK_ACTV'] = LookUp::where('group_code', 'STCK_ACTV')->get();
        $options['SLL_PRC_DTRM'] = LookUp::where('group_code', 'SLL_PRC_DTRM')->get();
        $options['UNITS'] = Unit::all();

        return view('item.edit', compact('item', 'categories', 'options'));
    }

    /**
     * @param \App\Http\Requests\ItemUpdateRequest $request
     * @param \App\Item $item
     * @return \Illuminate\Http\Response
     */
    public function update(ItemUpdateRequest $request, Item $item)
    {
        try {
            DB::beginTransaction();
            $item->update($request->only([
                'name',
                'barcode',
                'description',
                'is_stock_active',
                'min_stock',
                'profit',
                'sell_price_determinant',
                'margin',
                'markup',
                'unit_id',
                'buy_price',
                'sell_price',
                'stock'
            ]));

            $categories_list = [];
            $categories      = explode(',', $request->categories);
            if ($categories != null) {
                foreach ($categories as $value) {
                    $category = Category::firstOrCreate([
                        'name' => strtolower(trim($value)),
                    ]);

                    array_push($categories_list, $category->id);
                }
            }
            if ($categories_list) {
                $item->categories()->sync($categories_list);
            }

            DB::commit();
            $request->session()->flash('item.name', $item->name);
            return redirect()->route('item.index');
        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('message', $exception)->withInput();
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Item $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Item $item)
    {
        $request->session()->flash('item.name', $item->name);

        $item->delete();

        return redirect()->route('item.index');
    }

    public function datatables(Request $request)
    {
        $data = Item::with('categories')->selectRaw('distinct items.*');

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->addColumn('categories', function ($item) {
                return $item->categories->map(function ($item) {
                    return join('', ["<span class='badge ", BadgeHelper::getBadgeClass($item->id), "'>", $item->name, '</span>']); //Customize warna badge
                })->implode(' ');
            })
            ->addColumn('action', function ($item) {
                $btn = "";
                $btn .= "<button data-remote=\"" . route('item.show', $item->slug) . "\" type=\"button\" class=\"btn btn-sm btn-danger\"><i class=\"fa fa-trash\"></i> Hapus</button> ";
                $btn .= " <a href=\"" . route('item.edit', $item->slug) . "\" class=\"edit btn btn-warning btn-sm\"><i class=\"fa fa-edit\"></i> Ubah</a> ";
                $btn .= " <a href=\"" . route('item.show', $item->slug) . "\" class=\" btn btn-info btn-sm\"><i class=\"fa fa-eye\"></i> Lihat</a> ";

                return $btn;
            })
            ->rawColumns(['action', 'categories', 'barcode'])
            ->make(true);
    }
}
