<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SellDetail;
use Faker\Generator as Faker;

$factory->define(SellDetail::class, function (Faker $faker) {
    return [
        'sell_id' => factory(\App\Sell::class),
        'item_id' => factory(\App\Item::class),
        'qty' => 0,
        'sell_price' => 0,
    ];
});
