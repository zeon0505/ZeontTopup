<?php

namespace App\Livewire\Features;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Leaderboard extends Component
{
    public function render()
    {
        $topSultans = \App\Models\User::whereHas('orders', function($q) {
                $q->where('status', 'completed');
            })
            ->withSum(['orders' => function($q) {
                $q->where('status', 'completed');
            }], 'total')
            ->orderByDesc('orders_sum_total')
            ->take(10)
            ->get();

        $topReferrers = \App\Models\User::has('referrals')
            ->withCount('referrals')
            ->orderByDesc('referrals_count')
            ->take(10)
            ->get();

        return view('livewire.features.leaderboard', compact('topSultans', 'topReferrers'));
    }
}
