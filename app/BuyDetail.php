<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * BuyDetail
 *
 * Detail Pembelian
 *
 * @package Model
 * @author Satya Wibawa <i.g.b.n.satyawibawa@gmail.com>
 *
 */
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
     * [Relationship] Barang yang dibeli
     *
     * @return belongsTo [Item]
     */
    public function item()
    {
        return $this->belongsTo(\App\Item::class);
    }
}
