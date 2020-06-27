<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Carbon\Carbon;

$factory->define(App\Marker::class, function (Faker $faker) {
    return [
        'listing_id' => function () {
            return factory(App\Listing::class)->create()->id;
        },
        'lgt' => -8.10471335,
        'lat' => 39.02606758,
        'name' => $this->faker->name,
        'description' => $this->faker->text,
        'is_approved' => 1
    ];
});
