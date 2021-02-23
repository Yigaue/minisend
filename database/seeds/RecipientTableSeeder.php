<?php

use Illuminate\Database\Seeder;

class RecipientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Recipient::class, 20)->create();
    }
}
