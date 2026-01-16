<?php

namespace App\Livewire\Admin;

use App\Models\Banner;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class BannerManager extends Component
{
    use WithFileUploads;

    public $banners;
    public $showModal = false;
    public $isEditing = false;
    public $confirmingDeletion = false;
    public $deleteId = null;

    // Form inputs
    public $bannerId;
    public $title;
    public $description;
    public $image; // Temporary upload
    public $currentImage; // For editing
    public $button_text;
    public $button_url;
    public $is_active = true;
    public $sort_order = 0;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'button_text' => 'nullable|string|max:50',
        'button_url' => 'nullable|string|max:255',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function render()
    {
        $this->banners = Banner::orderBy('sort_order')->orderBy('created_at', 'desc')->get();
        return view('livewire.admin.banner-manager');
    }

    public function create()
    {
        $this->resetInput();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $this->resetInput();
        $this->isEditing = true;
        
        $banner = Banner::find($id);
        $this->bannerId = $banner->id;
        $this->title = $banner->title;
        $this->description = $banner->description;
        $this->currentImage = $banner->image;
        $this->button_text = $banner->button_text;
        $this->button_url = $banner->button_url;
        $this->is_active = $banner->is_active;
        $this->sort_order = $banner->sort_order;

        $this->showModal = true;
    }

    public function store()
    {
        $this->validate([
            'image' => 'required|image|max:2048', // 2MB Max
            'title' => 'required|string|max:255',
        ]);

        $imagePath = $this->image->store('banners', 'public');

        Banner::create([
            'title' => $this->title,
            'description' => $this->description,
            'image' => $imagePath,
            'button_text' => $this->button_text,
            'button_url' => $this->button_url,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
        ]);

        $this->showModal = false;
        $this->resetInput();
        $this->dispatch('banner-saved');
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|string|max:255',
        ]);

        $banner = Banner::find($this->bannerId);
        
        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'button_text' => $this->button_text,
            'button_url' => $this->button_url,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
        ];

        if ($this->image) {
            $this->validate(['image' => 'image|max:2048']);
            
            // Delete old image
            if ($banner->image) {
                Storage::disk('public')->delete($banner->image);
            }
            
            $data['image'] = $this->image->store('banners', 'public');
        }

        $banner->update($data);

        $this->showModal = false;
        $this->resetInput();
        $this->dispatch('banner-saved');
    }

    public function confirmDelete($id)
    {
        $this->confirmingDeletion = true;
        $this->deleteId = $id;
    }

    public function delete()
    {
        $banner = Banner::find($this->deleteId);
        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }
        $banner->delete();

        $this->confirmingDeletion = false;
        $this->deleteId = null;
    }

    public function toggleStatus($id)
    {
        $banner = Banner::find($id);
        $banner->is_active = !$banner->is_active;
        $banner->save();
    }

    private function resetInput()
    {
        $this->bannerId = null;
        $this->title = '';
        $this->description = '';
        $this->image = null;
        $this->currentImage = null;
        $this->button_text = '';
        $this->button_url = '';
        $this->is_active = true;
        $this->sort_order = 0;
        $this->deleteId = null;
        $this->confirmingDeletion = false;
    }
}
