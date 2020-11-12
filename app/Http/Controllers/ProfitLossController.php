<?php

namespace App\Http\Controllers;

use App\BuyPaymentHs;
use App\Item;
use App\OtherExpense;
use App\Sell;
use App\SellPaymentHs;
use App\StockLog;
use Carbon\Carbon;
use App\SystemParam;
use DB;
use Illuminate\Http\Request;

class ProfitLossController extends Controller
{
    public function index(Request $request)
    {
        $mrch_name = SystemParam::where('param_code', 'MRCH_NAME')->first();
        $mrch_addr = SystemParam::where('param_code', 'MRCH_ADDR')->first();
        $mrch_phone = SystemParam::where('param_code', 'MRCH_PHONE')->first();

        $month = $request->input('month', date('m'));
        $year  = $request->input('year', date('Y'));

        $date_start = Carbon::parse("$year-$month")->startOfMonth();
        $date_end   = Carbon::parse("$year-$month")->endOfMonth();

        $sellSummary    = SellPaymentHs::whereBetween('created_at', [$date_start, $date_end])->sum('amount');
        $buySummary     = BuyPaymentHs::whereBetween('created_at', [$date_start, $date_end])->sum('amount');

        $stockOld = Item::select(DB::raw("(
            SELECT sl.new_stock FROM stock_logs sl WHERE sl.item_id = items.`id` AND sl.created_at < '" . $date_start->format('Y-m-d') . " 00:00:00' ORDER BY sl.created_at LIMIT 1
        ) old_stock,
        (
            SELECT sl.sell_price FROM stock_logs sl WHERE sl.item_id = items.`id` AND sl.created_at < '" . $date_start->format('Y-m-d') . " 00:00:00' ORDER BY sl.created_at LIMIT 1
        ) old_sell_price, items.* "))
            ->get();

        $stockValueOld = 0;

        foreach ($stockOld as $data) {
            if ($data->old_stock != null) $stockValueOld += $data->old_stock * $data->old_sell_price;
            else $stockValueOld += $data->stock * $data->sell_price;
        }

        $stockNew = Item::select(DB::raw("(
            SELECT sl.new_stock FROM stock_logs sl WHERE sl.item_id = items.`id` AND sl.created_at <= '" . $date_end->format('Y-m-d') . " 23:59:59' ORDER BY sl.created_at LIMIT 1
        ) old_stock,
        (
            SELECT sl.sell_price FROM stock_logs sl WHERE sl.item_id = items.`id` AND sl.created_at <= '" . $date_end->format('Y-m-d') . " 23:59:59' ORDER BY sl.created_at LIMIT 1
        ) old_sell_price, items.* "))
            ->get();

        $stockValueNew = 0;

        foreach ($stockNew as $data) {
            if ($data->old_stock != null) $stockValueNew += $data->old_stock * $data->old_sell_price;
            else $stockValueNew += $data->stock * $data->sell_price;
        }

        $otherExpenseSummary = OtherExpense::whereBetween('created_at', [$date_start, $date_end])->sum('summary');

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
            'otherExpenseSummary'
        ));
    }
}