<?php

use App\Attachment;
use App\Email;
use Illuminate\Database\Seeder;

class EmailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Email::class, 20)->create()->each(function ($email) {
            $email->attachments()->createMany(factory(Attachment::class, 2)->make()->toArray());
        });
    }
}
