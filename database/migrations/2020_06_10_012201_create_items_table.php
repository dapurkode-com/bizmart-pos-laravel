<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('barcode');
            $table->text('description')->nullable();
            $table->boolean('is_stock_active');
            $table->foreignId('unit_id')->constrained()->cascadeOnDelete();
            $table->integer('stock')->default('0');
            $table->integer('min_stock')->default('0');
            $table->double('sell_price')->default('0');
            $table->double('buy_price')->default('0');
            $table->double('profit')->default('0');
            $table->enum('sell_price_determinant', ["0","1","2","3"])->default('0');
            $table->float('margin')->default('0');
            $table->float('markup')->default('0');
            $table->timestamp('last_buy_at')->nullable();
            $table->timestamp('last_sell_at')->nullable();
            $table->timestamp('last_opname:at')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('items');
    }
}
