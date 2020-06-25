<?php

namespace App;

use App\Traits\Blameable;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Item
 *
 * Barang
 *
 * @package Model
 * @author Satya Wibawa <i.g.b.n.satyawibawa@gmail.com>
 *
 */
class Item extends Model
{
    use SoftDeletes;
    use HasSlug;
    use Blameable;

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'barcode',
        'description',
        'is_stock_active',
        'unit_id',
        'stock',
        'min_stock',
        'sell_price',
        'buy_price',
        'profit',
        'sell_price_determinant',
        'margin',
        'markup',
        'last_buy_at',
        'last_sell_at',
        'last_opname_at',
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
        'is_stock_active' => 'boolean',
        'unit_id' => 'integer',
        'sell_price' => 'double',
        'buy_price' => 'double',
        'profit' => 'double',
        'margin' => 'float',
        'markup' => 'float',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'last_buy_at',
        'last_sell_at',
        'last_opname_at',
    ];


    /**
     * [Relationship] Kategori barang
     *
     * @return belongsToMany [Category]
     */
    public function categories()
    {
        return $this->belongsToMany(\App\Category::class);
    }

    /**
     * [Relationship] Satuan barang
     *
     * @return belongsTo [Uni]
     */
    public function unit()
    {
        return $this->belongsTo(\App\Unit::class);
    }

    /**
     * Label is_stock_active
     *
     * @return string
     */
    public function stockActiveText()
    {
        $lookUp = LookUp::where('group_code', 'STCK_ACTV')
            ->where('key', $this->is_stock_active)
            ->first();

        return $lookUp != null ? $lookUp->label : '-';
    }

    /**
     * Label sell_price_determinant
     *
     * @return string
     */
    public function sellPriceDeterminantText()
    {
        $lookUp = LookUp::where('group_code', 'SLL_PRC_DTRM')
            ->where('key', $this->sell_price_determinant)
            ->first();

        return $lookUp != null ? $lookUp->label : '-';
    }
}
