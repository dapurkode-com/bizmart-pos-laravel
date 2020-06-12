<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SellDetail extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sell_id',
        'item_id',
        'qty',
        'sell_price',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'sell_id' => 'integer',
        'item_id' => 'integer',
        'sell_price' => 'double',
    ];


    public function sell()
    {
        return $this->belongsTo(\App\Sell::class);
    }

    public function item()
    {
        return $this->belongsTo(\App\Item::class);
    }
}
