<?php

namespace App\Livewire\Member;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class TransactionHistory extends Component
{
    use WithPagination;

    public $statusFilter = 'all';

    public function setStatusFilter($status)
    {
        $this->statusFilter = $status;
        $this->resetPage();
    }

    public function render()
    {
        $query = Order::where('user_id', Auth::id())
            ->with(['game', 'items']);

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        $orders = $query->latest()->paginate(10);

        return view('livewire.member.transaction-history', [
            'orders' => $orders
        ]);
    }
}
