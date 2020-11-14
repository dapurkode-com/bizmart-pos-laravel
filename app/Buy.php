<?php

namespace App;

use App\Traits\Blameable;
use App\Traits\UniqID;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Buy
 *
 * Pembelian
 *
 * @package Model
 * @author Satya Wibawa <i.g.b.n.satyawibawa@gmail.com>
 *
 */
class Buy extends Model
{
    use SoftDeletes;
    use Blameable;
    use UniqID;

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uniq_id';
    }

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
        'buy_status',
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
        'suplier_id' => 'integer',
        'summary' => 'double',
        'tax' => 'double',
        'paid_amount' => 'integer',
    ];

    /**
     * [Relationship] Detail Pembelian
     *
     * @return hasMany [BuyDetail]
     */
    public function buyDetails()
    {
        return $this->hasMany(\App\BuyDetail::class);
    }

    /**
     * [Relationship] Pegawai yang melakukan pembelian
     *
     * @return belongsTo [User]
     */
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    /**
     * [Relationship] Suplier yang dituju
     *
     * @return belongsTo [Suplier]
     */
    public function suplier()
    {
        return $this->belongsTo(\App\Suplier::class);
    }

    /**
     * [Relationship] Detail Histori Pembelian
     *
     * @return hasMany [BuyPaymentHS]
     */
    public function buyPaymentHs()
    {
        return $this->hasMany(\App\BuyPaymentHs::class);
    }

    /**
     * Label status
     *
     * @return string
     */
    public function statusText()
    {
        $lookUp = LookUp::where('group_code', 'BUY_STATUS')
            ->where('key', $this->buy_status)
            ->first();

        return $lookUp != null ? $lookUp->label : '-';
    }

    public function buyCode()
    {
        $kode = $this->buy_status == "DE" ?  "HT-" : "PB-";
        return  $kode . str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }
}
