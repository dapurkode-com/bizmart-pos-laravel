<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * ReturnItemDetail
 *
 * Detail Retur Barang
 *
 * @package Model
 * @author Satya Wibawa <i.g.b.n.satyawibawa@gmail.com>
 *
 */
class ReturnItemDetail extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'return_item_id',
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
        'return_item_id' => 'integer',
        'item_id' => 'integer',
        'buy_price' => 'double',
    ];

    /**
     * [Relationship] Ref. Retur Barang
     *
     * @return belongsTo [ReturnItem]
     */
    public function returnItem()
    {
        return $this->belongsTo(\App\ReturnItem::class);
    }

    /**
     * [Relationship] Barang yang retur
     *
     * @return belongsTo [Item]
     */
    public function item()
    {
        return $this->belongsTo(\App\Item::class);
    }
}
