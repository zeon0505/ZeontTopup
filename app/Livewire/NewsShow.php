<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\News;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class NewsShow extends Component
{
    public News $news;

    public function mount(News $news)
    {
        if (!$news->is_active) {
            abort(404);
        }
        $this->news = $news;
    }

    public function render()
    {
        return view('livewire.news-show');
    }
}
