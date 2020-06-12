<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Suplier;
use Faker\Generator as Faker;

$factory->define(Suplier::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'address' => $faker->word,
        'phone' => $faker->phoneNumber,
        'description' => $faker->text,
        'created_by' => $faker->word,
        'updated_by' => $faker->word,
    ];
});
