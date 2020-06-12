<?php

namespace App;

use App\Traits\Blameable;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'last_opname:at',
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
        'last_opname:at',
    ];


    public function categories()
    {
        return $this->belongsToMany(\App\Category::class);
    }

    public function unit()
    {
        return $this->belongsTo(\App\Unit::class);
    }
}
