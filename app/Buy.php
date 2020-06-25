<?php

namespace App;

use App\Traits\Blameable;
use App\Traits\UniqID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Buy
 *
 * Pembelian
 *
 * @package Model
 * @author Satya Wibawa <i.g.b.n.satyawibawa@gmail.com>
 *
 */
class Buy extends Model
{
    use SoftDeletes;
    use Blameable;
    use UniqID;

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uniq_id';
    }

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
        'suplier_id' => 'integer',
        'summary' => 'double',
        'tax' => 'double',
    ];

    /**
     * [Relationship] Detail Pembelian
     *
     * @return hasMany [BuyDetail]
     */
    public function buyDetails()
    {
        return $this->hasMany(\App\BuyDetail::class);
    }

    /**
     * [Relationship] Pegawai yang melakukan pembelian
     *
     * @return belongsTo [User]
     */
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    /**
     * [Relationship] Suplier yang dituju
     *
     * @return belongsTo [Suplier]
     */
    public function suplier()
    {
        return $this->belongsTo(\App\Suplier::class);
    }
}
