<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ScheduledOrder;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProcessScheduledOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scheduled-orders:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process all due scheduled top-up orders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dueOrders = ScheduledOrder::where('is_active', true)
            ->where('next_run_at', '<=', now())
            ->with(['user', 'product.game'])
            ->get();

        if ($dueOrders->isEmpty()) {
            $this->info('No due scheduled orders found.');
            return;
        }

        $this->info('Processing ' . $dueOrders->count() . ' scheduled orders...');

        foreach ($dueOrders as $scheduled) {
            DB::beginTransaction();
            try {
                $user = $scheduled->user;
                $product = $scheduled->product;

                if (!$user || !$product) {
                    throw new \Exception("Invalid user or product for scheduled order.");
                }

                // Check balance
                if ($user->balance < $product->price) {
                    $this->warn("User {$user->id} has insufficient balance (Need Rp " . number_format($product->price) . ").");
                    // Deactivate after 3 fails? For now just skip
                    DB::rollBack();
                    continue;
                }

                // Deduct balance
                $user->decrement('balance', $product->price);

                // Create Order
                $order = Order::create([
                    'order_number' => 'AUTO-' . strtoupper(Str::random(10)),
                    'user_id' => $user->id,
                    'game_id' => $product->game_id,
                    'game_account_id' => $scheduled->game_account_id,
                    'subtotal' => $product->price,
                    'total' => $product->price,
                    'status' => 'processing',
                    'payment_method' => 'balance',
                    'notes' => 'Auto top-up (Scheduled)',
                ]);

                // Create Order Item
                $order->items()->create([
                    'id' => Str::uuid(),
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => 1,
                ]);

                // Update schedule
                $scheduled->last_run_at = now();
                $scheduled->next_run_at = $scheduled->frequency === 'weekly' 
                    ? now()->addWeek() 
                    : now()->addMonth();
                $scheduled->save();

                DB::commit();
                $this->info("Successfully processed order [{$order->order_number}] for {$user->email}");
                Log::info("Scheduled Order Processed: {$order->order_number}");

            } catch (\Exception $e) {
                DB::rollBack();
                $this->error("Failed to process scheduled order ID [{$scheduled->id}]: " . $e->getMessage());
                Log::error("Scheduled Order Error: " . $e->getMessage());
            }
        }
    }
}
