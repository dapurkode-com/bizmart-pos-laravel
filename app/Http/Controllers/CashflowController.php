<?php

namespace App\Http\Controllers;

use App\Cashflow;
use App\SystemParam;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;

class CashflowController extends Controller
{
    public function index(Request $request)
    {
        $date_start = Carbon::parse($request->input('date_start', Carbon::today()->toString()));
        $date_end = Carbon::parse($request->input('date_end', Carbon::today()->toString()));

        $mrch_name = SystemParam::where('param_code', 'MRCH_NAME')->first();
        $mrch_addr = SystemParam::where('param_code', 'MRCH_ADDR')->first();
        $mrch_phone = SystemParam::where('param_code', 'MRCH_PHONE')->first();

        $cashflows = Cashflow::whereBetween('trx_date', [$date_start->startOfDay(), $date_end->endOfDay()])->get();

        return response()->view('cashflow.index', compact('mrch_name', 'mrch_addr', 'mrch_phone', 'date_start', 'date_end', 'cashflows'));
    }

    public function generatePdf(Request $request)
    {
        $date_start = Carbon::parse($request->input('date_start', Carbon::today()->toString()));
        $date_end = Carbon::parse($request->input('date_end', Carbon::today()->toString()));
        $cashflows = Cashflow::whereBetween('trx_date', [$date_start->startOfDay(), $date_end->endOfDay()])->get();
        $mrch_name = SystemParam::where('param_code', 'MRCH_NAME')->first();
        $mrch_addr = SystemParam::where('param_code', 'MRCH_ADDR')->first();
        $mrch_phone = SystemParam::where('param_code', 'MRCH_PHONE')->first();

        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('cashflow.pdf', compact('cashflows', 'mrch_name', 'mrch_addr', 'mrch_phone'))->render());
        $dompdf->setPaper('A5', 'landscape');
        $dompdf->render();
        $dompdf->stream("Laporan Arus Kas.pdf", array("Attachment" => true));
    }
}
