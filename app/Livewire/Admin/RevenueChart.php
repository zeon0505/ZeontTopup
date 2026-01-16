<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class RevenueChart extends Component
{
    public $chartData = [];

    public function mount()
    {
        $this->loadChartData();
    }

    public function loadChartData()
    {
        // Get last 7 days dates
        $dates = collect();
        for ($i = 6; $i >= 0; $i--) {
            $dates->push(now()->subDays($i)->format('Y-m-d'));
        }

        // Fetch revenue grouped by date
        $revenue = \App\Models\Order::where('status', 'completed')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->selectRaw('DATE(created_at) as date, SUM(total) as total')
            ->groupBy('date')
            ->get()
            ->pluck('total', 'date');

        // Map data to ensure all dates exist (fill zero)
        $data = $dates->map(function ($date) use ($revenue) {
            return $revenue->get($date, 0);
        });

        $this->chartData = [
            'categories' => $dates->map(fn($d) => \Carbon\Carbon::parse($d)->format('d M'))->toArray(),
            'series' => $data->toArray(),
        ];
    }

    public function render()
    {
        return view('livewire.admin.revenue-chart');
    }
}
