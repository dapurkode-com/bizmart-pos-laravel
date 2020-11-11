<?php

namespace App;

use App\LookUp;
use App\Traits\Blameable;
use App\Helpers\BadgeHelper;
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

    public function cashCauseBadge()
    {
        $lookUp = LookUp::where('group_code', 'CASH_CAUSE')
            ->where('key', $this->cash_cause)
            ->first();

        return $lookUp != null ? join('', ["<span class='badge ", BadgeHelper::getBadgeClass($lookUp->id), "'>", ucfirst($lookUp->label), '</span>']) : '-';
    }

    public function ioCashBadge()
    {
        $io_badge = $this->io_cash == 'I' ? 'badge-success' : 'badge-danger';

        $lookUp = LookUp::where('group_code', 'IO_CASH')
            ->where('key', $this->io_cash)
            ->first();

        return $lookUp != null ? join('', ["<span class='badge ", $io_badge, "'>", ucfirst($lookUp->label), '</span>']) : '-';
    }

    public function cashCauseText()
    {
        $lookUp = LookUp::where('group_code', 'CASH_CAUSE')
            ->where('key', $this->cash_cause)
            ->first();

        return $lookUp != null ? $lookUp->label : '-';
    }

    public function ioCashText()
    {
        $lookUp = LookUp::where('group_code', 'IO_CASH')
            ->where('key', $this->io_cash)
            ->first();

        return $lookUp != null ? $lookUp->label : '-';
    }
}
