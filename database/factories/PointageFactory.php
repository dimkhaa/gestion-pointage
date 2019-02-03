<?php

use Faker\Generator as Faker;

$factory->define(App\Pointage::class, function (Faker $faker) {
    return [
        'date' => $faker->dateTimeBetween($startDate = '01-01-2018 08:50:17', $endDate = '05-01-2019 09:15:09', $timezone = null) ,
        'type' => 'arrivee',
        'users_id' =>  $faker->numberBetween(1,50),
        'remember_token' => str_random(10),
    ];
});
$factory->define(App\Pointage::class, function (Faker $faker) {
    return [
        'date' => $faker->dateTimeBetween($startDate = '01-01-2018 17:50:01', $endDate = '05-01-2019 20:30:21', $timezone = null) ,
        'type' => 'depart',
        'users_id' =>  $faker->numberBetween(1,50),
        'remember_token' => str_random(10),
    ];
});
