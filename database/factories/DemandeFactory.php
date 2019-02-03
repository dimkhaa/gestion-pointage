<?php

use Faker\Generator as Faker;

$factory->define(App\Demande::class, function (Faker $faker) {
    return [
        'motif' => $faker->firstNameMale(),
        'dateDebut' => $faker->dateTime('10-01-2019 09:00:00'),
        'dateFin' => $faker->dateTime('15-01-2019 09:00:00') ,
        'status' => 0,
        'typeDemande' => 'Conge',
        'users_id' =>  $faker->numberBetween(1,50),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Demande::class, function (Faker $faker) {
    return [
        'motif' => $faker->firstNameMale($gender=null),
        'dateDebut' => $faker->dateTime('05-01-2019 09:00:00'),
        'dateFin' => $faker->dateTime('07-01-2019 09:00:00') ,
        'status' => 0,
        'typeDemande' => 'Absence',
        'users_id' =>  $faker->numberBetween(1,50),
        'remember_token' => str_random(10),
    ];
});
