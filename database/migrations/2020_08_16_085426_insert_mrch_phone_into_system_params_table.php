<?php

use Illuminate\Database\Migrations\Migration;
use App\SystemParam;
use Illuminate\Support\Carbon;

class InsertMrchPhoneIntoSystemParamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        SystemParam::insert([
            'name'          => 'Nomor Kontak Toko',
            'param_code'    => 'MRCH_PHONE',
            'param_value'   => '0361464669',
            'in_type'       => 'text',
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
