<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CashCount extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'count_date',
        'counted_amount',
        'counted_system',
        'deviation',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'counted_amount' => 'double',
        'counted_system' => 'double',
        'deviation' => 'double',
    ];
}
