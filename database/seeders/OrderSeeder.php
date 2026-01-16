<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;
use App\Models\PaymentMethod;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('is_admin', false)->get();
        $products = Product::with('game')->get();
        $paymentMethods = PaymentMethod::all();

        if ($users->isEmpty() || $products->isEmpty() || $paymentMethods->isEmpty()) {
            return;
        }

        // Create 20 completed orders
        for ($i = 0; $i < 20; $i++) {
            $user = $users->random();
            $product = $products->random();
            $paymentMethod = $paymentMethods->random();

            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'game_account_id' => rand(100000000, 999999999),
                'game_account_name' => $user->name,
                'subtotal' => $product->price,
                'discount' => 0,
                'admin_fee' => $paymentMethod->fee,
                'total' => $product->price + $paymentMethod->fee,
                'status' => 'completed',
                'payment_method' => $paymentMethod->name,
                'created_at' => now()->subDays(rand(0, 30)),
                'updated_at' => now()->subDays(rand(0, 30)),
            ]);

            // Create order item
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'quantity' => 1,
                'price' => $product->price,
                'subtotal' => $product->price,
            ]);
        }

        // Create 10 pending orders
        for ($i = 0; $i < 10; $i++) {
            $user = $users->random();
            $product = $products->random();
            $paymentMethod = $paymentMethods->random();

            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'game_account_id' => rand(100000000, 999999999),
                'game_account_name' => $user->name,
                'subtotal' => $product->price,
                'discount' => 0,
                'admin_fee' => $paymentMethod->fee,
                'total' => $product->price + $paymentMethod->fee,
                'status' => 'pending',
                'payment_method' => $paymentMethod->name,
                'created_at' => now()->subHours(rand(1, 48)),
                'updated_at' => now()->subHours(rand(1, 48)),
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'quantity' => 1,
                'price' => $product->price,
                'subtotal' => $product->price,
            ]);
        }
    }
}
