<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Item;
use Faker\Generator as Faker;

$factory->define(Item::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'barcode' => $faker->word,
        'description' => $faker->text,
        'is_stock_active' => $faker->boolean,
        'unit_id' => factory(\App\Unit::class),
        'stock' => $faker->randomNumber(),
        'min_stock' => $faker->randomNumber(),
        'sell_price' => $faker->randomNumber(),
        'buy_price' => $faker->randomNumber(),
        'profit' => $faker->randomNumber(),
        'sell_price_determinant' => $faker->randomElement(["0", "1", "2", "3"]),
        'margin' => $faker->randomFloat(0, 0, 9),
        'markup' => $faker->randomFloat(0, 0, 9),
        'last_buy_at' => $faker->dateTime(),
        'last_sell_at' => $faker->dateTime(),
        'last_opname:at' => $faker->dateTime()
    ];
});
