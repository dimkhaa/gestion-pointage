<?php

use Faker\Generator as Faker;

$factory->define(App\Entreprise::class, function (Faker $faker) {
    return [
        'nom' => $faker->company,
        'logo' => null
    ];
});
