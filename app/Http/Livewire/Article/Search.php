<?php

namespace App\Http\Livewire\Article;

use Livewire\Component;

class Search extends Component
{
    public $search = '';

    public function render()
    {
        $this->emit('filterArticles', $this->search);
        return view('livewire.article.search');
    }
}
