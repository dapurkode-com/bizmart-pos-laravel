<?php

use App\SystemParam;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertRoundingIntoSystemParamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        SystemParam::updateOrCreate(
            [
                'name' => 'Pembulatan Harga Jual',
                'param_value' => '0',
                'in_type' => 'number'
            ],
            [
                'param_code' => 'RND_SELL_PRC'
            ]
        );
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
