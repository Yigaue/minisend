<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Email;
use Faker\Generator as Faker;

$factory->define(Email::class, function (Faker $faker) {
    return [
        'alias' => $faker->name,
        'subject' => $faker->sentence,
        'text_content' => $faker->paragraph,
        'html_content' => $faker->randomHtml()
    ];
});
