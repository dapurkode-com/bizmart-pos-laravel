<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BuyPaymentHs extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'buy_id',
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
        'buy_id' => 'integer',
        'payment_date' => 'datetime',
        'amount' => 'double',
    ];


    /**
     * [Relationship] Ref. Pembelian
     *
     * @return belongsTo [Buy]
     */
    public function buy()
    {
        return $this->belongsTo(\App\Buy::class);
    }
}
