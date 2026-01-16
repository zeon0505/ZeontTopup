<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Game;
use Illuminate\Support\Str;

class GameEdit extends Component
{
    use WithFileUploads;

    public Game $game;
    
    // Form fields
    public $name = '';
    public $publisher = '';
    public $slug = '';
    public $category = 'Top Up Games';
    public $description = '';
    public $image;
    public $existingImage;
    public $api_endpoint = '';
    public $is_active = true;
    public $sort_order = 0;

    public function mount(Game $game)
    {
        $this->game = $game;
        $this->name = $game->name;
        $this->publisher = $game->publisher;
        $this->slug = $game->slug;
        $this->category = $game->category;
        $this->description = $game->description;
        $this->existingImage = $game->image;
        $this->api_endpoint = $game->api_endpoint;
        $this->is_active = $game->is_active;
        $this->sort_order = $game->sort_order;
    }

    protected function rules()
    {
        return [
            'name' => 'required|min:3',
            'publisher' => 'nullable|string',
            'slug' => 'required|alpha_dash|unique:games,slug,' . $this->game->id,
            'category' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:1024',
            'api_endpoint' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ];
    }

    public function updatedName($value)
    {
        // Only auto-generate slug if it hasn't been manually changed
        if ($this->slug === Str::slug($this->game->name)) {
            $this->slug = Str::slug($value);
        }
    }

    public function save()
    {
        $this->validate();

        try {
            $data = [
                'name' => $this->name,
                'publisher' => $this->publisher,
                'slug' => $this->slug,
                'category' => $this->category,
                'description' => $this->description,
                'api_endpoint' => $this->api_endpoint,
                'is_active' => $this->is_active,
                'sort_order' => $this->sort_order,
            ];

            if ($this->image) {
                $data['image'] = $this->image->store('games', 'public');
            }

            $this->game->update($data);

            session()->flash('success', 'Game updated successfully!');
            $this->dispatch('show-notification', message: 'Game updated successfully!', type: 'success');
            return redirect()->route('admin.games.index');

        } catch (\Exception $e) {
            session()->flash('error', 'Error updating game: ' . $e->getMessage());
            $this->dispatch('show-notification', message: 'Error: ' . $e->getMessage(), type: 'error');
        }
    }

    public function cancel()
    {
        return redirect()->route('admin.games.index');
    }

    public function render()
    {
        return view('livewire.admin.game-edit');
    }
}
