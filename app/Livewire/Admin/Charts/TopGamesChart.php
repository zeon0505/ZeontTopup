<?php

namespace App\Livewire\Admin\Charts;

use Livewire\Component;

use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class TopGamesChart extends Component
{
    public $chartData = [];

    public function mount()
    {
        $this->loadChartData();
    }

    public function loadChartData()
    {
        // Aggregate total revenue per game based on OrderItems
        // We join order_items -> products -> games
        // Filter by completed orders
        
        $data = OrderItem::query()
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('games', 'products.game_id', '=', 'games.id')
            ->where('orders.status', 'completed') // Only completed
            ->select('games.name as game_name', DB::raw('SUM(order_items.subtotal) as total_revenue'))
            ->groupBy('games.id', 'games.name')
            ->orderByDesc('total_revenue')
            ->take(5) // Top 5
            ->get();

        $this->chartData = [
            'categories' => $data->pluck('game_name')->toArray(),
            'series' => $data->pluck('total_revenue')->toArray(),
        ];
    }

    public function render()
    {
        return view('livewire.admin.charts.top-games-chart');
    }
}
