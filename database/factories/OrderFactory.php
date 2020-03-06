<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Orders;
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

$factory->define(Orders::class, function (Faker $faker) {
    return [
        'product_id' => $faker->numberBetween(0,10),
        'customer_email' => $faker->email(),
        'customer_mobile' => $faker->numberBetween(0,1000000),
        'customer_name' => $faker->name(),
        'status'=>'CREATED',
        '_token' => csrf_token()

    ];
});
