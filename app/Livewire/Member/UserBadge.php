<?php

namespace App\Livewire\Member;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UserBadge extends Component
{
    public $achievements;

    public function mount()
    {
        $this->loadAchievements();
    }

    public function loadAchievements()
    {
        $this->achievements = Auth::user()->achievements()
            ->orderBy('achieved_at', 'desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.member.user-badge');
    }
}
