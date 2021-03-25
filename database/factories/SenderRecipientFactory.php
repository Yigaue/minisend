<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Email;
use App\Models\Recipient;
use App\Models\SenderRecipient;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(SenderRecipient::class, function (Faker $faker) {
    return [
        'email_id' => function () {
            return factory(Email::class);
        },

        'recipient_id' => function () {
            return factory(Recipient::class)->create();
        }
    ];
});
