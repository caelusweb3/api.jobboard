<?php

use App\Category;
use App\Employer;
use App\Job;
use App\User;
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
        'name' => $faker->name,
        'surname'=>$faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'gender'  => $faker->randomElement([User::MALE,User::FEMALE]),
        'age'       => $faker->numberBetween(1,100),
        'phone'     => $faker->phoneNumber,
        'address' => $faker->address,
        'personal_info'  => $faker->paragraph,
        'verified'    => $faker->randomElement([User::UNVERIFIED_USER,User::VERIFIED_USER]),
        'verification_token' => User::generateVerificationCode(),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Job::class, function (Faker $faker) {
    return [
        'employer_id'=>Employer::all()->random()->id,
        'category_id'=>Category::all()->random()->id,
        'title'      => $faker->jobTitle,
        'work_style' => $faker->randomElement([Job::GUNLUK, Job::PART_TIME,Job::FREELANCE]),
        'address'    => $faker->address,
        'fee'        => $faker->randomNumber(),
        'description'=> $faker->paragraph,
        'begin_date' => $faker->dateTimeThisCentury->format("Y-m-d H:i:s"),
        'person_count'=>$faker->randomNumber(),
        'wear'        => $faker->jobTitle,
        'tool'        => $faker->jobTitle,

    ];
});

    $factory->define(App\Employer::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'address'    => $faker->address,
        'phone'        => $faker->phoneNumber,
        'employer_info' => $faker->paragraph,

    ];
});