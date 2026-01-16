<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\News;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class NewsManager extends Component
{
    use WithPagination, WithFileUploads;

    public $title, $content, $image, $existingImage, $is_featured = false, $is_active = true, $news_id;
    public $showModal = false;
    public $search = '';

    protected $rules = [
        'title' => 'required|min:5',
        'content' => 'required',
        'image' => 'nullable|image|max:2048',
    ];

    public function create()
    {
        $this->reset(['title', 'content', 'image', 'existingImage', 'is_featured', 'is_active', 'news_id']);
        $this->showModal = true;
    }

    public function edit(News $news)
    {
        $this->news_id = $news->id;
        $this->title = $news->title;
        $this->content = $news->content;
        $this->existingImage = $news->image;
        $this->is_featured = $news->is_featured;
        $this->is_active = $news->is_active;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'content' => $this->content,
            'is_featured' => $this->is_featured,
            'is_active' => $this->is_active,
        ];

        if ($this->image) {
            if ($this->existingImage) {
                Storage::disk('public')->delete($this->existingImage);
            }
            $data['image'] = $this->image->store('news', 'public');
        }

        if ($this->news_id) {
            News::find($this->news_id)->update($data);
            session()->flash('success', 'Berita berhasil diperbarui.');
        } else {
            News::create($data);
            session()->flash('success', 'Berita berhasil ditambahkan.');
        }

        $this->showModal = false;
        $this->reset(['title', 'content', 'image', 'news_id']);
    }

    public function delete(News $news)
    {
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }
        $news->delete();
        session()->flash('success', 'Berita berhasil dihapus.');
    }

    public function render()
    {
        $news = News::where('title', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.news-manager', [
            'newsList' => $news
        ])->layout('components.admin-layout');
    }
}
