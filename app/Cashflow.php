<?php

namespace App;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;

class Cashflow extends Model
{
    use Blameable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ref_uniq_id',
        'user_id',
        'trx_date',
        'cash_cause',
        'io_cash',
        'amount',
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
        'amount' => 'double',
        'trx_date' => 'date'
    ];

    /**
     * [Relationship] Ref. pengguna
     *
     * @return belongsTo [User]
     */
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}
