<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Email;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Email::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create();
        },
        'subject' => $faker->sentence,
        'content' => $faker->paragraph
    ];
});
