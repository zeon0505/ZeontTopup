<?php

namespace App\Livewire;

use Livewire\Component;

class CartSummary extends Component
{
    public $gameId;
    public $product = null;
    public $paymentMethod = null;
    public $accountData = null;
    public $adminFee = 0;
    public $total = 0;
    
    // Voucher Properties
    public $voucherCode = '';
    public $discountAmount = 0;
    public $appliedVoucher = null;
    
    // Loyalty Points
    public $usePoints = false;
    public $pointsDiscount = 0;
    public $userPoints = 0;

    // Auto Top-Up
    public $isScheduled = false;
    public $frequency = 'monthly'; // weekly, monthly

    protected $listeners = [
        'product-selected' => 'setProduct',
        'payment-method-selected' => 'setPaymentMethod',
        'account-validated' => 'setAccountData',
    ];

    public function mount($gameId)
    {
        $this->gameId = $gameId;
    }

    public function applyVoucher()
    {
        $this->resetErrorBag('voucherCode');
        
        if (empty($this->voucherCode)) {
            $this->addError('voucherCode', 'Please enter a voucher code.');
            return;
        }

        $voucher = \App\Models\Voucher::where('code', strtoupper($this->voucherCode))->first();

        // Check if voucher exists and is valid
        // Also check if product is selected to validate min_purchase against product price
        $purchaseAmount = $this->product ? $this->product['price'] : 0;
        
        if (!$voucher || !$voucher->isValid($purchaseAmount)) {
            $this->addError('voucherCode', 'Invalid or expired voucher code.');
            return;
        }

        $this->appliedVoucher = $voucher;
        $this->calculateTotal();
        
        $this->dispatch('show-notification', message: 'Voucher Applied Successfully!', type: 'success');
    }

    public function removeVoucher()
    {
        $this->voucherCode = '';
        $this->appliedVoucher = null;
        $this->discountAmount = 0;
        $this->calculateTotal();
    }

    public function setAccountData($data)
    {
        $this->accountData = $data;
    }

    public function setProduct($product)
    {
        $this->product = $product;
        // Re-validate voucher if product changes (price might change)
        if ($this->appliedVoucher) {
             if (!$this->appliedVoucher->isValid($product['price'])) {
                 $this->removeVoucher();
                 $this->dispatch('show-notification', message: 'Voucher removed (min purchase requirement)', type: 'warning');
             }
        }
        $this->calculateTotal();
    }

    public function setPaymentMethod($method)
    {
        $this->paymentMethod = $method;
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        if ($this->product) {
            $subtotal = $this->product['price'];
            
            // Calculate Discount
            $this->discountAmount = 0;
            if ($this->appliedVoucher) {
                $this->discountAmount = $this->appliedVoucher->calculateDiscount($subtotal);
            }

            // Calculate Points Discount
            $this->pointsDiscount = 0;
            if ($this->usePoints && \Illuminate\Support\Facades\Auth::check()) {
                $user = \Illuminate\Support\Facades\Auth::user();
                $this->userPoints = $user->points;
                
                // Max points to use is the remaining total
                $remainingTotal = max(0, $subtotal + $this->adminFee - $this->discountAmount);
                $this->pointsDiscount = min($this->userPoints, $remainingTotal);
            }

            // Final Total
            $this->total = max(0, $subtotal + $this->adminFee - $this->discountAmount - $this->pointsDiscount);
        }
    }

    public function togglePoints()
    {
        $this->usePoints = !$this->usePoints;
        $this->calculateTotal();
    }

    public function canCheckout()
    {
        return $this->product 
            && $this->paymentMethod 
            && $this->accountData 
            && isset($this->accountData['is_valid']) 
            && $this->accountData['is_valid'] === true;
    }

    public function checkout()
    {
        // DEBUG: Confirm button click reaches backend
        $this->js("console.log('Backend Reached');");

        \Illuminate\Support\Facades\Log::info('Checkout method called', [
            'canCheckout' => $this->canCheckout(),
            'product' => $this->product,
            'paymentMethod' => $this->paymentMethod,
            'accountData' => $this->accountData
        ]);

        if (!$this->canCheckout()) {
            \Illuminate\Support\Facades\Log::warning('Checkout blocked: canCheckout returned false');
            $this->js("alert('Mohon lengkapi data: Akun, Produk, dan Metode Pembayaran harus dipilih.');");
            $this->dispatch('show-notification', message: 'Mohon lengkapi semua data pemesanan', type: 'error');
            return;
        }

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            $orderNumber = 'ORD-' . strtoupper(\Illuminate\Support\Str::random(10));
            
            // Re-fetch product to ensure price is correct
            $productModel = \App\Models\Product::with('activeFlashSale')->find($this->product['id']);
            
            if (!$productModel) {
                throw new \Exception('Product not found');
            }
            
            $subtotal = $productModel->price;
            
             // Re-calculate Discount
            $discountAmount = 0;
            if ($this->appliedVoucher) {
                // Determine active flash sale price or original?
                // Product model `price` accessor returns flash sale price if active.
                // So subtotal is already correct (discounted or original).
                // Voucher applies on top of that.
                
                // Re-validate just in case time passed
                if($this->appliedVoucher->isValid($subtotal)){
                     $discountAmount = $this->appliedVoucher->calculateDiscount($subtotal);
                }
            }
            
            $adminFee = $subtotal * 0.01;
            
            // Points re-calc
            $pointsDiscount = 0;
            if ($this->usePoints && \Illuminate\Support\Facades\Auth::check()) {
                $user = \Illuminate\Support\Facades\Auth::user();
                $pointsDiscount = min($user->points, max(0, $subtotal + $adminFee - $discountAmount));
            }

            $total = max(0, $subtotal + $adminFee - $discountAmount - $pointsDiscount);
            
            // Sync with local state
            $this->discountAmount = $discountAmount;
            $this->pointsDiscount = $pointsDiscount;
            $this->total = $total;

            \Illuminate\Support\Facades\Log::info('Creating order', [
                'orderNumber' => $orderNumber,
                'productId' => $productModel->id,
                'total' => $total
            ]);

            $order = \App\Models\Order::create([
                'order_number' => $orderNumber,
                'user_id' => \Illuminate\Support\Facades\Auth::id(),
                'game_id' => $this->gameId,
                'game_account_id' => $this->accountData['id'],
                'game_account_name' => $this->accountData['name'] ?? null,
                'subtotal' => $subtotal,
                'admin_fee' => $adminFee,
                'discount' => $this->discountAmount + $this->pointsDiscount, // Combine discount
                'total' => $total,
                'status' => 'pending',
                'payment_method' => $this->paymentMethod['id'],
            ]);

            // DEDUCT POINTS IF USED
            if ($this->pointsDiscount > 0) {
                $user = \Illuminate\Support\Facades\Auth::user();
                $user->decrement('points', $this->pointsDiscount);
                
                \App\Models\LoyaltyPoint::create([
                    'user_id' => $user->id,
                    'order_id' => $order->id,
                    'points' => -$this->pointsDiscount,
                    'description' => 'Used points for order ' . $order->order_number,
                ]);
            }

            // Increment Voucher Usage
            if ($this->appliedVoucher) {
                $this->appliedVoucher->increment('used_count');
                $order->update(['notes' => 'Voucher: ' . $this->appliedVoucher->code]);
            }

            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productModel->id,
                'product_name' => $productModel->name,
                'quantity' => 1,
                'price' => $productModel->price,
                'subtotal' => $productModel->price,
            ]);

            // HANDLE SALDO PAYMENT METHOD
            if (isset($this->paymentMethod['code']) && strtoupper($this->paymentMethod['code']) === 'SALDO') {
                $user = \Illuminate\Support\Facades\Auth::user();
                
                if ($user->balance < $total) {
                     throw new \Exception('Saldo tidak mencukupi. Silakan top up terlebih dahulu.');
                }

                \Illuminate\Support\Facades\DB::transaction(function() use ($order, $user, $total) {
                    $user->decrement('balance', $total);
                    $order->update([
                        'status' => 'processing',
                        'payment_method' => 'SALDO' // Store text code for reference
                    ]);
                    
                    // HANDLE AUTO TOP-UP (SCHEDULED ORDER)
                    if ($this->isScheduled) {
                        \App\Models\ScheduledOrder::create([
                            'user_id' => $user->id,
                            'product_id' => $this->product['id'],
                            'game_account_id' => $this->accountData['id'],
                            'frequency' => $this->frequency,
                            'last_run_at' => now(),
                            'next_run_at' => $this->frequency === 'weekly' ? now()->addWeek() : now()->addMonth(),
                            'is_active' => true,
                        ]);
                    }
                });

                // Immediately redirect/success for Saldo
                 \Illuminate\Support\Facades\DB::commit(); // Commit user balance change
                 
                 $this->dispatch('show-notification', message: 'Pembayaran Berhasil!' . ($this->isScheduled ? ' & Jadwal Otomatis Dibuat.' : ''), type: 'success');
                 $this->redirect(route('order.status', $order->order_number), navigate: true);
                 return;
            }

            // HANDLE MIDTRANS (Existing Logic)
            \Illuminate\Support\Facades\Log::info('Generating snap token');

            $paymentService = app(\App\Services\PaymentService::class);
            // Fix: Use 'code' (e.g. "gopay") instead of 'id' (database ID) for enabled_payments
            $paymentCode = strtolower($this->paymentMethod['code']);
            $snapToken = $paymentService->createSnapToken($order, $paymentCode);

            // Save payment method name/code to order for reference
            $order->update(['payment_method' => $this->paymentMethod['name']]);

            \Illuminate\Support\Facades\DB::commit();

            \Illuminate\Support\Facades\Log::info('Order created successfully', [
                'orderNumber' => $orderNumber,
                'snapToken' => $snapToken
            ]);

            // Dispatch browser event
            $this->dispatch('payment-initiated', snap_token: $snapToken, order_number: $orderNumber);
            
            // Also try window event as fallback
            $this->js("window.dispatchEvent(new CustomEvent('payment-initiated', { detail: { snap_token: '{$snapToken}', order_number: '{$orderNumber}' } }))");

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Checkout error: ' . $e->getMessage());
            
            // ERROR DEBUGGING: Force a browser alert to ensure the user sees the error
            $message = 'Error: ' . str_replace("'", "", $e->getMessage()); // Sanitize for JS
            $this->js("alert('$message');");
            
            // Standard notification
            $this->dispatch('show-notification', message: 'Error: ' . $e->getMessage(), type: 'error');
        }
    }

    public function render()
    {
        return view('livewire.cart-summary');
    }
}
