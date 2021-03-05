<?php

namespace App\Http\Livewire\Article;

use Livewire\Component;

class PublicView extends Component
{
    public $article;

    public function mount($article)
    {
        $this->article = $article;
    }
    public function render()
    {
        return view('livewire.article.public-view', [
            'article' => $this->article,
        ]);
    }
}
