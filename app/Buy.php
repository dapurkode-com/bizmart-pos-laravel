<?php

namespace App;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Buy extends Model
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


    public function buyDetails()
    {
        return $this->hasMany(\App\BuyDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function suplier()
    {
        return $this->belongsTo(\App\Suplier::class);
    }
}
