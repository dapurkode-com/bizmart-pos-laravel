<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class RecordFingerPrintObserver
{

    public function creating(Model $model)
    {
        $model->created_by = Auth::user()->username ?? 'sistem';
        $model->updated_by = Auth::user()->username ?? 'sistem';
    }

    public function updating(Model $model)
    {
        $model->updated_by = Auth::user()->username ?? 'sistem';
    }
}
