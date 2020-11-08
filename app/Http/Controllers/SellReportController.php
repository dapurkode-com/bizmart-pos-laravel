<?php

namespace App\Http\Controllers;

use App\Sell;
use App\SellPaymentHs;
use Illuminate\Http\Request;

class SellReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->view('sell_report.index');
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

    /**
     * Display a number of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getTotalTransaction(Request $request)
    {
        $total = Sell::where('updated_at', '>=', $request->date_start)
                     ->where('updated_at', '<=', $request->date_end . " 23:59:59")
                     ->count();

        return response()->json([
            "total_transaction" => $total,
        ]);
    }

    /**
     * Display a number of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getTotalIncomeNow(Request $request)
    {
        $total = SellPaymentHs::where('payment_date', '>=', $request->date_start)
                              ->where('payment_date', '<=', $request->date_end . " 23:59:59")
                              ->sum('amount');

        return response()->json([
            "total_income_now" => $total,
        ]);
    }

    /**
     * Display a number of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getTotalPiutang(Request $request)
    {
        $total = SellPaymentHs::select("
                        SUM()
                     ")
                     ->with('sells')
                     ->where('payment_date', '>=', $request->date_start)
                     ->where('payment_date', '<=', $request->date_end . " 23:59:59")
                     ->get();

        return response()->json([
            "total_piutang" => $total,
        ]);
    }
}
