<?php

use App\LookUp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddingPrivilegeCodeOnLookUpsTable extends Migration
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
                'group_code' => 'PRIV_CODE',
                'key' => 'EM',
                'look_up_key' => 'PRIV_CODE.EM',
                'group_label' => 'Hak Akses',
                'label' => 'Pegawai (Employee)',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ],
            [
                'group_code' => 'PRIV_CODE',
                'key' => 'OW',
                'look_up_key' => 'PRIV_CODE.OW',
                'group_label' => 'Hak Akses',
                'label' => 'Pemilik (Owner)',
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
        LookUp::whereIn('group_code', ['PRIV_CODE'])->delete();
    }
}
