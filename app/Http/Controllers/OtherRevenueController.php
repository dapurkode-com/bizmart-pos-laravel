<?php

namespace App\Http\Controllers;

use App\OtherRevenue;
use DB;
use Exception;
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
        //
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
}
