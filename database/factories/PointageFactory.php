<?php

use Faker\Generator as Faker;

$factory->define(App\Pointage::class, function (Faker $faker) {
    return [
        'date' => $faker->dateTimeBetween($startDate = '01-01-2018 08:50:17', $endDate = '05-01-2019 09:15:09', $timezone = null) ,
        'type' => 'arrivee',
        'user_id' =>  $faker->numberBetween(1,10)
        ];
});
