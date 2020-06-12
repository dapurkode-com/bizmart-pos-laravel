<?php

namespace App;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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


    public function opname()
    {
        return $this->belongsTo(\App\Opname::class);
    }

    public function item()
    {
        return $this->belongsTo(\App\Item::class);
    }
}
