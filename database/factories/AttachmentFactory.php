<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Attachment;
use App\Email;
use Faker\Generator as Faker;

$factory->define(
    Attachment::class, function (Faker $faker) {
        return [
            'email_id' => function () {
                return factory(Email::class)->create()->id;
            },

            'file_link' => $faker->url
        ];
    }
);
