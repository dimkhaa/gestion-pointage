<?php

use Faker\Generator as Faker;

$factory->define(App\Service::class, function (Faker $faker) {
    return [
        'libelleService' => $faker->lastName,
        'entreprise_id' => $faker->numberBetween(1,5)
    ];
});
