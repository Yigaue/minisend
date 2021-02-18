<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // UsersTableSeeder::class,
            // EmailTableSeeder::class,
            // RecipientTableSeeder::class,
            // SenderRecipientSeeder::class,
            StatusTableSeeder::class
        ]);
    }
}
