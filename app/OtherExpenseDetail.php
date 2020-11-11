<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OtherExpenseDetail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'other_expense_id',
        'description',
        'amount',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'amount' => 'double'
    ];
}
