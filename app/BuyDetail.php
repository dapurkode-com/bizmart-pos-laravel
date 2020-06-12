<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BuyDetail extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'buy_id',
        'item_id',
        'qty',
        'buy_price',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'buy_id' => 'integer',
        'item_id' => 'integer',
        'buy_price' => 'double',
    ];


    public function buy()
    {
        return $this->belongsTo(\App\Buy::class);
    }

    public function item()
    {
        return $this->belongsTo(\App\Item::class);
    }
}
