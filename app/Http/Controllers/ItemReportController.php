<?php

namespace App\Http\Controllers;

use App\Item;
use Dompdf\Dompdf;
use App\SystemParam;
use App\Helpers\BadgeHelper;
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
        $mrch_name = SystemParam::where('param_code', 'MRCH_NAME')->first();
        $mrch_addr = SystemParam::where('param_code', 'MRCH_ADDR')->first();
        $mrch_phone = SystemParam::where('param_code', 'MRCH_PHONE')->first();

        $items = Item::with('categories', 'unit')->selectRaw('distinct items.*')->where('is_stock_active', 1)->get();
        return response()->view('item_report.index', compact('mrch_name', 'mrch_addr', 'mrch_phone', 'items'));
    }

    public function generatePdf()
    {
        $items = Item::with('categories', 'unit')->selectRaw('distinct items.*')->where('is_stock_active', 1)->get();
        $mrch_name = SystemParam::where('param_code', 'MRCH_NAME')->first();
        $mrch_addr = SystemParam::where('param_code', 'MRCH_ADDR')->first();
        $mrch_phone = SystemParam::where('param_code', 'MRCH_PHONE')->first();

        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('item_report.pdf', compact('items', 'mrch_name', 'mrch_addr', 'mrch_phone'))->render());
        $dompdf->setPaper('A5', 'landscape');
        $dompdf->render();
        $dompdf->stream("Laporan Stok.pdf", array("Attachment" => true));
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
