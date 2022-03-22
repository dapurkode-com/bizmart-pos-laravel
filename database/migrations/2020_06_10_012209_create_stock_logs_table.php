<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_logs', function (Blueprint $table) {
            $table->id();
            $table->string('ref_uniq_id', 40);
            $table->string('cause');
            $table->string('in_out_position');
            $table->integer('qty')->default('0');
            $table->integer('old_stock')->default('0');
            $table->integer('new_stock')->default('0');
            $table->double('buy_price')->default('0');
            $table->double('sell_price')->default('0');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_logs');
    }
}
