<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * SystemParam
 *
 * Pengaturan dari aplikasi
 *
 * @package Model
 * @author Satya Wibawa <i.g.b.n.satyawibawa@gmail.com>
 *
 */
class SystemParam extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'param_code',
        'param_value',
        'in_type',
        'group_code',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];
}
