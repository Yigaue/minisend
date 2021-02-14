<?php

use App\SenderRecipient;
use Illuminate\Database\Seeder;

class SenderRecipientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(SenderRecipient::class, 10)->create();
    }
}
