<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEvidenFileFieldToSellPaymentHsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sell_payment_hs', function (Blueprint $table) {
            $table->string("eviden_file")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sell_payment_hs', function (Blueprint $table) {
            $table->removeColumn("eviden_file");
        });
    }
}
