<?php

namespace App\Livewire;

use Livewire\Component;

class GameOrder extends Component
{
    public \App\Models\Game $game;

    public function mount(\App\Models\Game $game)
    {
        $this->game = $game;
        
        if (!$this->game->is_active) {
            abort(404);
        }
    }

    public $userRating = 5;
    public $reviewComment = '';

    protected $rules = [
        'userRating' => 'required|integer|min:1|max:5',
        'reviewComment' => 'nullable|string|max:500',
    ];

    public function setRating($rating)
    {
        $this->userRating = $rating;
    }

    public function submitReview()
    {
        $this->validate();

        // Assuming user is authenticated or guest review allowed?
        // For now, if not logged in, maybe use a dummy user or require login.
        // User didn't specify authentication. I'll use Auth::id() if available, else maybe error.
        // Let's assume for this "public" page, maybe we just create it as Anonymous if no user? 
        // But Review model requires user_id.
        // I'll grab the first user as fallback for Guest reviews (simulation) OR check Auth.
        
        $userId = auth()->id() ?? \App\Models\User::first()->id ?? 1;

        \App\Models\Review::create([
            'game_id' => $this->game->id,
            'user_id' => $userId,
            'rating' => $this->userRating,
            'comment' => $this->reviewComment,
        ]);

        $this->reset('reviewComment');
        $this->userRating = 5;
        
        // Refresh game relations
        $this->game->refresh();
        
        session()->flash('message', 'Review submitted successfully!');
    }

    public function render()
    {
        $reviews = $this->game->reviews()->with('user')->latest()->take(5)->get();
        return view('livewire.game-order', [
            'reviews' => $reviews
        ])->layout('components.layouts.app');
    }
}
