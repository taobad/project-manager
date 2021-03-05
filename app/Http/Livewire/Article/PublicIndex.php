<?php

namespace App\Http\Livewire\Article;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Knowledgebase\Entities\Knowledgebase;

class PublicIndex extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $sortField = 'id';
    public $sortAsc = false;
    public $search = '';

    protected $listeners = [
        'filterArticles' => 'filterArticles',
    ];

    public function filterArticles(string $search)
    {
        $this->search = $search;
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function render()
    {
        $query = Knowledgebase::active()->whereLike(['subject', 'description', 'category.name'], $this->search)->with('category');
        $query = request('cat') ? $query->where('group', request('cat')) : $query;
        return view('livewire.article.public-index', [
            'articles' => $query
                ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                ->paginate($this->perPage),
        ]);
    }
}
