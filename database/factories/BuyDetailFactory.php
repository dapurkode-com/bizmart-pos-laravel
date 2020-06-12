<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\BuyDetail;
use Faker\Generator as Faker;

$factory->define(BuyDetail::class, function (Faker $faker) {
    return [
        'buy_id' => factory(\App\Buy::class),
        'item_id' => factory(\App\Item::class),
        'qty' => 0,
        'buy_price' => 0,
    ];
});
