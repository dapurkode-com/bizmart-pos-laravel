<?php

namespace App;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * OpnameDetail
 *
 * Detail dari stock opname
 *
 * @package Model
 * @author Satya Wibawa <i.g.b.n.satyawibawa@gmail.com>
 *
 */
class OpnameDetail extends Model
{
    use SoftDeletes;
    use Blameable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'opname_id',
        'item_id',
        'old_stock',
        'new_stock',
        'buy_price',
        'sell_price',
        'description',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'opname_id' => 'integer',
        'item_id' => 'integer',
        'buy_price' => 'double',
        'sell_price' => 'double',
    ];

    /**
     * [Relationship] Ref. Stock Opname
     *
     * @return belongsTo [Opname]
     */
    public function opname()
    {
        return $this->belongsTo(\App\Opname::class);
    }

    /**
     * [Relationship] Barang yang dilakukan stock opname
     *
     * @return belongsTo [Item]
     */
    public function item()
    {
        return $this->belongsTo(\App\Item::class);
    }
}
