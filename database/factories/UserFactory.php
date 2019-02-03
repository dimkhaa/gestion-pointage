<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'nom' => $faker->firstNameMale($gender=null),
        'prenom' => $faker->lastName,
        'dateNaisse' => $faker->date($format = 'dd-mm-YYYY', $max = '01-01-2000'),
        'sexe' => 'male',
        'role' => 0,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('123456'), 
        'service_id' => $faker->numberBetween(1,20),
        'horaire_id' => $faker->numberBetween(1,2),
        'remember_token' => str_random(10),
    ];
});
