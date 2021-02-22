<?php

use App\Status;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            ['name' => 'sent', 'created_at' => now(), 'updated_at' => now()],
            ['name' =>  'failed', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'posted', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'deleted', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'pending', 'created_at' => now(), 'updated_at' => now()]
        ];
        DB::table('status')->insert($statuses);
    }
}
