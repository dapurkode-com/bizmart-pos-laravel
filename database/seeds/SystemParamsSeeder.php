<?php

use Carbon\Carbon;
use App\SystemParam;
use Illuminate\Database\Seeder;

class SystemParamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $system_params = [
            array(
                'name'          => 'Nama Toko',
                'param_code'    => 'MRCH_NAME',
                'param_value'   => 'CV. DS Grafika',
                'in_type'       => 'text'
            ),
            array(
                'name'          => 'Alamat Toko',
                'param_code'    => 'MRCH_ADDR',
                'param_value'   => 'Jl. Jayagiri XXI B No. 2, Sumerta Kauh, Kec. Denpasar Timur',
                'in_type'       => 'text'
            ),
            array(
                'name'          => 'Status Pajak PPN',
                'param_code'    => 'TAX_ACTV',
                'param_value'   => '0',
                'in_type'       => 'select',
                'group_code'    => 'TAX_ACTV'
            ),
            array(
                'name'          => 'Besar Pajak PPN',
                'description'   => 'Besaran dalam persen',
                'param_code'    => 'TAX_PRCT',
                'param_value'   => '10',
                'in_type'       => 'number',
            ),
        ];

        foreach ($system_params as $param) {

            SystemParam::insert(array_merge(
                $param,
                [
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]
            ));
        }
    }
}
