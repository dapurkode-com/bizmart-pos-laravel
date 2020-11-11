<?php

namespace App\Observers;

use App\Cashflow;
use App\OtherRevenue;

class ORCashObserver
{
    const CASH_CAUSE = 'OR';
    const IO_CASH = 'I';
    /**
     * Handle the other revenue "created" event.
     *
     * @param  \App\OtherRevenue  $otherRevenue
     * @return void
     */
    public function created(OtherRevenue $otherRevenue)
    {
        $matchCase = [];
        $matchCase['ref_uniq_id']  = $otherRevenue->uniq_id;
        $matchCase['cash_cause']   = self::CASH_CAUSE;
        $matchCase['io_cash']      = self::IO_CASH;

        $data = [];
        $data['user_id']    = $otherRevenue->user_id;
        $data['trx_date']   = $otherRevenue->created_at;
        $data['amount']     = $otherRevenue->summary ? $otherRevenue->summary : 0;

        Cashflow::updateOrCreate($matchCase, $data);
    }

    /**
     * Handle the other revenue "updated" event.
     *
     * @param  \App\OtherRevenue  $otherRevenue
     * @return void
     */
    public function updated(OtherRevenue $otherRevenue)
    {
        $matchCase = [];
        $matchCase['ref_uniq_id']  = $otherRevenue->uniq_id;
        $matchCase['cash_cause']   = self::CASH_CAUSE;
        $matchCase['io_cash']      = self::IO_CASH;

        $data = [];
        $data['user_id']    = $otherRevenue->user_id;
        $data['trx_date']   = $otherRevenue->created_at;
        $data['amount']     = $otherRevenue->summary ? $otherRevenue->summary : 0;

        Cashflow::updateOrCreate($matchCase, $data);
    }

    /**
     * Handle the other revenue "deleted" event.
     *
     * @param  \App\OtherRevenue  $otherRevenue
     * @return void
     */
    public function deleted(OtherRevenue $otherRevenue)
    {
        Cashflow::where('ref_uniq_id', $otherRevenue->uniq_id)->delete();
    }

    /**
     * Handle the other revenue "restored" event.
     *
     * @param  \App\OtherRevenue  $otherRevenue
     * @return void
     */
    public function restored(OtherRevenue $otherRevenue)
    {
        //
    }

    /**
     * Handle the other revenue "force deleted" event.
     *
     * @param  \App\OtherRevenue  $otherRevenue
     * @return void
     */
    public function forceDeleted(OtherRevenue $otherRevenue)
    {
        //
    }
}
