<?php

use App\LookUp;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertStatusOnLookUpTable extends Migration
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
                'group_code' => 'OPNAME_STATUS',
                'key' => 'ONGO',
                'look_up_key' => 'OPNAME_STATUS.ONGOING',
                'group_label' => 'Status Opname',
                'label' => 'Sedang Berlangsung',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ], [
                'group_code' => 'OPNAME_STATUS',
                'key' => 'DONE',
                'look_up_key' => 'OPNAME_STATUS.DONE',
                'group_label' => 'Status Opname',
                'label' => 'Selesai',
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
