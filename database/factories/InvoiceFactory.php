<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'invoice_number' => 'INV-' . strtoupper(Str::random(8)),
            'total' => $this->faker->randomFloat(2, 20, 2000),
            'status' => $this->faker->randomElement(['unpaid', 'paid', 'cancelled']),
        ];
    }
}
