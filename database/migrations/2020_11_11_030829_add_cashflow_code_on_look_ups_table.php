<?php

use App\LookUp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCashflowCodeOnLookUpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        LookUp::insert([
            [
                'group_code' => 'CASH_CAUSE',
                'key' => 'BY',
                'look_up_key' => 'CASH_CAUSE.BY',
                'group_label' => 'Jenis Penyebab cashflow',
                'label' => 'Pembelian',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ],
            [
                'group_code' => 'CASH_CAUSE',
                'key' => 'SL',
                'look_up_key' => 'CASH_CAUSE.SL',
                'group_label' => 'Jenis Penyebab cashflow',
                'label' => 'Penjualan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ],
            [
                'group_code' => 'CASH_CAUSE',
                'key' => 'OR',
                'look_up_key' => 'CASH_CAUSE.OR',
                'group_label' => 'Jenis Penyebab cashflow',
                'label' => 'Pendapatan Lainnya',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ],
            [
                'group_code' => 'CASH_CAUSE',
                'key' => 'OE',
                'look_up_key' => 'CASH_CAUSE.OE',
                'group_label' => 'Jenis Penyebab cashflow',
                'label' => 'Pengeluaran Lainnya',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ],
            [
                'group_code' => 'CASH_CAUSE',
                'key' => 'SO',
                'look_up_key' => 'CASH_CAUSE.SO',
                'group_label' => 'Jenis Penyebab cashflow',
                'label' => 'Stock Opname',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ],
            [
                'group_code' => 'CASH_CAUSE',
                'key' => 'RE',
                'look_up_key' => 'CASH_CAUSE.RE',
                'group_label' => 'Jenis Penyebab cashflow',
                'label' => 'Retur Barang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ],
            [
                'group_code' => 'IO_CASH',
                'key' => 'I',
                'look_up_key' => 'IO_CASH.I',
                'group_label' => 'Posisi Arus Kas',
                'label' => 'Masuk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ],
            [
                'group_code' => 'IO_CASH',
                'key' => 'O',
                'look_up_key' => 'IO_CASH.O',
                'group_label' => 'Posisi Arus Kas',
                'label' => 'Keluar',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        LookUp::whereIn('group_code', ['IO_CASH', 'CASH_CAUSE'])->delete();
    }
}
