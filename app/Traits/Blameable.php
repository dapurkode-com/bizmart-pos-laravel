<?php

namespace App\Traits;

use App\Observers\RecordFingerPrintObserver;

/**
 * Blameable
 *
 * Trait untuk memberikan fingerprint saat proses create dan update
 */
trait Blameable
{
    public static function bootBlameable()
    {
        static::observe(RecordFingerPrintObserver::class);
    }
}
