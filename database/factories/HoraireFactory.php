<?php

use Faker\Generator as Faker;

$factory->define(App\Horaire::class, function (Faker $faker) {
    return [
        'heureDebut' => $faker->time('09:00:00'),
        'heureFin' => $faker->time('18:00:00'),
        'remember_token' => str_random(10),
    ];
});
