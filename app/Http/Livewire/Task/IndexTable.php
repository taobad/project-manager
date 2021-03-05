<?php

namespace App\Http\Livewire\Task;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Tasks\Entities\Task;

class IndexTable extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $sortField = 'id';
    public $sortAsc = false;
    public $search = '';
    public $confirming;
    public $filter;

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function confirmDelete($id)
    {
        $this->confirming = $id;
    }

    public function delete($id)
    {
        // $house = Task::find($id);
        // if ($house->tenant()->count()) {
        //     $house->tenant->invoices()->update(['archived_at' => now()]);
        //     $house->tenant->payments()->update(['archived_at' => now()]);
        //     $house->tenant()->update(['archived_at' => now()]);
        // }
        // $house->update(['archived_at' => now()]);
        // session()->flash('danger', 'House ' . $house->number . ' from ' . $house->apartment->name . ' successfully deleted 🗑');
        // return redirect()->to('/houses');
    }

    public function render()
    {
        return view(
            'livewire.task.index-table',
            [
            'tasks' => $this->getTasks()
                ->with(['AsProject', 'AsCategory', 'user'])
                ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                ->paginate($this->perPage),
        ]
        );
    }
    public function getTasks()
    {
        $query = Task::whereLike(['name', 'hourly_rate', 'AsProject.name', 'AsMilestone.milestone_name', 'AsCategory.name', 'user.name'], $this->search);
        return $this->applyFilter($query);
    }
    public function applyFilter($query)
    {
        $filter = request('filter');
        if ($filter === 'done') {
            return $query->completed();
        }
        if ($filter === 'backlog') {
            return $query->backlog();
        }
        if ($filter === 'ongoing') {
            return $query->ongoing();
        }
        if ($filter === 'overdue') {
            return $query->overdue();
        }
        if ($filter === 'mine') {
            return $query->mine();
        }
        if ($filter === 'all') {
            return $query;
        }
        return $query;
    }
}
