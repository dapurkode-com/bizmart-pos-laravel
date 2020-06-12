<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SystemParam;
use Faker\Generator as Faker;

$factory->define(SystemParam::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text,
        'param_code' => $faker->word,
        'param_value' => $faker->word,
        'in_type' => $faker->randomElement(["text","number","select"]),
        'group_code' => $faker->word,
    ];
});
