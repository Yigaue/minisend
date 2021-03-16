<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ApplicationDevelopmentSetUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Quickly setup this app for development';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Wait while we setup the app development environment');
        $this->MigrationAndSeeder();
        $user = $this->CreateNewUser();
        $this->CreatePersonalAccessClient($user);
        $this->CreatePersonalAccessToken($user);
        $this->info('Great, you\'re good to go 😎!');
    }

    public function MigrationAndSeeder()
    {
        $this->call('migrate:fresh');
        $this->call('db:seed');
    }

    public function CreateNewUser()
    {
        $this->info('Creating test user');
        $user = factory(User::class)->create([
            'name' => 'Test User',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->info('Test User created');
        $this->warn('Email: test@example.com');
        $this->warn('Password: passport');
        return $user;
    }

    public function CreatePersonalAccessClient($user)
    {

        $this->call('passport:client', [
            '--personal' => true,
            '--name'     => 'Personal Access Client'
        ]);

        DB::table('oauth_clients')->where('name', 'Personal Access Client')
            ->update(['user_id' => $user->id]);
    }

    public function CreatePersonalAccessToken($user)
    {
        $token = $user->createToken('User Token');
        $this->info('Personal access token created successfully.');
        $this->warn("Personal access token:");
        $this->line($token->accessToken);
    }
}
