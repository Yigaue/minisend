<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Attachment;
use App\Models\Email;
use Faker\Generator as Faker;

$factory->define(
    Attachment::class, function (Faker $faker) {
        return [
            'email_id' => function () {
                return factory(Email::class)->create()->id;
            },

            'file_url' => $faker->url,
            'file_name' => $faker->name
        ];
    }
);
