<?php

namespace App;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Sell
 *
 * Penjualan
 *
 * @package Model
 * @author Satya Wibawa <i.g.b.n.satyawibawa@gmail.com>
 *
 */
class Sell extends Model
{
    use SoftDeletes;
    use Blameable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uniq_id',
        'user_id',
        'member_id',
        'summary',
        'tax',
        'note',
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
        'user_id' => 'integer',
        'member_id' => 'integer',
        'summary' => 'double',
        'tax' => 'double',
    ];

    /**
     * [Relationship] Details dari penjualan
     *
     * @return hasMany [SellDetail]
     */
    public function sellDetails()
    {
        return $this->hasMany(\App\SellDetail::class);
    }

    /**
     * [Relationship] Ref. pengguna
     *
     * @return belongsTo [User]
     */
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    /**
     * [Relationship] Pembeli
     *
     * @return belongsTo [Member]
     */
    public function member()
    {
        return $this->belongsTo(\App\Member::class);
    }
}
