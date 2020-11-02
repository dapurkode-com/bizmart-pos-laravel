<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBuyPaymentHsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buy_payment_hs', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('buy_id')->constrained()->cascadeOnDelete();
            $table->string('created_by')->nullable()->after('note');
            $table->string('updated_by')->nullable()->after('created_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buy_payment_hs', function (Blueprint $table) {
            $table->removeColumn('user_id');
            $table->removeColumn('created_by');
            $table->removeColumn('updated_by');
        });
    }
}
