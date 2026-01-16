<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Game;
use Illuminate\Support\Str;

class GameCreate extends Component
{
    use WithFileUploads;

    // Form fields
    public $name = '';
    public $publisher = '';
    public $slug = '';
    public $category = 'Top Up Games';
    public $description = '';
    public $image;
    public $api_endpoint = '';
    public $is_active = true;
    public $sort_order = 0;

    protected $rules = [
        'name' => 'required|min:3',
        'publisher' => 'nullable|string',
        'slug' => 'required|alpha_dash|unique:games,slug',
        'category' => 'required|string',
        'description' => 'nullable|string',
        'image' => 'nullable|image|max:1024', // 1MB Max
        'api_endpoint' => 'nullable|string',
        'is_active' => 'boolean',
        'sort_order' => 'integer|min:0',
    ];

    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function save()
    {
        $this->validate();

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

        Game::create($data);

        session()->flash('success', 'Game created successfully!');
        return redirect()->route('admin.games.index');
    }

    public function cancel()
    {
        return redirect()->route('admin.games.index');
    }

    public function render()
    {
        return view('livewire.admin.game-create');
    }
}
