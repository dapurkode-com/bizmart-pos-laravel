<?php

namespace App\Observers;

use App\Opname;
use App\Cashflow;

class OpnameCashObserver
{
    const CASH_CAUSE = 'SO';
    const IO_CASH_IN = 'I';
    const IO_CASH_OUT = 'O';
    const OP_STATUS_LIMIT = 'DONE';
    /**
     * Handle the opname "created" event.
     *
     * @param  \App\Opname  $opname
     * @return void
     */
    public function created(Opname $opname)
    {
    }

    /**
     * Handle the opname "updated" event.
     *
     * @param  \App\Opname  $opname
     * @return void
     */
    public function updated(Opname $opname)
    {
        if ($opname->status === self::OP_STATUS_LIMIT) {

            $matchCase = [];
            $matchCase['ref_uniq_id']  = $opname->uniq_id;
            $matchCase['cash_cause']   = self::CASH_CAUSE;

            $data = [];
            $data['user_id']    = $opname->user_id;
            $data['trx_date']   = $opname->updated_at;
            $data['amount']     = $opname->summary ? abs($opname->summary) : 0;
            $data['io_cash']    = $opname->summary < 0 ? self::IO_CASH_OUT : self::IO_CASH_IN;

            Cashflow::updateOrCreate($matchCase, $data);
        }
    }

    /**
     * Handle the opname "deleted" event.
     *
     * @param  \App\Opname  $opname
     * @return void
     */
    public function deleted(Opname $opname)
    {
        //
    }

    /**
     * Handle the opname "restored" event.
     *
     * @param  \App\Opname  $opname
     * @return void
     */
    public function restored(Opname $opname)
    {
        //
    }

    /**
     * Handle the opname "force deleted" event.
     *
     * @param  \App\Opname  $opname
     * @return void
     */
    public function forceDeleted(Opname $opname)
    {
        //
    }
}
