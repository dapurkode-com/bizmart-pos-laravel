<?php

namespace App;

use App\Traits\Blameable;
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
    use Blameable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sell_id',
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
        'sell_id' => 'integer',
        'user_id' => 'integer',
        'amount' => 'double',
    ];

    /**
     * [Relationship] to sell table
     *
     * @return belongsTo [Sell]
     */
    public function sell()
    {
        return $this->belongsTo(\App\Sell::class);
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
