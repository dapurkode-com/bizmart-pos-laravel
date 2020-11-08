<?php

use App\LookUp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBuyAndSellStatusLookUp extends Migration
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
                'group_code' => 'SELL_STATUS',
                'key' => 'PO',
                'look_up_key' => 'SELL_STATUS.PO',
                'group_label' => 'Status Pembayaran Penjualan',
                'label' => 'Lunas',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ], [
                'group_code' => 'SELL_STATUS',
                'key' => 'RE',
                'look_up_key' => 'SELL_STATUS.RE',
                'group_label' => 'Status Pembayaran Penjualan',
                'label' => 'Piutang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'group_code' => 'BUY_STATUS',
                'key' => 'PO',
                'look_up_key' => 'BUY_STATUS.PO',
                'group_label' => 'Status Pembayaran Pembelian',
                'label' => 'Lunas',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ], [
                'group_code' => 'BUY_STATUS',
                'key' => 'DE',
                'look_up_key' => 'BUY_STATUS.DE',
                'group_label' => 'Status Pembayaran Pembelian',
                'label' => 'Hutang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
