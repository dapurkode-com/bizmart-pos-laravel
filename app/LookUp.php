<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * LookUp
 *
 * Penjelasan kode, status atau notasi khusus.
 *
 * @package Model
 * @author Satya Wibawa <i.g.b.n.satyawibawa@gmail.com>
 *
 */
class LookUp extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_code',
        'key',
        'look_up_key',
        'group_label',
        'label',
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
