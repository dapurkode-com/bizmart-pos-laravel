<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusFieldOnOpnameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('opnames', function (Blueprint $table) {
            $table->enum('status', ["On Going","Done"])->default("On Going")->after('updated_by');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('opnames', function (Blueprint $table) {
            $table->removeColumn('status');
        });
    }
}
