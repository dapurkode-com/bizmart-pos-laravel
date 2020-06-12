<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\LookUp;
use Faker\Generator as Faker;

$factory->define(LookUp::class, function (Faker $faker) {
    return [
        'group_code' => $faker->word,
        'key' => $faker->word,
        'look_up_key' => $faker->word,
        'group_label' => $faker->word,
        'label' => $faker->word,
    ];
});
