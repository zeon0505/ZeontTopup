<?php

namespace App\Livewire\Admin;

use App\Models\Review;
use App\Models\Game;
use Livewire\Component;
use Livewire\WithPagination;

class ReviewManager extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = 'all'; // all, approved, pending
    public $filterRating = 'all';
    public $filterGame = 'all';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleApproval($reviewId)
    {
        $review = Review::findOrFail($reviewId);
        $review->update([
            'is_approved' => !$review->is_approved
        ]);

        $this->dispatch('show-notification', [
            'message' => $review->is_approved ? 'Review approved!' : 'Review unapproved!',
            'type' => 'success'
        ]);
    }

    public function deleteReview($reviewId)
    {
        $review = Review::findOrFail($reviewId);
        $review->delete();

        $this->dispatch('show-notification', [
            'message' => 'Review deleted successfully',
            'type' => 'success'
        ]);
    }

    public function render()
    {
        $query = Review::with(['user', 'game']);

        if ($this->search) {
            $query->where(function($q) {
                $q->where('comment', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function($uq) {
                      $uq->where('name', 'like', '%' . $this->search . '%');
                  })
                  ->orWhereHas('game', function($gq) {
                      $gq->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if ($this->filterStatus !== 'all') {
            $query->where('is_approved', $this->filterStatus === 'approved');
        }

        if ($this->filterRating !== 'all') {
            $query->where('rating', $this->filterRating);
        }

        if ($this->filterGame !== 'all') {
            $query->where('game_id', $this->filterGame);
        }

        $reviews = $query->latest()->paginate(10);
        $games = Game::orderBy('name')->get();

        return view('livewire.admin.review-manager', [
            'reviews' => $reviews,
            'games' => $games
        ])->layout('components.admin-layout');
    }
}
