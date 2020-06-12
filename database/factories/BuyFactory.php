<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Buy;
use Faker\Generator as Faker;

$factory->define(Buy::class, function (Faker $faker) {
    return [
        'uniq_id' => $faker->word,
        'user_id' => factory(\App\User::class),
        'suplier_id' => factory(\App\Suplier::class),
        'summary' => $faker->text,
        'tax' => 0,
        'note' => $faker->text,
        'created_by' => $faker->word,
        'updated_by' => $faker->word,
    ];
});
