<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\StockLog;
use Faker\Generator as Faker;

$factory->define(StockLog::class, function (Faker $faker) {
    return [
        'ref_uniq_id' => $faker->word,
        'cause' => $faker->randomElement(["BUY", "SELL", "ADJ"]),
        'in_out_position' => $faker->randomElement(["IN", "OUT"]),
        'qty' => $faker->randomNumber(),
        'old_stock' => $faker->randomNumber(),
        'new_stock' => $faker->randomNumber(),
        'buy_price' => 0,
        'sell_price' => 0,
        'created_by' => $faker->word,
        'updated_by' => $faker->word,
    ];
});
