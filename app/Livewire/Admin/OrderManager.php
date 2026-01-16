<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;

use Livewire\Attributes\On;

class OrderManager extends Component
{
    use WithPagination, \App\Traits\LogActivity;

    public $statusFilter = '';
    public $searchTerm = '';
    public $dateFrom = '';
    public $dateTo = '';
    public $selectedOrder = null;

    #[On('updateStatus')]
    public function updateStatus($orderId, $newStatus)
    {
        try {
            $order = \App\Models\Order::findOrFail($orderId);
            $order->update(['status' => $newStatus]);

            // Notify User
            if ($order->user) {
                $order->user->notify(new \App\Notifications\OrderStatusNotification($order));
            }
            
            $this->logAction('update_order_status', "Admin updated order #{$order->order_number} to {$newStatus}", [
                'order_id' => $orderId,
                'status' => $newStatus,
                'order_number' => $order->order_number
            ]);

            $this->dispatch('show-notification', message: 'Order status updated successfully!', type: 'success');
            // Refresh the order list
            $this->statusFilter = $this->statusFilter; 
        } catch (\Exception $e) {
            $this->dispatch('show-notification', message: 'Error: ' . $e->getMessage(), type: 'error');
        }
    }

    public function promptUpdateStatus($orderId, $status)
    {
        $this->dispatch('confirm-order-action', [
            'id' => $orderId,
            'status' => $status,
            'title' => $status === 'processing' ? 'Confirm Processing?' : 'Complete Order?',
            'text' => $status === 'processing' 
                ? 'Are you sure you want to mark this order as processing?' 
                : 'Have you verified that the top-up is successful?',
            'icon' => $status === 'processing' ? 'question' : 'warning',
            'confirmText' => $status === 'processing' ? 'Yes, Process it!' : 'Yes, Complete Order!',
        ]);
    }

    public function viewDetails($orderId)
    {
        try {
            $this->selectedOrder = \App\Models\Order::with(['game', 'items.product', 'payment', 'user'])
                ->findOrFail($orderId);
        } catch (\Exception $e) {
            $this->dispatch('show-notification', message: 'Error loading order: ' . $e->getMessage(), type: 'error');
        }
    }

    public function closeModal()
    {
        $this->selectedOrder = null;
    }

    public function exportCSV()
    {
        $query = \App\Models\Order::with(['game', 'user', 'payment'])
            ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
            ->when($this->searchTerm, fn($q) => $q->where('order_number', 'like', '%' . $this->searchTerm . '%'))
            ->when($this->dateFrom, fn($q) => $q->whereDate('created_at', '>=', $this->dateFrom))
            ->when($this->dateTo, fn($q) => $q->whereDate('created_at', '<=', $this->dateTo))
            ->latest();

        $orders = $query->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=orders_export_" . date('Y-m-d_H-i-s') . ".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Order Number', 'Date', 'User', 'Game', 'Account ID', 'Total', 'Payment Method', 'Status']);

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->order_number,
                    $order->created_at->format('Y-m-d H:i:s'),
                    $order->user ? $order->user->name : ($order->game_account_name ?: 'Guest'),
                    $order->game ? $order->game->name : 'N/A',
                    "'" . $order->game_account_id, // Prefix with ' to prevent Excel from scientific notation
                    $order->total,
                    $order->payment_method ?: ($order->payment ? $order->payment->payment_method : 'N/A'),
                    $order->status
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function render()
    {
        $orders = \App\Models\Order::with(['game', 'user', 'payment'])
            ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
            ->when($this->searchTerm, fn($q) => $q->where('order_number', 'like', '%' . $this->searchTerm . '%'))
            ->when($this->dateFrom, fn($q) => $q->whereDate('created_at', '>=', $this->dateFrom))
            ->when($this->dateTo, fn($q) => $q->whereDate('created_at', '<=', $this->dateTo))
            ->latest()
            ->paginate(15);

        return view('livewire.admin.order-manager', [
            'orders' => $orders,
        ]);
    }
}
