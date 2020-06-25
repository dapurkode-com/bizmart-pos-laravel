<?php

namespace App;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;

/**
 * StockLog
 *
 * Arus log
 *
 * @package Model
 * @author Satya Wibawa <i.g.b.n.satyawibawa@gmail.com>
 *
 */
class StockLog extends Model
{
    use Blameable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ref_uniq_id',
        'cause',
        'in_out_position',
        'qty',
        'old_stock',
        'new_stock',
        'buy_price',
        'sell_price',
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
        'buy_price' => 'double',
        'sell_price' => 'double',
    ];
}
