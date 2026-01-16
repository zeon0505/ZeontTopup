<?php

namespace App\Livewire\Features;

use Livewire\Component;

use App\Models\MiniGameScore;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class FlappyGame extends \Livewire\Component
{
    public $leaderboard = [];
    public $userHighScore = 0;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->leaderboard = MiniGameScore::with('user')
            ->where('day', now()->toDateString())
            ->orderByDesc('score')
            ->take(10)
            ->get();

        if (auth()->check()) {
            $this->userHighScore = MiniGameScore::where('user_id', auth()->id())
                ->where('day', now()->toDateString())
                ->value('score') ?? 0;
        }
    }

    public function submitScore($score)
    {
        if (!auth()->check()) {
            return;
        }

        // Basic validation: Flappy bird scores don't usually jump by 1000s instantly
        // This is a naive check but better than nothing
        if ($score < 0 || $score > 1000) {
            return;
        }

        $today = now()->toDateString();
        
        $currentScore = MiniGameScore::where('user_id', auth()->id())
            ->where('day', $today)
            ->first();

        if (!$currentScore || $score > $currentScore->score) {
            MiniGameScore::updateOrCreate(
                ['user_id' => auth()->id(), 'day' => $today],
                ['score' => $score]
            );
        }

        $this->loadData();
        $this->dispatch('score-updated');
    }

    public function render()
    {
        return view('livewire.features.flappy-game');
    }
}
