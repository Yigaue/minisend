<?php

namespace Tests\Feature\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    /**
     * @test
     * @return void
     */

    public function user_require_token_to_view_resource()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();

        $user->token = null;
        $user->save();

        $this->getJson('/api/v1/emails', ['Authorization' => "Bearer $token"])
            ->assertStatus(401);
    }

    /**
     * login test.
     * @test
     * @return void
     */
    public function requires_emails_password_to_login()
    {
        $this->postJson('api/login')
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.']
                ],
            ]);
    }

    /**
    * @test
     * @return void
     */
    public function that_user_can_logins_successfully()
    {
        factory(User::class)->create([
            'email' => 'johndoe@example.com',
            'password' => bcrypt('password'),
        ]);

        $data = ['email' => 'johndoe@example.com', 'password' => 'password'];

        $this->postJson('api/login', $data)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                    'token',
                ],
            ]);

    }
    /**
     * @test
     */

    public function that_user_can_registers_successfully()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $this->postJson('/api/register', $data)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                    'token',
                ],
            ]);
    }

    /**
     * @test
     * @return void
     */

    public function require_password_confirmation_to_login()
    {
        $payload = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password',
        ];

        $this->postJson('/api/register', $payload)
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'password' => ['The password confirmation does not match.']
                ],
            ]);
    }

    /**
     * Undocumented function
     * @test
     * @return void
     */
    public function requires_users_name_email_and_password()
    {
        $this->postJson('/api/register')
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',

                'errors' => [
                    'name' => ['The name field is required.'],
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.']
                ],
            ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function that_user_can_logout_successfully()
    {
        $user = factory(User::class)->create(['email' => 'johndoe@example.com']);

        $token = $user->generateToken();

        $headers = ['Authorization' => "Bearer $token"];

        $this->getJson('/api/v1/emails', $headers)->assertStatus(200);
        
        $this->postJson('/api/logout', [], $headers)->assertStatus(200);

        $user = $user->fresh();

        $this->assertEquals(null, $user->token);
    }
}
