<?php

use Faker\Generator as Faker;

$factory->define(App\Finance::class, function (Faker $faker) {

    $bankAccount = factory(\App\BankAccount::class)->create();
    $category = factory(\App\Category::class)->create();

    return [
        'bank_account_id' => $bankAccount->id,
        'category_id' => $category->id,
        'description' => $faker->words(3, true),
        'dc' => $faker->randomElement(['D', 'C']),
        'date' => $faker->date(),
        'amount' => $faker->randomFloat(2, 100, 10000),
    ];
});
