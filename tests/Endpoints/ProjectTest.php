<?php

namespace Tests\Endpoints;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Notification;
use Modules\Clients\Entities\Client;
use Tests\TestCase;
use Tests\Traits\InteractsWithPassport;

class ProjectTest extends TestCase
{
    use DatabaseTransactions, InteractsWithPassport;

    protected function setUp(): void
    {
        parent::setUp();
        Notification::fake();
    }

    public function test_view_without_authentication()
    {
        $this->getJson('/api/v1/projects')->assertStatus(401);
    }

    public function test_create_without_authentication()
    {
        $this->postJson('/api/v1/projects', [])->assertStatus(401);
    }

    public function test_delete_without_authentication()
    {
        $this->deleteJson('/api/v1/projects/12345')->assertStatus(401);
    }

    public function test_crud_operations()
    {
        $this->createUserWithToken();
        $client_id = Client::factory()->create()->id;
        $payload = [
            'name' => 'Test Project',
            'client_id' => $client_id,
            'currency' => 'USD',
            'billing_method' => 'hourly_project_rate',
            'start_date' => now()->addDays(14)->format(config('system.preferred_date_format')),
            'due_date' => now()->addDays(40)->format(config('system.preferred_date_format')),
            'description' => 'Sample project description',
        ];
        $response = $this->postJson('/api/v1/projects', $payload);
        $response->assertStatus(201)->assertJson([
            'id' => true,
        ]);
        $project = $response->getData()->id;
        $response = $this->getJson('/api/v1/projects/' . $project);
        $response->assertStatus(200)->assertJson([
            'id' => true,
        ]);
        $response = $this->putJson('/api/v1/projects/' . $project, array_prepend($payload, now()->addDays(14)->format(config('system.preferred_date_format')), 'due_date'));
        $response->assertStatus(200)->assertJson([
            'id' => true,
        ]);
        $response = $this->getJson('/api/v1/projects');
        $response->assertStatus(200)->assertJson([
            'data' => true,
        ]);
        $response = $this->deleteJson('/api/v1/projects/' . $project);
        $response->assertStatus(200)->assertJson([
            'message' => true,
        ]);
    }

    public function test_get_undefined_project()
    {
        $this->createUserWithToken();
        $this->getJson('/api/v1/projects/13232323')->assertStatus(404);
    }

    public function test_create_without_payload()
    {
        $this->createUserWithToken();
        $this->postJson('/api/v1/projects', [])->assertStatus(422);
    }

    public function test_delete_undefined_project()
    {
        $this->createUserWithToken();
        $this->deleteJson('/api/v1/projects/13232323')->assertStatus(404);
    }
}
