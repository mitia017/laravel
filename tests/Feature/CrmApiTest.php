<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CrmApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['user', 'token']);

        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }

    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['user', 'token']);
    }

    public function test_authenticated_user_can_manage_clients()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user, 'sanctum');

        // Create
        $response = $this->postJson('/api/clients', [
            'name' => 'Acme Corp',
            'email' => 'info@acme.com',
            'company' => 'Acme Inc',
        ]);
        $response->assertStatus(201);
        $clientId = $response->json('id');

        // List
        $this->getJson('/api/clients')->assertStatus(200)->assertJsonCount(1);

        // Update
        $this->putJson("/api/clients/{$clientId}", [
            'name' => 'Acme updated',
            'email' => 'info@acme.com',
        ])->assertStatus(200);
        $this->assertDatabaseHas('clients', ['name' => 'Acme updated']);

        // Delete
        $this->deleteJson("/api/clients/{$clientId}")->assertStatus(204);
        $this->assertDatabaseMissing('clients', ['id' => $clientId]);
    }

    public function test_authenticated_user_can_generate_invoice_pdf()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $client = Client::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ]);

        $invoice = Invoice::create([
            'client_id' => $client->id,
            'number' => 'INV-001',
            'amount' => 100.00,
            'status' => 'pending',
            'date' => now(),
        ]);

        $response = $this->get("/api/invoices/{$invoice->id}/download");
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }

    public function test_authenticated_user_can_manage_properties()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user, 'sanctum');

        // Create
        $response = $this->postJson('/api/properties', [
            'title' => 'Luxury Villa',
            'description' => 'Beautiful villa with sea view',
            'price' => 1000000,
            'address' => '123 Ocean Drive',
            'type' => 'villa',
            'status' => 'available',
        ]);
        $response->assertStatus(201);
        $propertyId = $response->json('id');

        // List
        $this->getJson('/api/properties')->assertStatus(200)->assertJsonCount(1);

        // Update
        $this->putJson("/api/properties/{$propertyId}", [
            'title' => 'Updated Villa',
            'description' => 'Beautiful villa with sea view',
            'price' => 1100000,
            'address' => '123 Ocean Drive',
            'type' => 'villa',
            'status' => 'available',
        ])->assertStatus(200);
        $this->assertDatabaseHas('properties', ['title' => 'Updated Villa']);

        // Delete
        $this->deleteJson("/api/properties/{$propertyId}")->assertStatus(204);
        $this->assertDatabaseMissing('properties', ['id' => $propertyId]);
    }
}
