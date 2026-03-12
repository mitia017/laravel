<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{
    public function getAllOrders()
    {
        return Order::with(['customer', 'items.product'])->paginate(10);
    }

    public function createOrder(array $data)
    {
        return DB::transaction(function () use ($data) {
            $order = Order::create([
                'customer_id' => $data['customer_id'],
                'total' => 0,
                'status' => 'pending',
            ]);

            $total = 0;
            foreach ($data['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);

                // Check stock
                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Insufficient stock for product: {$product->name}");
                }

                $price = $product->price;
                $subtotal = $price * $item['quantity'];
                $total += $subtotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $price,
                ]);

                // Update stock
                $product->decrement('stock', $item['quantity']);
            }

            $order->update(['total' => $total]);

            // Automatically create invoice
            Invoice::create([
                'order_id' => $order->id,
                'invoice_number' => 'INV-' . strtoupper(Str::random(8)),
                'total' => $total,
                'status' => 'unpaid',
            ]);

            return $order->load(['customer', 'items.product', 'invoice']);
        });
    }

    public function getOrderById($id)
    {
        return Order::with(['customer', 'items.product', 'invoice'])->findOrFail($id);
    }

    public function updateOrderStatus($id, $status)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => $status]);
        return $order;
    }

    public function deleteOrder($id)
    {
        $order = Order::findOrFail($id);
        return DB::transaction(function () use ($order) {
            // Restore stock
            foreach ($order->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }
            return $order->delete();
        });
    }
}
