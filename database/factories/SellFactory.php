<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Sell;
use Faker\Generator as Faker;

$factory->define(Sell::class, function (Faker $faker) {
    return [
        'uniq_id' => $faker->word,
        'user_id' => factory(\App\User::class),
        'member_id' => factory(\App\Member::class),
        'summary' => 0,
        'tax' => 0,
        'note' => $faker->text,
        'created_by' => $faker->word,
        'updated_by' => $faker->word,
    ];
});
