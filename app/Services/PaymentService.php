<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use App\Models\Order;
use Illuminate\Support\Str;

class PaymentService
{
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');

        if (empty(Config::$serverKey)) {
            throw new \Exception('Midtrans Server Key is not configured in .env file.');
        }
    }

    /**
     * Create Snap token for payment
     */
    public function createSnapToken(Order $order, $paymentMethod = null)
    {
        // Build customer details - handle both logged in and guest users
        $customerDetails = [
            'first_name' => $order->user ? $order->user->name : 'Guest',
            'email' => $order->user ? $order->user->email : 'guest@topupgame.com',
        ];

        // If guest order, we could optionally use game account name
        if (!$order->user && $order->game_account_name) {
            $customerDetails['first_name'] = $order->game_account_name;
        }

        $params = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => (int) $order->total,
            ],
            'customer_details' => $customerDetails,
            'item_details' => $this->getItemDetails($order),
            'callbacks' => [
                'finish' => route('order.status', $order->order_number),
            ],
        ];

        // If specific payment method is selected, enable only that method
        if ($paymentMethod) {
            // Map internal codes to Midtrans codes
            $midtransCode = strtolower($paymentMethod);
            
            // Mapping specific cases if necessary
            $mappings = [
                'bca_va' => 'bca_va',
                'bri_va' => 'bri_va',
                'mandiri_va' => 'echannel', // Mandiri is 'echannel' in Midtrans
                'bni_va' => 'bni_va',
                'permata_va' => 'permata_va',
                'cimb_va' => 'cimb_va',
                'alfamart' => 'cstore', // Alfamart/Indomaret are usually 'cstore' or specific
                'indomaret' => 'cstore',
                'qris' => 'gopay', // QRIS is often handled via GoPay/ShopeePay/Other in Sandbox
            ];

            if (isset($mappings[$midtransCode])) {
                $midtransCode = $mappings[$midtransCode];
            }

            $params['enabled_payments'] = [$midtransCode];
        }

        try {
            $snapToken = Snap::getSnapToken($params);
            return $snapToken;
        } catch (\Exception $e) {
            throw new \Exception('Error creating payment: ' . $e->getMessage());
        }
    }

    /**
     * Get item details for transaction
     */
    protected function getItemDetails(Order $order)
    {
        $items = [];
        
        foreach ($order->items as $item) {
            $items[] = [
                'id' => $item->product_id,
                'price' => (int) $item->price,
                'quantity' => $item->quantity,
                'name' => $item->product_name,
            ];
        }

        // Add admin fee if exists
        if ($order->admin_fee > 0) {
            $items[] = [
                'id' => 'ADMIN_FEE',
                'price' => (int) $order->admin_fee,
                'quantity' => 1,
                'name' => 'Admin Fee',
            ];
        }

        return $items;
    }

    /**
     * Handle payment notification from Midtrans
     */
    public function createDepositSnapToken(\App\Models\Deposit $deposit, $paymentMethod = null)
    {
        $customerDetails = [
            'first_name' => $deposit->user->name,
            'email' => $deposit->user->email,
        ];

        $params = [
            'transaction_details' => [
                'order_id' => $deposit->deposit_number,
                'gross_amount' => (int) $deposit->amount,
            ],
            'customer_details' => $customerDetails,
            'item_details' => [[
                'id' => 'DEPOSIT',
                'price' => (int) $deposit->amount,
                'quantity' => 1,
                'name' => 'Top Up Saldo',
            ]],
            'callbacks' => [
                // We'll redirect to transaction history or a specific deposit status page
                'finish' => route('dashboard'), 
            ],
        ];

        if ($paymentMethod) {
            $midtransCode = strtolower($paymentMethod);
             // Reuse mapping logic if needed or extract it
             // For brevity, assuming generic mapping or same as createSnapToken
             $mappings = [
                'bca_va' => 'bca_va',
                'bri_va' => 'bri_va',
                'mandiri_va' => 'echannel',
                'bni_va' => 'bni_va',
                'permata_va' => 'permata_va',
                'cimb_va' => 'cimb_va',
                'alfamart' => 'cstore',
                'indomaret' => 'cstore',
                'qris' => 'gopay',
            ];
            if (isset($mappings[$midtransCode])) {
                $midtransCode = $mappings[$midtransCode];
            }
            $params['enabled_payments'] = [$midtransCode];
        }

        try {
            return Snap::getSnapToken($params);
        } catch (\Exception $e) {
            throw new \Exception('Error creating deposit payment: ' . $e->getMessage());
        }
    }

    /**
     * Handle payment notification from Midtrans
     */
    public function handleNotification()
    {
        try {
            $notification = new Notification();
            
            $orderNumber = $notification->order_id; // Check prefix
            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status;

            if (Str::startsWith($orderNumber, 'DEP-')) {
                return $this->handleDepositNotification($notification, $orderNumber, $transactionStatus, $fraudStatus);
            }
            
            $order = Order::where('order_number', $orderNumber)->firstOrFail();
            
            // Update payment data
            $order->payment()->updateOrCreate(
                ['order_id' => $order->id],
                [
                    'payment_method' => $notification->payment_type,
                    'transaction_id' => $notification->transaction_id,
                    'transaction_status' => $transactionStatus,
                    'amount' => $notification->gross_amount,
                    'payment_data' => json_encode($notification->getResponse()),
                ]
            );
            
            // Update order status based on transaction status
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    $order->update(['status' => 'processing']);
                }
            } else if ($transactionStatus == 'settlement') {
                $order->update(['status' => 'processing']);
            } else if ($transactionStatus == 'pending') {
                $order->update(['status' => 'pending']);
            } else if (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                $order->update(['status' => 'failed']);
                if ($order->user) {
                    $order->user->notify(new \App\Notifications\PlatformNotification(
                        "Top Up Gagal ❌",
                        "Pesanan #{$order->order_number} gagal atau kadaluarsa.",
                        "order"
                    ));
                }
            }
            
            if (in_array($order->status, ['processing', 'completed'])) {
                $this->processReferralCommission($order);
                $this->processLoyaltyPoints($order);
                
                // Add XP (1 XP per 1000 IDR)
                if ($order->user) {
                    $order->user->addXp((int)floor($order->total / 1000));
                }

                // Check for achievements
                if ($order->user) {
                    $achievementService = new \App\Services\AchievementService();
                    $achievementService->checkAndAward($order->user, 'topup_count');
                    $achievementService->checkAndAward($order->user, 'spending_total');
                    $achievementService->checkAndAward($order->user, 'order_count');
                }
            }
            
            return ['success' => true, 'order' => $order];
            
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    protected function handleDepositNotification($notification, $depositNumber, $transactionStatus, $fraudStatus)
    {
        $deposit = \App\Models\Deposit::where('deposit_number', $depositNumber)->firstOrFail();
        
        // Don't process if already paid/failed to prevent double balance
        if (in_array($deposit->status, ['paid', 'failed'])) {
            return ['success' => true, 'message' => 'Deposit already processed'];
        }

        $deposit->update([
             'payment_method' => $notification->payment_type,
             'payment_data' => json_encode($notification->getResponse())
        ]);

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'accept') {
                $this->completeDeposit($deposit);
            }
        } else if ($transactionStatus == 'settlement') {
             $this->completeDeposit($deposit);
        } else if ($transactionStatus == 'pending') {
             $deposit->update(['status' => 'pending']);
        } else if (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
             $deposit->update(['status' => 'failed']);
        }

        return ['success' => true, 'deposit' => $deposit];
    }

    protected function completeDeposit($deposit)
    {
        if ($deposit->status !== 'paid') {
            \Illuminate\Support\Facades\DB::transaction(function () use ($deposit) {
                $deposit->update(['status' => 'paid']);
                $deposit->user->increment('balance', $deposit->amount);
                
                // Add XP for deposit (1 XP per 1000 IDR)
                $deposit->user->addXp((int)floor($deposit->amount / 1000));

                $deposit->user->notify(new \App\Notifications\PlatformNotification(
                    "Deposit Berhasil! 💰",
                    "Saldo sebesar Rp " . number_format($deposit->amount, 0, ',', '.') . " telah ditambahkan.",
                    "deposit"
                ));
            });
        }
    }

    /**
     * Process referral commission for an order
     */
    public function processReferralCommission(Order $order)
    {
        // Only process for authenticated users who were referred
        if (!$order->user_id || !$order->user || !$order->user->referred_by) {
            return;
        }

        // Check if referral record already exists for this order to prevent double commission
        $existingReferral = \App\Models\Referral::where('order_id', $order->id)->first();
        if ($existingReferral) {
            return;
        }

        $referrer = $order->user->referrer;
        if (!$referrer) {
            return;
        }

        // Calculate commission (default 2%)
        $commissionRate = 0.02;
        $commissionAmount = $order->subtotal * $commissionRate;

        if ($commissionAmount <= 0) {
            return;
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($order, $referrer, $commissionAmount) {
            // Create referral record
            \App\Models\Referral::create([
                'referrer_id' => $referrer->id,
                'referred_id' => $order->user_id,
                'order_id' => $order->id,
                'commission_amount' => $commissionAmount,
                'status' => 'completed',
            ]);

            // Add commission to referrer balance
            $referrer->increment('balance', $commissionAmount);

            if (in_array($order->status, ['processing', 'completed']) && $order->user) {
                $order->user->notify(new \App\Notifications\OrderStatusNotification($order));
            }
        });
    }

    /**
     * Process loyalty points for an order
     */
    public function processLoyaltyPoints(Order $order)
    {
        if (!$order->user_id || !$order->user) {
            return;
        }

        // Check if points already awarded to prevent double points
        $existingPoints = \App\Models\LoyaltyPoint::where('order_id', $order->id)
            ->where('points', '>', 0)
            ->first();
        if ($existingPoints) {
            return;
        }

        // Calculate points (1 point per 1000 IDR spent)
        $points = (int) floor($order->total / 1000);

        if ($points <= 0) {
            return;
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($order, $points) {
            // Create history record
            \App\Models\LoyaltyPoint::create([
                'user_id' => $order->user_id,
                'order_id' => $order->id,
                'points' => $points,
                'description' => 'Point reward for order ' . $order->order_number,
            ]);

            // Add points to user
            $order->user->increment('points', $points);
        });
    }

    /**
     * Check transaction status
     */
    public function checkStatus(string $orderNumber)
    {
        try {
            $status = \Midtrans\Transaction::status($orderNumber);
            return $status;
        } catch (\Exception $e) {
            throw new \Exception('Error checking payment status: ' . $e->getMessage());
        }
    }
}
