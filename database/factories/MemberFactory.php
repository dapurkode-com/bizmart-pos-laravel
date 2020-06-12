<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Member;
use Faker\Generator as Faker;

$factory->define(Member::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'address' => $faker->word,
        'phone' => $faker->phoneNumber,
        'created_by' => $faker->word,
        'updated_by' => $faker->word,
    ];
});
