<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Unit;
use Faker\Generator as Faker;

$factory->define(Unit::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text,
        'created_by' => $faker->word,
        'updated_by' => $faker->word,
    ];
});
