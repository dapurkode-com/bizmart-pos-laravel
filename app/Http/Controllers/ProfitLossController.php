<?php

namespace App\Http\Controllers;

use DB;
use App\Item;
use App\Sell;
use App\StockLog;
use Carbon\Carbon;
use Dompdf\Dompdf;
use App\SystemParam;
use App\BuyPaymentHs;
use App\OtherExpense;
use App\SellPaymentHs;
use Illuminate\Http\Request;

class ProfitLossController extends Controller
{
    public function index(Request $request)
    {
        $mrch_name = SystemParam::where('param_code', 'MRCH_NAME')->first();
        $mrch_addr = SystemParam::where('param_code', 'MRCH_ADDR')->first();
        $mrch_phone = SystemParam::where('param_code', 'MRCH_PHONE')->first();

        $month = +$request->input('month', date('m'));
        $year  = +$request->input('year', date('Y'));

        $date_start = Carbon::parse("$year-$month")->startOfMonth();
        $date_end   = Carbon::parse("$year-$month")->endOfMonth();

        $sellSummary    = SellPaymentHs::whereBetween('created_at', [$date_start, $date_end])->sum('amount');
        $buySummary     = BuyPaymentHs::whereBetween('created_at', [$date_start, $date_end])->sum('amount');

        $stockOld = Item::select(DB::raw("(
            SELECT sl.new_stock FROM stock_logs sl WHERE sl.item_id = items.id AND sl.created_at < '" . $date_start->format('Y-m-d') . " 00:00:00' ORDER BY sl.created_at LIMIT 1
        ) old_stock,
        (
            SELECT sl.buy_price FROM stock_logs sl WHERE sl.item_id = items.id AND sl.created_at < '" . $date_start->format('Y-m-d') . " 00:00:00' ORDER BY sl.created_at LIMIT 1
        ) old_buy_price, items.* "))
            ->get();

        $stockValueOld = 0;

        foreach ($stockOld as $data) {
            if ($data->old_stock != null) $stockValueOld += $data->old_stock * $data->old_buy_price;
            else $stockValueOld += $data->stock * $data->buy_price;
        }

        $stockNew = Item::select(DB::raw("(
            SELECT sl.new_stock FROM stock_logs sl WHERE sl.item_id = items.id AND sl.created_at <= '" . $date_end->format('Y-m-d') . " 23:59:59' ORDER BY sl.created_at LIMIT 1
        ) old_stock,
        (
            SELECT sl.buy_price FROM stock_logs sl WHERE sl.item_id = items.id AND sl.created_at <= '" . $date_end->format('Y-m-d') . " 23:59:59' ORDER BY sl.created_at LIMIT 1
        ) old_buy_price, items.* "))
            ->get();

        $stockValueNew = 0;

        foreach ($stockNew as $data) {
            if ($data->old_stock != null) $stockValueNew += $data->old_stock * $data->old_buy_price;
            else $stockValueNew += $data->stock * $data->buy_price;
        }

        $otherExpenseSummary = OtherExpense::whereBetween('created_at', [$date_start, $date_end])->get();

        $months = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];

        return response()->view('profit_loss.index', compact(
            'mrch_name',
            'mrch_addr',
            'mrch_phone',
            'month',
            'year',
            'sellSummary',
            'buySummary',
            'stockValueOld',
            'stockValueNew',
            'otherExpenseSummary',
            'months'
        ));
    }

    public function generatePdf(Request $request)
    {
        $mrch_name = SystemParam::where('param_code', 'MRCH_NAME')->first();
        $mrch_addr = SystemParam::where('param_code', 'MRCH_ADDR')->first();
        $mrch_phone = SystemParam::where('param_code', 'MRCH_PHONE')->first();

        $month = +$request->input('month', date('m'));
        $year  = +$request->input('year', date('Y'));

        $date_start = Carbon::parse("$year-$month")->startOfMonth();
        $date_end   = Carbon::parse("$year-$month")->endOfMonth();

        $sellSummary    = SellPaymentHs::whereBetween('created_at', [$date_start, $date_end])->sum('amount');
        $buySummary     = BuyPaymentHs::whereBetween('created_at', [$date_start, $date_end])->sum('amount');

        $stockOld = Item::select(DB::raw("(
            SELECT sl.new_stock FROM stock_logs sl WHERE sl.item_id = items.id AND sl.created_at < '" . $date_start->format('Y-m-d') . " 00:00:00' ORDER BY sl.created_at LIMIT 1
        ) old_stock,
        (
            SELECT sl.buy_price FROM stock_logs sl WHERE sl.item_id = items.id AND sl.created_at < '" . $date_start->format('Y-m-d') . " 00:00:00' ORDER BY sl.created_at LIMIT 1
        ) old_buy_price, items.* "))
            ->get();

        $stockValueOld = 0;

        foreach ($stockOld as $data) {
            if ($data->old_stock != null) $stockValueOld += $data->old_stock * $data->old_buy_price;
            else $stockValueOld += $data->stock * $data->buy_price;
        }

        $stockNew = Item::select(DB::raw("(
            SELECT sl.new_stock FROM stock_logs sl WHERE sl.item_id = items.id AND sl.created_at <= '" . $date_end->format('Y-m-d') . " 23:59:59' ORDER BY sl.created_at LIMIT 1
        ) old_stock,
        (
            SELECT sl.buy_price FROM stock_logs sl WHERE sl.item_id = items.id AND sl.created_at <= '" . $date_end->format('Y-m-d') . " 23:59:59' ORDER BY sl.created_at LIMIT 1
        ) old_buy_price, items.* "))
            ->get();

        $stockValueNew = 0;

        foreach ($stockNew as $data) {
            if ($data->old_stock != null) $stockValueNew += $data->old_stock * $data->old_buy_price;
            else $stockValueNew += $data->stock * $data->buy_price;
        }

        $otherExpenseSummary = OtherExpense::whereBetween('created_at', [$date_start, $date_end])->get();

        $months = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];

        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('profit_loss.pdf', compact(
            'mrch_name',
            'mrch_addr',
            'mrch_phone',
            'month',
            'year',
            'sellSummary',
            'buySummary',
            'stockValueOld',
            'stockValueNew',
            'otherExpenseSummary',
            'months'
        ))->render());
        $dompdf->setPaper('A5', 'landscape');
        $dompdf->render();
        $dompdf->stream("Laporan Laba Rugi.pdf", array("Attachment" => true));
    }
}
