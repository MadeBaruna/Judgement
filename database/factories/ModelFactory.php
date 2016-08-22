<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(Judgement\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Judgement\Problem::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'time_limit' => $faker->numberBetween(0,5),
        'memory_limit' => $faker->numberBetween(100,5000),
        'contest_id' => 1,
        'author_id' => 1,
    ];
});