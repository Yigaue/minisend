<?php

namespace Tests\Feature;

use App\Models\Email;
use App\Models\Status;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmailsTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    /**
     * @test
     *
     * @return void
     */
    public function it_returns_emails_resource()
    {
        factory(Email::class, 2)->create();
        $response = $this->getJson('/api/v1/emails', [
            'accept' => 'application/json',
            'Content-Type' => 'application/json'
        ]);

        $response->assertStatus(200);
    }

    /**
     * @test
     */

    public function it_returns_a_email_resource()
    {
        $email = factory(Email::class)->create();
        $response = $this->getJson("/api/v1/emails/$email->id", [
            'accept' => 'application/json',
            'content-type' => 'application/json'
        ]);

        $formatedDate = \Carbon\Carbon::parse($email->created_at)->format('d M');
        $response->assertStatus(200)->assertJson(
            ["data" => [
                    "id" => $email->id,
                    "alias"=> $email->alias,
                    "from" => $email->from,
                    "subject" => $email->subject,
                    "content" =>  $email->content,
                    "formated_date" =>  $formatedDate,
                    "attachments" => []
                ],
            ]
        );
    }

    /**
     *
     * @test
     */

    public function can_store_and_send_emails()
    {
        factory(Status::class)->create();
        $response = $this->postJson('/api/v1/emails', [
            'from' => 'johndoe@example.com',
            'to' => 'janedoe@example.com',
            'alias' => 'John Doe',
            'subject' => 'Dearly Beloved',
            'content' => 'Dear Jane Joe, I write...',
            'created_at' => now(),
            'updated_at' => now()
            ],
            [
                'accept' => 'application/json',
                'comtent-type' => 'application/json'
            ]
        );

        $response = $response->assertStatus(201);
        $response->assertJson(
            ["data" => [
                    "alias"=> 'John Doe',
                    "from" => 'johndoe@example.com',
                    "subject" => 'Dearly Beloved',
                    "content" =>  'Dear Jane Joe, I write...'
                ],
            ]
        );

        $this->assertDatabaseHas('emails', [
            "alias"=> 'John Doe',
            "from" => 'johndoe@example.com',
            "subject" => 'Dearly Beloved',
            "content" =>  'Dear Jane Joe, I write...'
        ]);
    }

    /**
     * Undocumented function
     *@test
     * @return void
     */
    public function that_we_can_see_the_compose_email_page()
    {
        $this->getJson('/emails/v1/create')->assertStatus(200)
            ->assertSee('to');
    }

    /**
     * Undocumented function
     *@test
     * @return void
     */
    public function that_can_delete_an_email_resource()
    {
        factory(Status::class)->create(['id' => 5]);
        $email = factory(Email::class)->create();
        $this->assertNotEquals($email->status_id, Status::DELETED);
        $response =  $this->deleteJson("/api/v1/emails/$email->id")->assertStatus(200);
        $this->assertEquals('"Email deleted successfully"', $response->getContent());
        $email = $email->fresh();
        $this->assertEquals($email->status_id, Status::DELETED);
    }
}
