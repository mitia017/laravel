<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Invoice;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Staff User
        User::create([
            'name' => 'Staff User',
            'email' => 'staff@example.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);

        // Customers
        $customers = Customer::factory(20)->create();

        // Products
        $products = Product::factory(50)->create();

        // Orders, Items, and Invoices
        $customers->each(function ($customer) use ($products) {
            $orderCount = rand(1, 3);
            for ($i = 0; $i < $orderCount; $i++) {
                $order = Order::create([
                    'customer_id' => $customer->id,
                    'total' => 0,
                    'status' => 'completed',
                ]);

                $total = 0;
                $itemCount = rand(1, 5);
                $selectedProducts = $products->random($itemCount);

                foreach ($selectedProducts as $product) {
                    $quantity = rand(1, 5);
                    $price = $product->price;
                    $subtotal = $price * $quantity;
                    $total += $subtotal;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $price,
                    ]);
                }

                $order->update(['total' => $total]);

                Invoice::create([
                    'order_id' => $order->id,
                    'invoice_number' => 'INV-' . strtoupper(Str::random(8)),
                    'total' => $total,
                    'status' => 'paid',
                ]);
            }
        });
    }
}
