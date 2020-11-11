<?php

namespace App\Observers;

use App\Cashflow;
use App\SellPaymentHs;

class SellCashObserver
{
    const CASH_CAUSE = 'SL';
    const IO_CASH = 'I';
    /**
     * Handle the sell payment hs "created" event.
     *
     * @param  \App\SellPaymentHs  $sellPaymentHs
     * @return void
     */
    public function created(SellPaymentHs $sellPaymentHs)
    {
        $data = [];
        $data['ref_uniq_id']  = $sellPaymentHs->sell->uniq_id;
        $data['cash_cause']   = self::CASH_CAUSE;
        $data['io_cash']      = self::IO_CASH;
        $data['user_id']    = $sellPaymentHs->user_id;
        $data['trx_date']   = $sellPaymentHs->payment_date;
        $data['amount']     = $sellPaymentHs->amount;

        Cashflow::create($data);
    }

    /**
     * Handle the sell payment hs "updated" event.
     *
     * @param  \App\SellPaymentHs  $sellPaymentHs
     * @return void
     */
    public function updated(SellPaymentHs $sellPaymentHs)
    {
    }

    /**
     * Handle the sell payment hs "deleted" event.
     *
     * @param  \App\SellPaymentHs  $sellPaymentHs
     * @return void
     */
    public function deleted(SellPaymentHs $sellPaymentHs)
    {
        //
    }

    /**
     * Handle the sell payment hs "restored" event.
     *
     * @param  \App\SellPaymentHs  $sellPaymentHs
     * @return void
     */
    public function restored(SellPaymentHs $sellPaymentHs)
    {
        //
    }

    /**
     * Handle the sell payment hs "force deleted" event.
     *
     * @param  \App\SellPaymentHs  $sellPaymentHs
     * @return void
     */
    public function forceDeleted(SellPaymentHs $sellPaymentHs)
    {
        //
    }
}
