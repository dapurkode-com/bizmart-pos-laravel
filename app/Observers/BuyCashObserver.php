<?php

namespace App\Observers;

use App\Cashflow;
use App\BuyPaymentHs;

class BuyCashObserver
{
    const CASH_CAUSE = 'BY';
    const IO_CASH = 'O';
    /**
     * Handle the buy payment hs "created" event.
     *
     * @param  \App\BuyPaymentHs  $buyPaymentHs
     * @return void
     */
    public function created(BuyPaymentHs $buyPaymentHs)
    {
        $data = [];
        $data['ref_uniq_id']  = $buyPaymentHs->buy->uniq_id;
        $data['cash_cause']   = self::CASH_CAUSE;
        $data['io_cash']      = self::IO_CASH;
        $data['user_id']    = $buyPaymentHs->user_id;
        $data['trx_date']   = $buyPaymentHs->payment_date;
        $data['amount']     = $buyPaymentHs->amount;

        Cashflow::create($data);
    }

    /**
     * Handle the buy payment hs "updated" event.
     *
     * @param  \App\BuyPaymentHs  $buyPaymentHs
     * @return void
     */
    public function updated(BuyPaymentHs $buyPaymentHs)
    {
        //
    }

    /**
     * Handle the buy payment hs "deleted" event.
     *
     * @param  \App\BuyPaymentHs  $buyPaymentHs
     * @return void
     */
    public function deleted(BuyPaymentHs $buyPaymentHs)
    {
        //
    }

    /**
     * Handle the buy payment hs "restored" event.
     *
     * @param  \App\BuyPaymentHs  $buyPaymentHs
     * @return void
     */
    public function restored(BuyPaymentHs $buyPaymentHs)
    {
        //
    }

    /**
     * Handle the buy payment hs "force deleted" event.
     *
     * @param  \App\BuyPaymentHs  $buyPaymentHs
     * @return void
     */
    public function forceDeleted(BuyPaymentHs $buyPaymentHs)
    {
        //
    }
}
