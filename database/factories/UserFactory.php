<?php

use App\User;
use Carbon\Carbon;
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

$factory->define(User::class, function (Faker $faker) {
    $user = $faker->firstname;
    return [
        'username' => $user.random_int(0, 2),
        'firstname' => $user,
        'lastname' => $faker->lastname,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('secret'),
        'remember_token' => str_random(10),
        'birthdate' => Carbon::parse('-15years')->format('Y-m-d'),
        'complete' => 0,
    ];
});

$factory->state(User::class, 'manual', [
    'username' => 'manuell',
    'firstname' => 'manuell',
    'lastname' => 'manuell',
    'email' => 'manuell@manuell.test',
    'password' => bcrypt('secret'),
    'birthdate' => Carbon::parse('-15years')->format('Y-m-d'),
    'complete' => 0,
]);

$factory->state(User::class, 'details', [
    'role' => 'user',
    'zip' => '12345',
    'diet' => 'normal',
    'complete' => 1,
    'mobile' => '123456789'
]);