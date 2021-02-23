<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Email;
use Faker\Generator as Faker;

$factory->define(Email::class, function (Faker $faker) {
    return [
        'from' => $faker->safeEmail,
        'alias' => $faker->name,
        'subject' => $faker->sentence,
        'content' => $faker->paragraph
    ];
});
