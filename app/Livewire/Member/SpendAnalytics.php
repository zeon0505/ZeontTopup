<?php

namespace App\Livewire\Member;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SpendAnalytics extends Component
{
    public function render()
    {
        $user = Auth::user();

        // Spend over last 6 months
        $monthlySpend = Order::where('user_id', $user->id)
            ->where('status', 'completed')
            ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->select(
                DB::raw('SUM(total) as total'),
                DB::raw("DATE_FORMAT(created_at, '%b %Y') as month"),
                DB::raw('MAX(created_at) as raw_date')
            )
            ->groupBy('month')
            ->orderBy('raw_date')
            ->get();

        // Spending by Game
        $gameSpend = Order::where('user_id', $user->id)
            ->where('status', 'completed')
            ->with('game')
            ->select('game_id', DB::raw('SUM(total) as total'))
            ->groupBy('game_id')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();

        $stats = [
            'total_spent' => Order::where('user_id', $user->id)->where('status', 'completed')->sum('total'),
            'this_month' => Order::where('user_id', $user->id)
                ->where('status', 'completed')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('total'),
            'orders_count' => Order::where('user_id', $user->id)->where('status', 'completed')->count(),
        ];

        return view('livewire.member.spend-analytics', [
            'monthlySpend' => $monthlySpend,
            'gameSpend' => $gameSpend,
            'stats' => $stats
        ]);
    }
}
