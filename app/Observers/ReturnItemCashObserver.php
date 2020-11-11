<?php

namespace App\Observers;

use App\Cashflow;
use App\ReturnItem;

class ReturnItemCashObserver
{
    const CASH_CAUSE = 'RE';
    const IO_CASH = 'I';
    /**
     * Handle the return item "created" event.
     *
     * @param  \App\ReturnItem  $returnItem
     * @return void
     */
    public function created(ReturnItem $returnItem)
    {
        $matchCase = [];
        $matchCase['ref_uniq_id']  = $returnItem->uniq_id;
        $matchCase['cash_cause']   = self::CASH_CAUSE;
        $matchCase['io_cash']      = self::IO_CASH;

        $data = [];
        $data['user_id']    = $returnItem->user_id;
        $data['trx_date']   = $returnItem->created_at;
        $data['amount']     = $returnItem->summary ? $returnItem->summary : 0;

        Cashflow::updateOrCreate($matchCase, $data);
    }

    /**
     * Handle the return item "updated" event.
     *
     * @param  \App\ReturnItem  $returnItem
     * @return void
     */
    public function updated(ReturnItem $returnItem)
    {
        //
    }

    /**
     * Handle the return item "deleted" event.
     *
     * @param  \App\ReturnItem  $returnItem
     * @return void
     */
    public function deleted(ReturnItem $returnItem)
    {
        //
    }

    /**
     * Handle the return item "restored" event.
     *
     * @param  \App\ReturnItem  $returnItem
     * @return void
     */
    public function restored(ReturnItem $returnItem)
    {
        //
    }

    /**
     * Handle the return item "force deleted" event.
     *
     * @param  \App\ReturnItem  $returnItem
     * @return void
     */
    public function forceDeleted(ReturnItem $returnItem)
    {
        //
    }
}
