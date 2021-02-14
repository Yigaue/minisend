<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Email;
use App\Recipient;
use App\SenderRecipient;
use App\User;
use Faker\Generator as Faker;

$factory->define(SenderRecipient::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create();
        },

        'email_id' => function () {
            return factory(Email::class);
        },

        'recipient_id' => function () {
            return factory(Recipient::class)->create();
        }
    ];
});
