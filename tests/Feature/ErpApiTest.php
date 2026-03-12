<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ErpApiTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'role' => 'admin',
        ]);
    }

    public function test_can_login()
    {
        $response = $this->postJson('/api/login', [
            'email' => $this->user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['user', 'token']);
    }

    public function test_can_get_me()
    {
        $response = $this->actingAs($this->user, 'sanctum')->getJson('/api/me');

        $response->assertStatus(200)
                 ->assertJson(['email' => $this->user->email]);
    }

    public function test_can_list_customers()
    {
        Customer::factory(5)->create();

        $response = $this->actingAs($this->user, 'sanctum')->getJson('/api/customers');

        $response->assertStatus(200)
                 ->assertJsonCount(5, 'data');
    }

    public function test_can_create_product()
    {
        $data = [
            'name' => 'New Product',
            'sku' => 'PROD-001',
            'price' => 100,
            'stock' => 10,
            'description' => 'Test description',
        ];

        $response = $this->actingAs($this->user, 'sanctum')->postJson('/api/products', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['sku' => 'PROD-001']);

        $this->assertDatabaseHas('products', ['sku' => 'PROD-001']);
    }

    public function test_can_create_order()
    {
        $customer = Customer::factory()->create();
        $product = Product::factory()->create(['price' => 50, 'stock' => 20]);

        $data = [
            'customer_id' => $customer->id,
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 2,
                ],
            ],
        ];

        $response = $this->actingAs($this->user, 'sanctum')->postJson('/api/orders', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['total' => 100]);

        $this->assertDatabaseHas('orders', ['customer_id' => $customer->id, 'total' => 100]);
        $this->assertDatabaseHas('invoices', ['total' => 100]);
        $this->assertEquals(18, $product->fresh()->stock);
    }
}
