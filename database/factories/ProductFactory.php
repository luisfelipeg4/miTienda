<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Products;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Products::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text,
        'price' => $faker->numberBetween(0,1000000),
        'photo' => $faker->imageUrl(),
        '_token' => csrf_token()

    ];
});
