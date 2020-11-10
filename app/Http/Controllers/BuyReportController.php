<?php

namespace App\Http\Controllers;

use App\Buy;
use App\BuyPaymentHs;
use App\Item;
use Illuminate\Http\Request;

class BuyReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $date_now = date('Y-m-d');
        return response()->view('buy_report.index', compact('date_now'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getTotalTransactions(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $buy_count = Buy::whereBetween('created_at', [$start_date." 00:00:00",$end_date." 23:59:59"])
                        ->count();

        return response()->json([
            'buy_count' => $buy_count,
        ]);
        // dd($buy_count);
    }

    public function getCurrentExpend(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $total_expend = 0;

        $buys = BuyPaymentHs::whereBetween('buy_payment_hs.created_at', [$start_date." 00:00:00",$end_date." 23:59:59"])
                    ->where('buys.buy_status', 'DE')
                    ->join('buys','buys.id', '=', 'buy_payment_hs.buy_id')
                    ->get();
        foreach ($buys as $buy) {
            // dd($buy->summary);
            $total_expend += $buy->amount; 
        }

        return response()->json([
            'total_expend' => $total_expend,
        ]);
        
    }

    public function getOverallDept(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $dept = 0;
        $buys = Buy::whereBetween('created_at', [$start_date." 00:00:00",$end_date." 23:59:59"])
                    ->where('buy_status', 'DE')
                    ->get();
        foreach ($buys as $buy) {
            $buy_expend = BuyPaymentHs::whereBetween('created_at', [$start_date." 00:00:00",$end_date." 23:59:59"])
                    ->where('buy_id', $buy->id)
                    ->sum('amount');
            $dept += $buy->summary - $buy_expend; 
        }
        return response()->json([
            'buy_dept' => $dept,
        ]);       
        // dd($dept);
        // dd($buys->pluck('summary'));
    }

    public function getEstimatedTotalExpend(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $buy_expend = Buy::whereBetween('created_at', [$start_date." 00:00:00",$end_date." 23:59:59"])
                    ->sum('summary');
        // dd($buys);
        return response()->json([
            'buy_expend' => $buy_expend,
        ]);
    }

    // public function datatablesItem(Request $request)
    // {
    //     $items = DB::table('items')
    // }
}
