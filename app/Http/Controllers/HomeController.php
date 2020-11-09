<?php

namespace App\Http\Controllers;

use App\Buy;
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

        return response()->view('home', compact('badge_data', 'minItemStock', 'lastSell', 'lastBuy'));
    }
}
