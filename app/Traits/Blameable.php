<?php

namespace App\Traits;

use App\Observers\RecordFingerPrintObserver;

trait Blameable
{
    public static function bootBlameable()
    {
        static::observe(RecordFingerPrintObserver::class);
    }
}
