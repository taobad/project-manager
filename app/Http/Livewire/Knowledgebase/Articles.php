<?php

namespace App\Http\Livewire\Knowledgebase;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Knowledgebase\Entities\Knowledgebase;

class Articles extends Component
{
    use WithPagination;

    public $group_id;
    public $perPage = 10;
    public $sortField = 'id';
    public $sortAsc = false;
    public $search = '';

    public function mount($group_id)
    {
        $this->group_id = $group_id;
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
        $query = Knowledgebase::where('group', $this->group_id)->whereLike(['subject', 'description', 'user.name'], $this->search);
        return view('livewire.knowledgebase.articles', [
            'articles' => $query
                ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                ->paginate($this->perPage),
        ]);
    }
}
