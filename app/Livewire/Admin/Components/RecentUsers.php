<?php

namespace App\Livewire\Admin\Components;

use Livewire\Component;

use App\Models\User;

class RecentUsers extends Component
{
    public function render()
    {
        $recentUsers = User::where('is_admin', false)
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.admin.components.recent-users', [
            'recentUsers' => $recentUsers
        ]);
    }
}
