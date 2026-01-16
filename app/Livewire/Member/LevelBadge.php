<?php

namespace App\Livewire\Member;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class LevelBadge extends Component
{
    public $level;
    public $xp;
    public $xpPercentage;
    public $nextLevelXp;

    protected $listeners = ['xp-updated' => '$refresh', 'points-updated' => '$refresh'];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $user = Auth::user();
        if (!$user) return;

        $this->level = $user->level;
        $this->xp = $user->xp;
        $this->nextLevelXp = $this->level * 1000;
        $this->xpPercentage = min(100, ($this->xp / $this->nextLevelXp) * 100);
    }

    public function render()
    {
        $this->loadData();
        return view('livewire.member.level-badge');
    }
}
