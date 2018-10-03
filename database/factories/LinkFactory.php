<?php

use Faker\Generator as Faker;

$factory->define(App\Link::class, function (Faker $faker) {
    return [
    	'url' => $faker->unique()->url,
    	'code' => str_random(10),
    	'counter' => 1,
    	'status' => 1
    ];
});
