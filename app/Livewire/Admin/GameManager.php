<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Game;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class GameManager extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $showModal = false;
    public $editingGameId = null;
    
    // Form fields
    public $name = '';
    public $slug = '';
    public $description = '';
    public $image; // For upload
    public $existingImage; // For display
    public $api_endpoint = '';
    public $is_active = true;
    public $sort_order = 0;

    protected $rules = [
        'name' => 'required|min:3',
        'slug' => 'required|alpha_dash|unique:games,slug',
        'description' => 'nullable|string',
        'image' => 'nullable|image|max:1024', // 1MB Max
        'api_endpoint' => 'nullable|string',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function updatedName($value)
    {
        if (!$this->editingGameId) {
            $this->slug = Str::slug($value);
        }
    }

    public function openCreateModal()
    {
        $this->reset(['name', 'slug', 'description', 'image', 'existingImage', 'api_endpoint', 'editingGameId']);
        $this->is_active = true;
        $this->sort_order = 0;
        $this->showModal = true;
    }

    public function openEditModal($gameId)
    {
        $game = Game::findOrFail($gameId);
        $this->editingGameId = $game->id;
        $this->name = $game->name;
        $this->slug = $game->slug;
        $this->description = $game->description;
        $this->existingImage = $game->image;
        $this->api_endpoint = $game->api_endpoint;
        $this->is_active = $game->is_active;
        $this->sort_order = $game->sort_order;
        $this->showModal = true;
    }

    public function save()
    {
        // Dynamic validation for unique slug
        $rules = $this->rules;
        if ($this->editingGameId) {
            $rules['slug'] = 'required|alpha_dash|unique:games,slug,' . $this->editingGameId;
        }
        
        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'api_endpoint' => $this->api_endpoint,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
        ];

        if ($this->image) {
            $data['image'] = $this->image->store('games', 'public');
        }

        if ($this->editingGameId) {
            $game = Game::find($this->editingGameId);
            // If new image uploaded and old one exists, delete old one? (Optional optimization)
            $game->update($data);
        } else {
            Game::create($data);
        }

        $this->showModal = false;
        $this->dispatch('show-notification', message: 'Game saved successfully!', type: 'success');
    }

    public function delete($gameId)
    {
        Game::findOrFail($gameId)->delete();
        $this->dispatch('show-notification', message: 'Game deleted successfully!', type: 'success');
    }

    public function render()
    {
        $games = Game::orderBy('sort_order')->orderBy('name')->paginate(10);

        return view('livewire.admin.game-manager', [
            'games' => $games,
        ]);
    }
}
