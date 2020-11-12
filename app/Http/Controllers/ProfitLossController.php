<?php

namespace App\Http\Controllers;

use App\SystemParam;
use Illuminate\Http\Request;

class ProfitLossController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', date('m'));

        $mrch_name = SystemParam::where('param_code', 'MRCH_NAME')->first();
        $mrch_addr = SystemParam::where('param_code', 'MRCH_ADDR')->first();
        $mrch_phone = SystemParam::where('param_code', 'MRCH_PHONE')->first();

        return response()->view('profit_loss.index', compact('mrch_name', 'mrch_addr', 'mrch_phone', 'month'));
    }
}
