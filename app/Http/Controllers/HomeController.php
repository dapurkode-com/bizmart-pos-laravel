<?php

namespace App\Http\Controllers;

use DB;
use App\Buy;
use App\Item;
use App\Sell;
use App\StockLog;
use Carbon\Carbon;
use App\Charts\SimpleChart;
use Illuminate\Http\Request;

/**
 * HomeController
 *
 * @package Controller
 * @author Satya Wibawa <i.g.b.n.satyawibawa@gmail.com>
 */
class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // TODO: Check SQL Summarize
        $badge_data['count_today_sell'] = Sell::whereDate('created_at', '=', Carbon::today()->toDateString())->count();
        $badge_data['count_today_buy'] = Buy::whereDate('created_at', '=', Carbon::today()->toDateString())->count();
        $badge_data['count_today_debt'] = Buy::where('buy_status', 'DE')->count();
        $badge_data['count_today_receiveable'] = Sell::where('sell_status', 'RE')->count();

        $minItemStock = Item::where('is_stock_active', 1)->whereRaw('stock < min_stock')->limit(10)->get();
        $lastSell = Sell::orderBy('created_at', 'desc')->limit(10)->get();
        $lastBuy = Buy::orderBy('created_at', 'desc')->limit(10)->get();

        // Chart Weekly
        $weeklySellData =    Sell::select(DB::raw("
            date_trunc('week', created_at) weekly,
            COUNT(id) AS count,
            date_trunc('week', created_at)::date AS start_date,
            (date_trunc('week', created_at)+ '6 days'::interval)::date AS end_date
        "))
            ->groupBy(DB::raw('created_at, weekly'))
            ->orderByRaw('weekly desc')
            ->limit(5)
            ->get();

        $labels = [];
        foreach ($weeklySellData as $key => $data) {
            $startDate = Carbon::parse($data->start_date)->translatedFormat('d M y');
            $endDate = Carbon::parse($data->end_date)->translatedFormat('d M y');
            array_push($labels, "$startDate - $endDate");
        }

        $chartWeekly = new SimpleChart();
        $chartWeekly->labels($labels);
        $chartWeekly->dataset("Jumlah", "bar", $weeklySellData->pluck(['count']))->color("#DC143C")->backgroundColor("#FFA07A");

        // Chart Monthly
        $monthlySellData =    Sell::select(DB::raw("
            date_trunc('month', created_at) monthly,
            extract(month from created_at) AS month,
            COUNT(id) AS count
        "))
            ->groupBy(DB::raw('created_at, monthly'))
            ->orderByRaw('monthly DESC')
            ->limit(5)
            ->get();

        $chartMonthly = new SimpleChart();
        $chartMonthly->labels($monthlySellData->pluck(['month']));
        $chartMonthly->dataset("Jumlah", "bar", $monthlySellData->pluck(['count']))->color("#00BFFF")->backgroundColor("#F0F8FF");

        // Best Seller Item
        $bestSellerItems = StockLog::select(DB::raw('
            MIN(items.name) as item_name,
            SUM(qty) as qty
        '))
            ->join('items', 'stock_logs.item_id', '=', 'items.id')

            ->where(DB::raw('extract(month from stock_logs.created_at)'), date('n'))
            ->where(DB::raw('extract(year from stock_logs.created_at)'), date('Y'))
            ->where('cause', 'SELL')
            ->groupBy('item_id')
            ->orderByRaw('SUM(qty) DESC')
            ->limit(5)
            ->get();

        $chartBestSeller = new SimpleChart();
        $chartBestSeller->labels($bestSellerItems->pluck(['item_name']));
        $chartBestSeller->dataset("Jumlah", "bar", $bestSellerItems->pluck(['qty']))->color("#28a745")->backgroundColor("#71d687");

        // Most Retur Item
        $mostReturItems = StockLog::select(DB::raw('
            MIN(items.name) as item_name,
            SUM(qty) as qty
        '))
            ->join('items', 'stock_logs.item_id', '=', 'items.id')
            ->where(DB::raw('extract(month from stock_logs.created_at)'), date('n'))
            ->where(DB::raw('extract(year from stock_logs.created_at)'), date('Y'))
            ->where('cause', 'RTR')
            ->groupBy('item_id')
            ->orderByRaw('SUM(qty) DESC')
            ->limit(5)
            ->get();

        $chartMostRetur = new SimpleChart();
        // $chartMostRetur->title('ATK Terbanyak Retur', 25, "rgb(0, 0, 0)", true, 'Source Sans Pro');
        $chartMostRetur->labels($mostReturItems->pluck(['item_name']));
        $chartMostRetur->dataset("Jumlah", "bar", $mostReturItems->pluck(['qty']))->color("#DC143C")->backgroundColor("#f0ac8c");


        return response()->view('home', compact('badge_data', 'minItemStock', 'lastSell', 'lastBuy', 'chartWeekly', 'chartMonthly', 'chartBestSeller', 'chartMostRetur'));
    }
}
