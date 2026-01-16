<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Collection;

class ActivityFeed extends Component
{
    public $activities = [];

    public function mount()
    {
        $this->refreshActivities();
    }

    public function refreshActivities()
    {
        $activities = new Collection();

        // Recent successful orders
        $orders = Order::where('status', 'completed')
            ->with(['user', 'items.product.game'])
            ->latest()
            ->take(5)
            ->get();

        foreach ($orders as $order) {
            $gameName = $order->items->first()->product->game->name ?? 'Game';
            $activities->push([
                'type' => 'order',
                'user' => $this->maskName($order->user->name ?? 'Guest'),
                'message' => "baru saja top-up <span class='text-brand-yellow font-bold'>$gameName</span>",
                'time' => $order->updated_at,
                'icon' => 'shopping-cart'
            ]);
        }

        // Recent level ups (we'll look at the latest users whose level > 1)
        $levelUps = User::where('level', '>', 0)
            ->where('updated_at', '>', now()->subDays(7))
            ->latest()
            ->take(5)
            ->get();

        foreach ($levelUps as $user) {
            $activities->push([
                'type' => 'level_up',
                'user' => $this->maskName($user->name),
                'message' => "naik ke <span class='text-indigo-400 font-bold italic underline decoration-indigo-400/30'>Level {$user->level}</span>!",
                'time' => $user->updated_at,
                'icon' => 'trending-up'
            ]);
        }

        $this->activities = $activities->sortByDesc('time')->take(6)->values()->toArray();
    }

    private function maskName($name)
    {
        $length = strlen($name);
        if ($length <= 2) return $name;
        return substr($name, 0, 2) . str_repeat('*', min(3, $length - 2));
    }

    public function render()
    {
        return view('livewire.activity-feed');
    }
}
