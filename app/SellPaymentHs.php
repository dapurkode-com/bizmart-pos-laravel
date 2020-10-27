<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * SellPaymentHS
 *
 * Penjualan
 *
 * @package Model
 * @author Pande Nengah Purnawan <pandenengah@gmail.com>
 *
 */
class SellPaymentHs extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sell_id',
        'payment_date',
        'amount',
        'note',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'sell_id' => 'integer',
        'amount' => 'double',
    ];
}
