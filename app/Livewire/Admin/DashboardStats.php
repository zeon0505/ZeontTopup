<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class DashboardStats extends Component
{
    public $totalOrders = 0;
    public $totalRevenue = 0;
    public $todayOrders = 0;
    public $todayRevenue = 0;
    public $pendingOrders = 0;
    public $salesData = [];

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $this->totalOrders = \App\Models\Order::count();
        $this->totalRevenue = \App\Models\Order::where('status', 'completed')->sum('total');
        
        $this->todayOrders = \App\Models\Order::whereDate('created_at', today())->count();
        $this->todayRevenue = \App\Models\Order::whereDate('created_at', today())
            ->where('status', 'completed')
            ->sum('total');
        
        $this->pendingOrders = \App\Models\Order::where('status', 'pending')->count();

        // Last 7 days sales trend
        $this->salesData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $label = now()->subDays($i)->format('d M');
            $revenue = \App\Models\Order::whereDate('created_at', $date)
                ->where('status', 'completed')
                ->sum('total');
            
            $this->salesData[] = [
                'label' => $label,
                'revenue' => (float)$revenue
            ];
        }
    }

    public function render()
    {
        return view('livewire.admin.dashboard-stats');
    }
}
