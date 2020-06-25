<?php

namespace App;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Unit
 *
 * Satuan Barang
 *
 * @package Model
 * @author Satya Wibawa <i.g.b.n.satyawibawa@gmail.com>
 *
 */
class Unit extends Model
{
    use SoftDeletes;
    use Blameable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
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
    ];

    /**
     * [Relationship] Barang-barang yang menggunakan satuan tersebut
     *
     * @return hasMany [Item]
     */
    public function items()
    {
        return $this->hasMany(\App\Item::class);
    }
}
