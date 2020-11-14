<?php

namespace App;

use App\Traits\Blameable;
use App\Traits\UniqID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Sell
 *
 * Penjualan
 *
 * @package Model
 * @author Satya Wibawa <i.g.b.n.satyawibawa@gmail.com>
 *
 */
class Sell extends Model
{
    use SoftDeletes;
    use Blameable;
    use UniqID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uniq_id',
        'user_id',
        'member_id',
        'summary',
        'tax',
        'note',
        'sell_status',
        'paid_amount',
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
        'member_id' => 'integer',
        'summary' => 'double',
        'tax' => 'double',
        'paid_amount' => 'double'
    ];

    /**
     * [Relationship] Details dari penjualan
     *
     * @return hasMany [SellDetail]
     */
    public function sellDetails()
    {
        return $this->hasMany(\App\SellDetail::class);
    }

    /**
     * [Relationship] Ref. pengguna
     *
     * @return belongsTo [User]
     */
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    /**
     * [Relationship] Pembeli
     *
     * @return belongsTo [Member]
     */
    public function member()
    {
        return $this->belongsTo(\App\Member::class);
    }

    /**
     * Label status
     *
     * @return string
     */
    public function statusText()
    {
        $lookUp = LookUp::where('group_code', 'SELL_STATUS')
            ->where('key', $this->sell_status)
            ->first();

        return $lookUp != null ? $lookUp->label : '-';
    }

    /**
     * [Relationship] from sell payment hs table
     *
     * @return hasMany [SellPaymentHs]
     */
    public function sellPaymentHs()
    {
        return $this->hasMany(\App\SellPaymentHs::class);
    }

    public function sellCode()
    {
        $kode = $this->sell_status == "RE" ?  "PI-" : "PJ-";
        return  $kode . str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }
}
