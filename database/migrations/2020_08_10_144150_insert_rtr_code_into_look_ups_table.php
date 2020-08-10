<?php

use App\LookUp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertRtrCodeIntoLookUpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        LookUp::insert(
            [
                'group_code'    => 'STC_CUASE',
                'key'           => 'RTR',
                'look_up_key'   => 'STC_CUASE.RTR',
                'group_label'   => 'Stock Log - Cause',
                'label'         => 'Retur Barang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
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
