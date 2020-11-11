<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use Carbon\Carbon;
use App\SystemParam;
use App\OtherRevenue;
use Illuminate\Http\Request;

class OtherRevenueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->view('other_revenue.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('other_revenue.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'description.*' => 'required|string',
            'amount.*' => 'required|numeric'
        ]);
        try {
            DB::beginTransaction();

            $data = $request->only(['note']);
            $data['user_id'] = auth()->user()->id;

            $or = OtherRevenue::create($data);

            $descriptions = $request->input('description', []);
            $amounts = $request->input('amount', []);
            $summary = 0;
            foreach ($descriptions as $key => $description) {
                $detail = [];
                $detail['description'] = $description;
                $detail['amount'] = $amounts[$key];
                $or->details()->create($detail);
                $summary += $amounts[$key];
            }

            $or->update([
                'summary' => $summary
            ]);

            DB::commit();
            return response([
                'status' => true
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return response([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OtherRevenue  $otherRevenue
     * @return \Illuminate\Http\Response
     */
    public function show(OtherRevenue $otherRevenue)
    {
        $mrch_name = SystemParam::where('param_code', 'MRCH_NAME')->first();
        $mrch_addr = SystemParam::where('param_code', 'MRCH_ADDR')->first();
        $mrch_phone = SystemParam::where('param_code', 'MRCH_PHONE')->first();

        return response()->view('other_revenue.show', compact('otherRevenue', 'mrch_name', 'mrch_addr', 'mrch_phone'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OtherRevenue  $otherRevenue
     * @return \Illuminate\Http\Response
     */
    public function edit(OtherRevenue $otherRevenue)
    {
        //
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OtherRevenue  $otherRevenue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OtherRevenue $otherRevenue)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OtherRevenue  $otherRevenue
     * @return \Illuminate\Http\Response
     */
    public function destroy(OtherRevenue $otherRevenue)
    {
        abort(404);
    }

    public function datatables(Request $request)
    {

        $where = "";

        if (null != $request->filter['date_start'] && null != $request->filter['date_end']) {
            $where = "WHERE other_revenues.updated_at >='" . $request->filter['date_start'] . " 00:00:00'
                AND other_revenues.updated_at <='" . $request->filter['date_end'] . " 23:59:59'";
        }

        $or = DB::select(DB::raw("SELECT
                    CONCAT('OR-', LPAD(other_revenues.id, 5, 0)) AS id,
                    other_revenues.id as _id,
                    users.name,
                    summary,
                    note,
                    other_revenues.updated_at
                FROM other_revenues
                JOIN users ON users.id = other_revenues.user_id
                $where
            "));

        return datatables()
            ->of($or)
            ->addIndexColumn()
            ->editColumn('updated_at', function ($or) {
                return Carbon::parse($or->updated_at)->isoFormat('dddd, D MMMM Y');
            })
            ->addColumn('action', function ($or) {
                $btn = '<a href="' . route('other_revenue.show', $or->_id) . '" class="btn btn-sm btn-info"><i class="fas fa-fw fa-eye"></i> Lihat</a>';
                return $btn;
            })
            ->escapeColumns([])
            ->make(true);
    }
}
