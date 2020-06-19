<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Carbon\Carbon;

$factory->define(App\Listing::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text,
        'public_listed' => 1
    ];
});
