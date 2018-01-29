<?php

use Faker\Generator as Faker;

$factory->define(App\Category::class, function (Faker $faker) {
    return [
        'level1' => $faker->numberBetween(1,5),
        'level2' => $faker->numberBetween(1,5),
        'level3' => $faker->numberBetween(1,5),
        'name'   => $faker->words(3, true),
    ];
});
