<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Game;
use Livewire\WithPagination;

class GameList extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $games = Game::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('sort_order', 'asc')
            ->paginate(24);

        if ($games->isEmpty() && empty($this->search)) {
            $isDummy = true;
            $items = collect();
            $baseGames = [
                ['name' => 'Mobile Legends', 'description' => 'Top up Diamonds Mobile Legends', 'image' => null, 'slug' => 'mobile-legends'],
                ['name' => 'Free Fire', 'description' => 'Top up Diamonds Free Fire', 'image' => null, 'slug' => 'free-fire'],
                ['name' => 'PUBG Mobile', 'description' => 'Top up UC PUBG Mobile', 'image' => null, 'slug' => 'pubg-mobile'],
                ['name' => 'Genshin Impact', 'description' => 'Top up Genesis Crystal', 'image' => null, 'slug' => 'genshin-impact'],
                ['name' => 'Valorant', 'description' => 'Top up Valorant Points', 'image' => null, 'slug' => 'valorant'],
                ['name' => 'Call of Duty Mobile', 'description' => 'Top up CP COD Mobile', 'image' => null, 'slug' => 'cod-mobile'],
            ];
            
            for ($i = 0; $i < 24; $i++) {
                $bg = $baseGames[$i % count($baseGames)];
                $items->push((object)[
                    'name' => $bg['name'] . ' ' . ($i + 1),
                    'description' => $bg['description'],
                    'image' => $bg['image'],
                    'slug' => $bg['slug'],
                    'id' => $i + 1
                ]);
            }
            
            $games = new \Illuminate\Pagination\LengthAwarePaginator(
                $items,
                100,
                24,
                1,
                ['path' => request()->url()]
            );
        }

        return view('livewire.game-list', [
            'games' => $games,
            'isDummy' => $isDummy ?? false
        ]);
    }     
}
