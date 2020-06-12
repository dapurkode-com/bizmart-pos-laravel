<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Opname;
use Faker\Generator as Faker;

$factory->define(Opname::class, function (Faker $faker) {
    return [
        'uniq_id' => $faker->word,
        'user_id' => factory(\App\User::class),
        'summary' => $faker->text,
        'created_by' => $faker->word,
        'updated_by' => $faker->word,
    ];
});
