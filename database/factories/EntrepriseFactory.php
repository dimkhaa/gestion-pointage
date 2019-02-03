<?php

use Faker\Generator as Faker;

$factory->define(App\Entreprise::class, function (Faker $faker) {
    return [
        'nom' => $faker->name,
        'remember_token' => str_random(10),
    ];
});
