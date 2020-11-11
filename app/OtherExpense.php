<?php

namespace App;

use App\Traits\UniqID;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OtherExpense extends Model
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

    /**
     * [Relationship] Ref. pengguna
     *
     * @return belongsTo [User]
     */
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function details()
    {
        return $this->hasMany(\App\OtherExpenseDetail::class);
    }
}
