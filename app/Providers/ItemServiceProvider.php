<?php

namespace App\Providers;

use App\Item;
use App\StockLog;
use App\SystemParam;
use Illuminate\Support\ServiceProvider;

/**
 * ItemServiceProvider
 *
 * Provider pada Item untuk menentukan harga jual
 *
 * @package ServiceProvide
 * @author Satya Wibawa <i.g.b.n.satyawibawa@gmail.com>
 *
 */
class ItemServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Pada proses create data barang
        Item::creating(function ($item) {
            $rounding = SystemParam::where('param_code', 'RND_SELL_PRC')->first()->param_value; //mengambil nilai rounding dari system_params
            if ($item->buy_price != 0 && $item->buy_price != null) {
                if ($item->sell_price_determinant == 0) {
                    //Harga jual ditentukan sendiri
                    $item->profit = $item->sell_price - $item->buy_price;
                    $item->margin = (($item->sell_price - $item->buy_price) / $item->sell_price) * 100;
                    $item->markup = (($item->sell_price - $item->buy_price) / $item->buy_price) * 100;
                } else if ($item->sell_price_determinant == 1 && $item->margin > 0) {
                    //Harga jual ditentukan margin
                    $item->sell_price = $item->buy_price / (1 - $item->margin / 100);
                    $item->sell_price = round($item->sell_price, $rounding);
                    $item->profit = $item->sell_price - $item->buy_price;
                    $item->markup = (($item->sell_price - $item->buy_price) / $item->buy_price) * 100;
                } else if ($item->sell_price_determinant == 2 && $item->markup > 0) {
                    //Harga jual ditentukan markup
                    $item->sell_price = ($item->buy_price) + ($item->markup / 100 * $item->buy_price);
                    $item->sell_price = round($item->sell_price, $rounding);
                    $item->profit = $item->sell_price - $item->buy_price;
                    $item->margin = (($item->sell_price - $item->buy_price) / $item->sell_price) * 100;
                } else if ($item->sell_price_determinant == 3) {
                    //Harga jual ditentukan profit
                    $item->sell_price = ($item->buy_price) + ($item->profit);
                    $item->sell_price = round($item->sell_price, $rounding);
                    $item->margin = (($item->sell_price - $item->buy_price) / $item->sell_price) * 100;
                    $item->markup = (($item->sell_price - $item->buy_price) / $item->buy_price) * 100;
                }
            } else {
                $item->profit = $item->sell_price;
                $item->markup = 100;
                $item->margin = 100;
            }
        });

        Item::created(function ($item) {
            StockLog::create([
                'cause' => 'NIT',
                'in_out_position' => 'IN',
                'qty' => $item->stock != null ? $item->stock : 0,
                'old_stock' => $item->stock != null ? $item->stock : 0,
                'new_stock' => $item->stock != null ? $item->stock : 0,
                'buy_price' => $item->buy_price,
                'sell_price' => $item->sell_price,
                'item_id' => $item->id
            ]);
        });

        //Pada proses update data barang
        Item::updating(function ($item) {
            $rounding = SystemParam::where('param_code', 'RND_SELL_PRC')->first()->param_value; //mengambil nilai rounding dari system_params
            if ($item->buy_price != 0 && $item->buy_price != null) {
                if ($item->sell_price_determinant == 0) {
                    // Harga jual ditentukan sendiri
                    $item->profit = $item->sell_price - $item->buy_price;
                    $item->margin = (($item->sell_price - $item->buy_price) / $item->sell_price) * 100;
                    $item->markup = (($item->sell_price - $item->buy_price) / $item->buy_price) * 100;
                } else if ($item->sell_price_determinant == 1 && $item->margin > 0) {
                    $item->sell_price = $item->buy_price / (1 - $item->margin / 100);
                    // Harga jual ditentukan margin
                    $item->sell_price = round($item->sell_price, $rounding);
                    $item->profit = $item->sell_price - $item->buy_price;
                    $item->markup = (($item->sell_price - $item->buy_price) / $item->buy_price) * 100;
                } else if ($item->sell_price_determinant == 2 && $item->markup > 0) {
                    // Harga jual ditentukan markup
                    $item->sell_price = ($item->buy_price) + ($item->markup / 100 * $item->buy_price);
                    $item->sell_price = round($item->sell_price, $rounding);
                    $item->profit = $item->sell_price - $item->buy_price;
                    $item->margin = (($item->sell_price - $item->buy_price) / $item->sell_price) * 100;
                } else if ($item->sell_price_determinant == 3) {
                    // Harga jual ditentukan profit
                    $item->sell_price = ($item->buy_price) + ($item->profit);
                    $item->sell_price = round($item->sell_price, $rounding);
                    $item->margin = (($item->sell_price - $item->buy_price) / $item->sell_price) * 100;
                    $item->markup = (($item->sell_price - $item->buy_price) / $item->buy_price) * 100;
                }
            } else {
                $item->profit = $item->sell_price;
                $item->markup = 100;
                $item->margin = 100;
            }
        });
    }
}
