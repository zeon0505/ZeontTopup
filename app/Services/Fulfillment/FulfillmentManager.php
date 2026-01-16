<?php

namespace App\Services\Fulfillment;

use App\Models\Order;
use Illuminate\Support\Facades\Log;

class FulfillmentManager
{
    protected $provider;

    public function __construct(ProviderServiceInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Process order fulfillment
     */
    public function processOrder(Order $order)
    {
        // Don't process if already completed or processing by provider
        if (in_array($order->status, ['completed', 'failed'])) {
            return;
        }

        Log::info("Starting fulfillment for Order #{$order->order_number}");

        $result = $this->provider->processOrder($order);

        if ($result['success']) {
            if ($result['status'] === 'Success') {
                $order->update([
                    'status' => 'completed',
                    'notes' => ($order->notes ? $order->notes . "\n" : "") . "Provider: {$result['message']} SN: {$result['sn']}"
                ]);
                
                // Notify user
                if ($order->user) {
                    $order->user->notify(new \App\Notifications\PlatformNotification(
                        "Top Up Berhasil! ✅",
                        "Pesanan #{$order->order_number} telah sukses dikirim ke ID {$order->game_account_id}.",
                        "order"
                    ));
                }
            } elseif ($result['status'] === 'Gagal') {
                $order->update(['status' => 'failed', 'notes' => 'Provider error: ' . $result['message']]);
            } else {
                // Pending status from provider
                $order->update(['status' => 'processing', 'notes' => 'Awaiting provider confirmation...']);
            }
        } else {
            // API Connection error or other failure
            Log::error("Fulfillment failed for Order #{$order->order_number}: " . $result['message']);
            // We keep it as 'processing' so it can be retried or checked manually
        }
    }
}
