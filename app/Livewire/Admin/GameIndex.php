<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Game;

class GameIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    #[On('delete')]
    public function delete($gameId)
    {
        try {
            $game = Game::findOrFail($gameId);
            $game->delete();
            
            session()->flash('success', 'Game deleted successfully!');
            $this->dispatch('show-notification', message: 'Game deleted successfully!', type: 'success');
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting game: ' . $e->getMessage());
            $this->dispatch('show-notification', message: 'Error: ' . $e->getMessage(), type: 'error');
        }
    }

    public function promptDelete($gameId)
    {
        $this->dispatch('confirm-game-delete', [
            'gameId' => $gameId, // Pass ID directly
            'title' => 'Delete Game?',
            'text' => 'Are you sure you want to delete this game? This action cannot be undone.',
            'icon' => 'warning',
            'confirmText' => 'Yes, Delete it!',
            'confirmButtonColor' => '#EF4444',
        ]);
    }

    #[On('toggleActive')]
    public function toggleActive($gameId)
    {
        try {
            $game = Game::findOrFail($gameId);
            $game->update(['is_active' => !$game->is_active]);
            
            session()->flash('success', 'Game status updated!');
            $this->dispatch('show-notification', message: 'Status updated!', type: 'success');
        } catch (\Exception $e) {
            session()->flash('error', 'Error updating status: ' . $e->getMessage());
            $this->dispatch('show-notification', message: 'Error: ' . $e->getMessage(), type: 'error');
        }
    }

    public function promptToggleActive($gameId)
    {
        $this->dispatch('confirm-game-toggle', [
            'gameId' => $gameId, // Pass ID directly
            'title' => 'Update Status?',
            'text' => 'Are you sure you want to change the status of this game?',
            'icon' => 'question',
            'confirmText' => 'Yes, Update it!',
        ]);
    }

    public function render()
    {
        $games = Game::query()
            ->when($this->search, function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('slug', 'like', '%' . $this->search . '%');
            })
            // If request route is vouchers, filter only vouchers.
            // If games, filter out vouchers? Or show all?
            // Let's assume separation:
            // /admin/vouchers -> Voucher
            // /admin/games -> !Voucher
            ->when(request()->routeIs('admin.vouchers'), function($q) {
                $q->where('category', 'Voucher');
            })
            ->when(request()->routeIs('admin.games.index'), function($q) {
                $q->where('category', '!=', 'Voucher');
            })
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate($this->perPage);

        return view('livewire.admin.game-index', [
            'games' => $games,
        ]);
    }
}
