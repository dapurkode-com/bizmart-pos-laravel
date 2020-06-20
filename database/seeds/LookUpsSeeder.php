<?php

use App\LookUp;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class LookUpsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $look_ups = [
            array(
                'group_code'    => 'TAX_ACTV',
                'key'           => '0',
                'look_up_key'   => 'TAX_ACTV.0',
                'group_label'   => 'Status Pajak PPN',
                'label'         => 'Non Aktif'
            ),
            array(
                'group_code'    => 'TAX_ACTV',
                'key'           => '1',
                'look_up_key'   => 'TAX_ACTV.1',
                'group_label'   => 'Status Pajak PPN',
                'label'         => 'Aktif'
            ),
            array(
                'group_code'    => 'STCK_ACTV',
                'key'           => '0',
                'look_up_key'   => 'STCK_ACTV.0',
                'group_label'   => 'Stok',
                'label'         => 'Non Aktif'
            ),
            array(
                'group_code'    => 'STCK_ACTV',
                'key'           => '1',
                'look_up_key'   => 'STCK_ACTV.1',
                'group_label'   => 'Stok',
                'label'         => 'Aktif'
            ),
            array(
                'group_code'    => 'SLL_PRC_DTRM',
                'key'           => '0',
                'look_up_key'   => 'SLL_PRC_DTRM.0',
                'group_label'   => 'Penentu Harga',
                'label'         => 'Manual'
            ),
            array(
                'group_code'    => 'SLL_PRC_DTRM',
                'key'           => '1',
                'look_up_key'   => 'SLL_PRC_DTRM.1',
                'group_label'   => 'Penentu Harga',
                'label'         => 'Margin'
            ),
            array(
                'group_code'    => 'SLL_PRC_DTRM',
                'key'           => '2',
                'look_up_key'   => 'SLL_PRC_DTRM.2',
                'group_label'   => 'Penentu Harga',
                'label'         => 'Markup'
            ),
            array(
                'group_code'    => 'SLL_PRC_DTRM',
                'key'           => '3',
                'look_up_key'   => 'SLL_PRC_DTRM.3',
                'group_label'   => 'Penentu Harga',
                'label'         => 'Profit'
            ),
            array(
                'group_code'    => 'STC_CUASE',
                'key'           => 'ADJ',
                'look_up_key'   => 'STC_CUASE.ADJ',
                'group_label'   => 'Stock Log - Cause',
                'label'         => 'Stock Opname'
            ),
            array(
                'group_code'    => 'STC_CUASE',
                'key'           => 'BUY',
                'look_up_key'   => 'STC_CUASE.BUY',
                'group_label'   => 'Stock Log - Cause',
                'label'         => 'Pembelian'
            ),
            array(
                'group_code'    => 'STC_CUASE',
                'key'           => 'SELL',
                'look_up_key'   => 'STC_CUASE.SELL',
                'group_label'   => 'Stock Log - Cause',
                'label'         => 'Penjualan'
            ),
            array(
                'group_code'    => 'IN_OUT_POS',
                'key'           => 'IN',
                'look_up_key'   => 'IN_OUT_POS.IN',
                'group_label'   => 'Arus stok',
                'label'         => 'Masuk'
            ),
            array(
                'group_code'    => 'IN_OUT_POS',
                'key'           => 'OUT',
                'look_up_key'   => 'IN_OUT_POS.OUT',
                'group_label'   => 'Arus stok',
                'label'         => 'Keluar'
            ),
        ];

        foreach ($look_ups as $look_up) {

            LookUp::insert(array_merge(
                $look_up,
                [
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]
            ));
        }
    }
}
