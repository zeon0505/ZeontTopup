<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Create a new order
     */
    public function store(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'product_id' => 'required|exists:products,id',
            'account_id' => 'required|string',
            'account_name' => 'nullable|string',
            'payment_method' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            // Generate unique order number
            $orderNumber = 'ORD-' . strtoupper(Str::random(10));

            // Get product
            $product = \App\Models\Product::findOrFail($request->product_id);

            // Calculate totals
            $subtotal = $product->price;
            $adminFee = $subtotal * 0.01;   
            $total = $subtotal + $adminFee;

            // Create order
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => Auth::id(),
                'game_id' => $request->game_id,
                'game_account_id' => $request->account_id,
                'game_account_name' => $request->account_name,
                'subtotal' => $subtotal,
                'admin_fee' => $adminFee,
                'total' => $total,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
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

            // Generate Snap token
            $snapToken = $this->paymentService->createSnapToken($order);

            DB::commit();

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_number' => $orderNumber,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Handle Midtrans payment notification
     */
    public function notification(Request $request)
    {
        $result = $this->paymentService->handleNotification();

        if ($result['success']) {
            return response()->json(['message' => 'Notification handled successfully']);
        }

        return response()->json(['message' => $result['message']], 500);
    }

    /**
     * Show order status page
     */
    public function status($orderNumber)
    {
        $order = Order::with(['game', 'items.product', 'payment'])
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        // Authorization check
        $user = Auth::user();
        $isAdmin = $user && $user->is_admin;
        $isOwner = $user && $user->id === $order->user_id;
        $isGuestOrder = $order->user_id === null;

        // Allow access if:
        // 1. It's a guest order (publicly accessible via unique order number)
        // 2. The user is the owner
        // 3. The user is an admin
        if (!$isGuestOrder && !$isOwner && !$isAdmin) {
            abort(403);
        }

        return view('order.status', compact('order'));
    }

    /**
     * Manually check payment status from Midtrans
     */
    public function checkPaymentStatus($orderNumber)
    {
        // ... existing code ...
    }

    /**
     * Simulate successful payment (For Development/Testing only)
     */
    public function simulatePayment($orderNumber)
    {
        try {
            $order = Order::where('order_number', $orderNumber)->firstOrFail();
            
            // Force update status to processing (Paid)
            $order->update(['status' => 'processing']);
            
            // Create dummy payment record
            $order->payment()->updateOrCreate(
                ['order_id' => $order->id],
                [
                    'payment_method' => $order->payment_method ?? 'simulation',
                    'transaction_id' => 'SIM-' . time(),
                    'transaction_status' => 'settlement',
                    'amount' => $order->total,
                    'payment_data' => json_encode(['type' => 'simulation', 'note' => 'Manually approved via simulation']),
                ]
            );

            // Process referral commission for testing
            $this->paymentService->processReferralCommission($order);
            
            return response()->json([
                'success' => true,
                'message' => 'Simulasi pembayaran berhasil! Status order diperbarui.',
                'new_status' => 'processing'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
