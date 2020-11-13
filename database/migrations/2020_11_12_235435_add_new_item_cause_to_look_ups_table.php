<?php

use App\LookUp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewItemCauseToLookUpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        LookUp::where('group_code', 'STC_CUASE')->delete();
        LookUp::insert([
            array(
                'group_code'    => 'STC_CAUSE',
                'key'           => 'ADJ',
                'look_up_key'   => 'STC_CAUSE.ADJ',
                'group_label'   => 'Stock Log - Cause',
                'label'         => 'Stock Opname',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
            array(
                'group_code'    => 'STC_CAUSE',
                'key'           => 'BUY',
                'look_up_key'   => 'STC_CAUSE.BUY',
                'group_label'   => 'Stock Log - Cause',
                'label'         => 'Pembelian',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
            array(
                'group_code'    => 'STC_CAUSE',
                'key'           => 'SELL',
                'look_up_key'   => 'STC_CAUSE.SELL',
                'group_label'   => 'Stock Log - Cause',
                'label'         => 'Penjualan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
            [
                'group_code'    => 'STC_CAUSE',
                'key'           => 'RTR',
                'look_up_key'   => 'STC_CAUSE.RTR',
                'group_label'   => 'Stock Log - Cause',
                'label'         => 'Retur Barang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'group_code'    => 'STC_CAUSE',
                'key'           => 'NIT',
                'look_up_key'   => 'STC_CAUSE.NIT',
                'group_label'   => 'Stock Log - Cause',
                'label'         => 'Barang Baru',
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
    }
}
