<?php

namespace App\Http\Controllers;

use App\Buy;
use App\Charts\SimpleChart;
use App\Item;
use App\Sell;
use Carbon\Carbon;
use DB;
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
        $badge_data['count_today_sell'] = Sell::whereDate('created_at', '=', Carbon::today()->toDateString())->count();
        $badge_data['count_today_buy'] = Buy::whereDate('created_at', '=', Carbon::today()->toDateString())->count();
        $badge_data['count_today_debt'] = Buy::where('buy_status', 'DE')->count();
        $badge_data['count_today_receiveable'] = Sell::where('sell_status', 'RE')->count();

        $minItemStock = Item::where('is_stock_active', 1)->whereRaw('stock < min_stock')->limit(10)->get();
        $lastSell = Sell::orderBy('created_at', 'desc')->limit(10)->get();
        $lastBuy = Buy::orderBy('created_at', 'desc')->limit(10)->get();

        // Chart Weekly
        $weeklySellData =    Sell::select(DB::raw('
            WEEK(created_at) AS `week`,
            COUNT(id) AS `count`,
            DATE(MAX(created_at) + INTERVAL (1 - DAYOFWEEK(MAX(created_at))) DAY) AS start_date,
            DATE(MAX(created_at) + INTERVAL (7 - DAYOFWEEK(MAX(created_at))) DAY) AS end_date
        '))
            ->groupBy(DB::raw('WEEK(created_at)'))
            ->orderBy(DB::raw('WEEK(created_at)'), 'DESC')
            ->limit(5)
            ->get();

        $labels = [];
        foreach ($weeklySellData as $key => $data) {
            $startDate = Carbon::parse($data->start_date)->format('d M y');
            $endDate = Carbon::parse($data->end_date)->format('d M y');
            array_push($labels, "$startDate - $endDate");
        }

        $chartWeekly = new SimpleChart();
        $chartWeekly->title('Penjualan Mingguan', 25, "rgb(0, 0, 0)", true, 'Source Sans Pro');
        $chartWeekly->labels($labels);
        $chartWeekly->dataset("Jumlah", "bar", $weeklySellData->pluck(['count']))->color("#DC143C")->backgroundColor("#FFA07A");

        // Chart Monthly
        $monthlySellData =    Sell::select(DB::raw('
            MONTH(created_at) AS `month`,
            COUNT(id) AS `count`
        '))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'), 'DESC')
            ->limit(5)
            ->get();

        $chartMonthly = new SimpleChart();
        $chartMonthly->title('Penjualan Bulanan', 25, "rgb(0, 0, 0)", true, 'Source Sans Pro');
        $chartMonthly->labels($monthlySellData->pluck(['month']));
        $chartMonthly->dataset("Jumlah", "bar", $monthlySellData->pluck(['count']))->color("#00BFFF")->backgroundColor("#F0F8FF");


        return response()->view('home', compact('badge_data', 'minItemStock', 'lastSell', 'lastBuy', 'chartWeekly', 'chartMonthly'));
    }
}
