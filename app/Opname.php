<?php

namespace App;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Opname
 *
 * Stock Opname
 *
 * @package Model
 * @author Satya Wibawa <i.g.b.n.satyawibawa@gmail.com>
 *
 */
class Opname extends Model
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
        'summary',
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
        'summary' => 'double',
    ];

    /**
     * [Relationship] Detail stock opname
     *
     * @return hasMany [OpnameDetail]
     */
    public function opnameDetails()
    {
        return $this->hasMany(\App\OpnameDetail::class);
    }

    /**
     * [Relationship] User penanggung jawab yang melakukan stock opname
     *
     * @return belongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}
