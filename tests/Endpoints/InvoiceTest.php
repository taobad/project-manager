<?php

namespace Tests\Endpoints;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Notification;
use Modules\Clients\Entities\Client;
use Tests\TestCase;
use Tests\Traits\InteractsWithPassport;

class InvoiceTest extends TestCase
{
    use DatabaseTransactions, InteractsWithPassport;

    protected function setUp(): void
    {
        parent::setUp();
        Notification::fake();
    }

    public function test_view_without_authentication()
    {
        $this->getJson('/api/v1/invoices')->assertStatus(401);
    }

    public function test_create_without_authentication()
    {
        $this->postJson('/api/v1/invoices', [])->assertStatus(401);
    }

    public function test_delete_without_authentication()
    {
        $this->deleteJson('/api/v1/invoices/12345')->assertStatus(401);
    }

    public function test_crud_operations()
    {
        $client_id = Client::factory()->create()->id;

        $payload = [
            'reference_no' => generateCode('invoices'),
            'client_id' => $client_id,
            'currency' => 'USD',
            'due_date' => now()->addDays(30)->format(config('system.preferred_date_format')),
        ];
        $this->createUserWithToken();
        $response = $this->postJson('/api/v1/invoices', $payload);
        $response->assertStatus(201)->assertJson([
            'id' => true,
        ]);
        $invoice = $response->getData()->id;
        $response = $this->getJson('/api/v1/invoices/' . $invoice);
        $response->assertStatus(200)->assertJson([
            'id' => true,
        ]);
        $response = $this->putJson('/api/v1/invoices/' . $invoice, array_prepend($payload, 'KES', 'currency'));
        $response->assertStatus(200)->assertJson([
            'id' => true,
        ]);
        $response = $this->getJson('/api/v1/invoices');
        $response->assertStatus(200)->assertJson([
            'data' => true,
        ]);
        $response = $this->deleteJson('/api/v1/invoices/' . $invoice);
        $response->assertStatus(200)->assertJson([
            'message' => true,
        ]);
    }

    public function test_get_undefined_invoice()
    {
        $this->createUserWithToken();
        $this->getJson('/api/v1/invoices/13232323')->assertStatus(404);
    }

    public function test_create_without_payload()
    {
        $this->createUserWithToken();
        $this->postJson('/api/v1/invoices', [])->assertStatus(422);
    }

    public function test_delete_undefined_invoice()
    {
        $this->createUserWithToken();
        $this->deleteJson('/api/v1/invoices/13232323')->assertStatus(404);
    }
}
