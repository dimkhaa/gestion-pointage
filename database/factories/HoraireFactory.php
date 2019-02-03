<?php

use Faker\Generator as Faker;

$factory->define(App\Horaire::class, function (Faker $faker) {
    return [
        'heureDebut' => $faker->time($format='H:i:s',$max='now'),
        'heureFin' => $faker->time($format='H:i:s',$max='now')
        ];
});