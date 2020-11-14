<?php

namespace App;

use App\Traits\UniqID;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * ReturnItem
 *
 * Retur Barang
 *
 * @package Model
 * @author Satya Wibawa <i.g.b.n.satyawibawa@gmail.com>
 *
 */
class ReturnItem extends Model
{
    use SoftDeletes;
    use Blameable;
    use UniqID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uniq_id',
        'user_id',
        'suplier_id',
        'summary',
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
        'suplier_id' => 'integer',
        'summary' => 'double',
    ];

    /**
     * [Relationship] Details dari retur barang
     *
     * @return hasMany [ReturnItemDetail]
     */
    public function details()
    {
        return $this->hasMany(\App\ReturnItemDetail::class);
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
     * [Relationship] Suplier
     *
     * @return belongsTo [Suplier]
     */
    public function suplier()
    {
        return $this->belongsTo(\App\Suplier::class);
    }

    public function returnCode()
    {
        return "RT-" . str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }
}
