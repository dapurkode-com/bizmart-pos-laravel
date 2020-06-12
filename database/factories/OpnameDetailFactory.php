<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\OpnameDetail;
use Faker\Generator as Faker;

$factory->define(OpnameDetail::class, function (Faker $faker) {
    return [
        'opname_id' => factory(\App\Opname::class),
        'item_id' => factory(\App\Item::class),
        'old_stock' => $faker->randomNumber(),
        'new_stock' => $faker->randomNumber(),
        'buy_price' => 0,
        'sell_price' => 0,
        'description' => $faker->text,
        'created_by' => $faker->word,
        'updated_by' => $faker->word,
    ];
});
