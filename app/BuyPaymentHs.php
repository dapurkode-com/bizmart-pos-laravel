<?php

namespace App;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;

class BuyPaymentHs extends Model
{
    use Blameable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'buy_id',
        'user_id',
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
        'user_id' => 'integer',
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

    /**
     * [Relationship] to user table
     *
     * @return belongsTo [User]
     */
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}
