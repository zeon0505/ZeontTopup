<?php

namespace App\Livewire;

use App\Models\Game;
use App\Models\Review;
use Livewire\Component;
use Livewire\Attributes\On;

class GameReviews extends Component
{
    public $game;
    public $rating = 0;
    public $comment = '';
    public $sortBy = 'recent'; // recent, highest, lowest

    public $showReviewForm = false;
    public $editingReview = null;

    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|max:500',
    ];

    public function mount(Game $game)
    {
        $this->game = $game;
        
        // Check if user already has review
        if (auth()->check() && auth()->user()->hasReviewedGame($game->id)) {
            $existingReview = auth()->user()->reviews()->where('game_id', $game->id)->first();
            $this->editingReview = $existingReview;
            $this->rating = $existingReview->rating;
            $this->comment = $existingReview->comment;
        }
    }

    public function openReviewForm()
    {
        if (!auth()->check()) {
            $this->dispatch('show-notification', message: 'Please login to write a review', type: 'warning');
            return;
        }

        if (!auth()->user()->canReviewGame($this->game->id)) {
            $this->dispatch('show-notification', message: 'You must purchase this game to write a review', type: 'error');
            return;
        }

        $this->showReviewForm = true;
    }

    public function closeReviewForm()
    {
        $this->showReviewForm = false;
        $this->reset(['rating', 'comment']);
        
        if ($this->editingReview) {
            $this->rating = $this->editingReview->rating;
            $this->comment = $this->editingReview->comment;
        }
    }

    public function submitReview()
    {
        if (!auth()->check()) {
            $this->dispatch('show-notification', message: 'Please login to write a review', type: 'warning');
            return;
        }

        $this->validate();

        if ($this->editingReview) {
            // Update existing review
            $this->editingReview->update([
                'rating' => $this->rating,
                'comment' => $this->comment,
            ]);
            $message = 'Review updated successfully!';
        } else {
            // Create new review
            Review::create([
                'user_id' => auth()->id(),
                'game_id' => $this->game->id,
                'rating' => $this->rating,
                'comment' => $this->comment,
                'is_approved' => true,
            ]);
            $message = 'Review submitted successfully!';
        }

        $this->dispatch('show-notification', message: $message, type: 'success');
        $this->showReviewForm = false;
        $this->reset(['rating', 'comment']);
        
        // Refresh game data
        $this->game->refresh();
    }

    public function deleteReview()
    {
        if ($this->editingReview && $this->editingReview->user_id === auth()->id()) {
            $this->editingReview->delete();
            $this->editingReview = null;
            $this->reset(['rating', 'comment']);
            $this->dispatch('show-notification', message: 'Review deleted successfully', type: 'success');
            $this->game->refresh();
        }
    }

    public function render()
    {
        $query = $this->game->approvedReviews()->with('user');

        switch ($this->sortBy) {
            case 'highest':
                $query->orderBy('rating', 'desc');
                break;
            case 'lowest':
                $query->orderBy('rating', 'asc');
                break;
            default: // recent
                $query->latest();
        }

        $reviews = $query->get();

        // Calculate rating distribution
        $ratingDistribution = [
            5 => $this->game->approvedReviews()->where('rating', 5)->count(),
            4 => $this->game->approvedReviews()->where('rating', 4)->count(),
            3 => $this->game->approvedReviews()->where('rating', 3)->count(),
            2 => $this->game->approvedReviews()->where('rating', 2)->count(),
            1 => $this->game->approvedReviews()->where('rating', 1)->count(),
        ];

        $totalReviews = array_sum($ratingDistribution);

        return view('livewire.game-reviews', [
            'reviews' => $reviews,
            'ratingDistribution' => $ratingDistribution,
            'totalReviews' => $totalReviews,
            'averageRating' => $this->game->average_rating,
        ]);
    }
}
