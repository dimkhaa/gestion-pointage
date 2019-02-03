<?php

use Faker\Generator as Faker;

$factory->define(App\Demande::class, function (Faker $faker) {
    return [
        'motif' => $faker->realText($maxNbChars=200,$indexSize=2),
        'dateDebut' => $faker->dateTime('10-01-2019 09:00:00'),
        'dateFin' => $faker->dateTime('15-01-2019 09:00:00') ,
        'status' => 0,
        'typeDemande' => 'Conge',
        'users_id' =>  $faker->numberBetween(1,50)
    ];
});
