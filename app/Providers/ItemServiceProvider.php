<?php

namespace App\Providers;

use App\Item;
use App\SystemParam;
use Illuminate\Support\ServiceProvider;

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
        Item::creating(function ($item) {
            $rounding = SystemParam::where('param_code', 'RND_SELL_PRC')->first()->param_value;
            if ($item->buy_price != 0) {
                if ($item->sell_price_determinant == 0) {
                    $item->profit = $item->sell_price - $item->buy_price;
                    $item->margin = (($item->sell_price - $item->buy_price) / $item->sell_price) * 100;
                    $item->markup = (($item->sell_price - $item->buy_price) / $item->buy_price) * 100;
                } else if ($item->sell_price_determinant == 1 && $item->margin > 0) {
                    $item->sell_price = $item->buy_price / (1 - $item->margin / 100);
                    $item->sell_price = round($item->sell_price, $rounding);
                    $item->profit = $item->sell_price - $item->buy_price;
                    $item->markup = (($item->sell_price - $item->buy_price) / $item->buy_price) * 100;
                } else if ($item->sell_price_determinant == 2 && $item->markup > 0) {
                    $item->sell_price = ($item->buy_price) + ($item->markup / 100 * $item->buy_price);
                    $item->sell_price = round($item->sell_price, $rounding);
                    $item->profit = $item->sell_price - $item->buy_price;
                    $item->margin = (($item->sell_price - $item->buy_price) / $item->sell_price) * 100;
                } else if ($item->sell_price_determinant == 3) {
                    $item->sell_price = ($item->buy_price) + ($item->profit);
                    $item->sell_price = round($item->sell_price, $rounding);
                    $item->margin = (($item->sell_price - $item->buy_price) / $item->sell_price) * 100;
                    $item->markup = (($item->sell_price - $item->buy_price) / $item->buy_price) * 100;
                }
            }
        });

        Item::updating(function ($item) {
            $rounding = SystemParam::where('param_code', 'RND_SELL_PRC')->first()->param_value;
            // dd($rounding);
            if ($item->buy_price != 0) {
                if ($item->sell_price_determinant == 0) {
                    $item->profit = $item->sell_price - $item->buy_price;
                    $item->margin = (($item->sell_price - $item->buy_price) / $item->sell_price) * 100;
                    $item->markup = (($item->sell_price - $item->buy_price) / $item->buy_price) * 100;
                } else if ($item->sell_price_determinant == 1 && $item->margin > 0) {
                    $item->sell_price = $item->buy_price / (1 - $item->margin / 100);
                    $item->sell_price = round($item->sell_price, $rounding);
                    $item->profit = $item->sell_price - $item->buy_price;
                    $item->markup = (($item->sell_price - $item->buy_price) / $item->buy_price) * 100;
                } else if ($item->sell_price_determinant == 2 && $item->markup > 0) {
                    $item->sell_price = ($item->buy_price) + ($item->markup / 100 * $item->buy_price);
                    $item->sell_price = round($item->sell_price, $rounding);
                    $item->profit = $item->sell_price - $item->buy_price;
                    $item->margin = (($item->sell_price - $item->buy_price) / $item->sell_price) * 100;
                } else if ($item->sell_price_determinant == 3) {
                    $item->sell_price = ($item->buy_price) + ($item->profit);
                    $item->sell_price = round($item->sell_price, $rounding);
                    $item->margin = (($item->sell_price - $item->buy_price) / $item->sell_price) * 100;
                    $item->markup = (($item->sell_price - $item->buy_price) / $item->buy_price) * 100;
                }
            }
        });
    }
}
