<?php

namespace App;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Category
 *
 * Kategori Barang
 *
 * @package Model
 * @author Satya Wibawa <i.g.b.n.satyawibawa@gmail.com>
 *
 */
class Category extends Model
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
     * [Relationship] Barang-barang pada kategori tersebut.
     *
     * @return belongsToMany [Item]
     */
    public function items()
    {
        return $this->belongsToMany(\App\Item::class);
    }
}
