<?php

namespace App;

use App\Traits\UniqID;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OtherRevenue extends Model
{
    use Blameable;
    use SoftDeletes;
    use UniqID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uniq_id',
        'user_id',
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
        'summary' => 'double'
    ];

    public function details()
    {
        return $this->hasMany(\App\OtherRevenueDetail::class);
    }
}
