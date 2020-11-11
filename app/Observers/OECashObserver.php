<?php

namespace App\Observers;

use App\Cashflow;
use App\OtherExpense;

class OECashObserver
{
    const CASH_CAUSE = 'OE';
    const IO_CASH = 'O';
    /**
     * Handle the other expense "created" event.
     *
     * @param  \App\OtherExpense  $otherExpense
     * @return void
     */
    public function created(OtherExpense $otherExpense)
    {
        $matchCase = [];
        $matchCase['ref_uniq_id']  = $otherExpense->uniq_id;
        $matchCase['cash_cause']   = self::CASH_CAUSE;
        $matchCase['io_cash']      = self::IO_CASH;

        $data = [];
        $data['user_id']    = $otherExpense->user_id;
        $data['trx_date']   = $otherExpense->created_at;
        $data['amount']     = $otherExpense->summary ? $otherExpense->summary : 0;

        Cashflow::updateOrCreate($matchCase, $data);
    }

    /**
     * Handle the other expense "updated" event.
     *
     * @param  \App\OtherExpense  $otherExpense
     * @return void
     */
    public function updated(OtherExpense $otherExpense)
    {
        $matchCase = [];
        $matchCase['ref_uniq_id']  = $otherExpense->uniq_id;
        $matchCase['cash_cause']   = self::CASH_CAUSE;
        $matchCase['io_cash']      = self::IO_CASH;

        $data = [];
        $data['user_id']    = $otherExpense->user_id;
        $data['trx_date']   = $otherExpense->created_at;
        $data['amount']     = $otherExpense->summary ? $otherExpense->summary : 0;

        Cashflow::updateOrCreate($matchCase, $data);
    }

    /**
     * Handle the other expense "deleted" event.
     *
     * @param  \App\OtherExpense  $otherExpense
     * @return void
     */
    public function deleted(OtherExpense $otherExpense)
    {
        Cashflow::where('ref_uniq_id', $otherExpense->uniq_id)->delete();
    }

    /**
     * Handle the other expense "restored" event.
     *
     * @param  \App\OtherExpense  $otherExpense
     * @return void
     */
    public function restored(OtherExpense $otherExpense)
    {
        //
    }

    /**
     * Handle the other expense "force deleted" event.
     *
     * @param  \App\OtherExpense  $otherExpense
     * @return void
     */
    public function forceDeleted(OtherExpense $otherExpense)
    {
        //
    }
}
