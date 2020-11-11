<?php

namespace App\Http\Controllers;

use App\Buy;
use App\BuyPaymentHs;
use App\Item;
use DB;
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
        $buy_count = Buy::whereBetween('updated_at', [$start_date." 00:00:00",$end_date." 23:59:59"])
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
        $total_expend = BuyPaymentHs::whereBetween('payment_date', [$start_date." 00:00:00",$end_date." 23:59:59"])
                    ->sum('amount');

        return response()->json([
            'total_expend' => $total_expend,
        ]);
        
    }

    public function getOverallDept(Request $request)
    {
        // $start_date = $request->start_date;
        $end_date = $request->end_date;
        $dept = DB::select(DB::raw("
                SELECT
                    COALESCE(SUM(summary - sum_amount), 0) as sum_dept
                FROM(
                    SELECT
                        MIN(buys.`summary`) AS summary,
                        SUM(amount) AS sum_amount
                    FROM `buy_payment_hs`
                    LEFT JOIN buys ON buys.`id` = buy_payment_hs.`buy_id`
                    WHERE buy_payment_hs.updated_at <= '$end_date 23:59:59'
                    AND buys.`buy_status` = 'DE'
                    GROUP BY buy_payment_hs.`buy_id`
                ) result
            "))[0];

        
        return response()->json([
            'buy_dept' => $dept->sum_dept,
        ]); 
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

    public function itemDatatables(Request $request)
    {
        $reports = DB::select(DB::raw("
                SELECT
                    MIN(i.`name`) AS `name`,
                    SUM(sl.`qty`) AS sum_qty,
                    SUM((sl.buy_price * sl.`qty`)) AS sum_buy_price
                FROM stock_logs sl
                LEFT JOIN items i ON i.`id` = sl.`item_id`
                WHERE sl.`cause` = 'BUY'
                AND sl.updated_at >= '" . $request->filter['start_date'] . " 00:00:00'
                AND sl.updated_at <= '" . $request->filter['end_date'] . " 23:59:59'
                GROUP BY sl.`item_id`
            "));
        return datatables()
            ->of($reports)
            ->addIndexColumn()
            ->toJson();
    }

    public function expendDatatables(Request $request)
    {
        $reports = DB::select(DB::raw("
                SELECT
                    DATE_FORMAT(MIN(payment_date), '%e %b %Y') AS `date`,
                    CONCAT('PB-', LPAD(MIN(buy_id), 5, '0')) AS buy_code,
                    SUM(amount) AS sum_amount
                FROM `buy_payment_hs`
                WHERE updated_at >='" . $request->filter['start_date'] . " 00:00:00'
                AND updated_at <='" . $request->filter['end_date'] . " 23:59:59'
                GROUP BY `buy_id`
            "));
        return datatables()
            ->of($reports)
            ->addIndexColumn()
            ->toJson();
    }

    public function deptDatatables(Request $request)
    {
        $reports = DB::select(DB::raw("
                SELECT
                    DATE_FORMAT(MIN(payment_date), '%e %b %Y') AS `date`,
                    CONCAT('PB-', LPAD(MIN(buy_id), 5, '0')) AS buy_code,
                    (MIN(summary) - SUM(amount)) AS sum_dept
                FROM `buy_payment_hs` bp
                LEFT JOIN buys b ON b.`id` = bp.`buy_id`
                WHERE bp.updated_at <= '" . $request->filter['end_date'] . " 23:59:59'
                AND b.`buy_status` = 'DE'
                GROUP BY `buy_id`
            "));
        return datatables()
            ->of($reports)
            ->addIndexColumn()
            ->toJson();
    }

    public function suplierDatatables(Request $request)
    {
        $reports = DB::select(DB::raw("
                SELECT
                    MIN(s.`name`) AS `name`,
                    COUNT(b.`suplier_id`) AS count_transaction
                FROM buys b
                LEFT JOIN supliers s ON s.`id` = b.`suplier_id`
                WHERE b.updated_at >='" . $request->filter['start_date'] . " 00:00:00'
                AND b.updated_at <='" . $request->filter['end_date'] . " 23:59:59'
                GROUP BY b.`suplier_id`
            "));
        return datatables()
            ->of($reports)
            ->addIndexColumn()
            ->toJson();
    }
}
