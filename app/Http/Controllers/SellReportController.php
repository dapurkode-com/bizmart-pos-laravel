<?php

namespace App\Http\Controllers;

use App\Sell;
use App\SellPaymentHs;
use Carbon\Carbon;
use DB;
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
        $tglNow = Carbon::now()->toDateString();
        return response()->view('sell_report.index', compact('tglNow'));
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
        $total = SellPaymentHs::where('payment_date', '>=', $request->date_start . " 00:00:00")
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
        $total = DB::select(DB::raw("
                SELECT
                    COALESCE(SUM(summary - sum_amount), 0) as sum_piutang
                FROM(
                    SELECT
                        MIN(sells.`summary`) AS summary,
                        SUM(amount) AS sum_amount
                    FROM `sell_payment_hs`
                    LEFT JOIN sells ON sells.`id` = sell_payment_hs.`sell_id`
                    WHERE sell_payment_hs.updated_at <= '$request->date_end 23:59:59'
                    AND sells.`sell_status` = 'RE'
                    GROUP BY sell_payment_hs.`sell_id`
                ) result
            "))[0];

        return response()->json([
            "total_piutang" => $total->sum_piutang,
        ]);
    }

    /**
     * Display a number of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getTotalIncome(Request $request)
    {
        $total = Sell::where('updated_at', '>=', $request->date_start . " 00:00:00")
                     ->where('updated_at', '<=', $request->date_end . " 23:59:59")
                     ->sum('summary');

        return response()->json([
            "total_income" => $total,
        ]);
    }

    /**
     * Display a listing of the resource in form of datatable.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function incomeDatatables(Request $request)
    {
        $reports = DB::select(DB::raw("
                SELECT
                    DATE_FORMAT(MIN(payment_date), '%e %b %Y') AS `date`,
                    CONCAT('PJ-', LPAD(MIN(sell_id), 5, '0')) AS sell_code,
                    SUM(amount) AS sum_amount
                FROM `sell_payment_hs`
                WHERE updated_at >='" . $request->filter['date_start'] . " 00:00:00'
                AND updated_at <='" . $request->filter['date_end'] . " 23:59:59'
                GROUP BY `sell_id`
            "));
        return datatables()
            ->of($reports)
            ->addIndexColumn()
            ->toJson();
    }

    /**
     * Display a listing of the resource in form of datatable.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function piutangDatatables(Request $request)
    {
        $reports = DB::select(DB::raw("
                SELECT
                    DATE_FORMAT(MIN(payment_date), '%e %b %Y') AS `date`,
                    CONCAT('PJ-', LPAD(MIN(sell_id), 5, '0')) AS sell_code,
                    (MIN(summary) - SUM(amount)) AS sum_piutang
                FROM `sell_payment_hs` sp
                LEFT JOIN sells s ON s.`id` = sp.`sell_id`
                WHERE sp.updated_at <= '" . $request->filter['date_end'] . " 23:59:59'
                AND s.`sell_status` = 'RE'
                GROUP BY `sell_id`
            "));
        return datatables()
            ->of($reports)
            ->addIndexColumn()
            ->toJson();
    }

    /**
     * Display a listing of the resource in form of datatable.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function itemDatatables(Request $request)
    {
        $reports = DB::select(DB::raw("
                SELECT
                    MIN(i.`name`) AS `name`,
                    SUM(sl.`qty`) AS sum_qty,
                    SUM((sl.sell_price * sl.`qty`)) AS sum_sell_price,
                    SUM(((sl.sell_price * sl.`qty`) - (sl.buy_price * sl.`qty`))) AS net_income
                FROM stock_logs sl
                LEFT JOIN items i ON i.`id` = sl.`item_id`
                WHERE sl.`cause` = 'SELL'
                AND sl.updated_at >= '" . $request->filter['date_start'] . " 00:00:00'
                AND sl.updated_at <= '" . $request->filter['date_end'] . " 23:59:59'
                GROUP BY sl.`item_id`
            "));
        return datatables()
            ->of($reports)
            ->addIndexColumn()
            ->toJson();
    }

    /**
     * Display a listing of the resource in form of datatable.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function memberDatatables(Request $request)
    {
        $reports = DB::select(DB::raw("
                SELECT
                    MIN(m.`name`) AS `name`,
                    COUNT(s.`member_id`) AS count_transaction
                FROM sells s
                LEFT JOIN members m ON m.`id` = s.`member_id`
                WHERE s.updated_at >= '" . $request->filter['date_start'] . " 00:00:00'
                AND s.updated_at <= '" . $request->filter['date_end'] . " 23:59:59'
                GROUP BY s.`member_id`
            "));
        return datatables()
            ->of($reports)
            ->addIndexColumn()
            ->toJson();
    }

    /**
     * note
     */
    /*
    SELECT
        DATE_FORMAT(MIN(payment_date), "%e %b %Y") AS `date`,
        CONCAT('PJ-', LPAD(MIN(sell_id), 5, '0')) AS sell_code,
        SUM(amount) AS sum_amount
        FROM `sell_payment_hs`
        WHERE updated_at >= '2020-11-09'
        AND updated_at <= '2020-11-09 23:59:59'
        GROUP BY `sell_id`
    ;
    SELECT
        DATE_FORMAT(MIN(payment_date), "%e %b %Y") AS `date`,
        CONCAT('PJ-', LPAD(MIN(sell_id), 5, '0')) AS sell_code,
        (MIN(summary) - SUM(amount)) AS sum_piutang
        FROM `sell_payment_hs` sp
        LEFT JOIN sells s ON s.`id` = sp.`sell_id`
        WHERE sp.updated_at <= '2020-11-09 23:59:59'
        AND s.`sell_status` = 'RE'
        GROUP BY `sell_id`
    ;
    SELECT
        MIN(i.`name`) AS `name`,
        SUM(sl.`qty`) AS sum_qty,
        SUM((sl.sell_price * sl.`qty`)) AS sum_sell_price,
        SUM(((sl.sell_price * sl.`qty`) - (sl.buy_price * sl.`qty`))) AS net_income
        FROM stock_logs sl
        LEFT JOIN items i ON i.`id` = sl.`item_id`
        WHERE sl.`cause` = 'SELL'
        AND sl.updated_at >= '2020-11-07'
        AND sl.updated_at <= '2020-11-09 23:59:59'
        GROUP BY sl.`item_id`
        ORDER BY sum_qty DESC
    ;
    SELECT
        MIN(m.`name`) AS `name`,
        COUNT(s.`member_id`) AS count_member_id
        FROM sells s
        LEFT JOIN members m ON m.`id` = s.`member_id`
        WHERE s.updated_at >= '2020-11-07'
        AND s.updated_at <= '2020-11-09 23:59:59'
        GROUP BY s.`member_id`
        ORDER BY `count_member_id` DESC
    ;
    */
     

}
