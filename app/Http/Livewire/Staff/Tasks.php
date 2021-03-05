<?php

namespace App\Http\Livewire\Staff;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Tasks\Entities\Task;

class Tasks extends Component
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
    public function render()
    {
        $entries = Auth::user()->assignments()->where('assignable_type', Task::class)->whereHas('assignable', function ($query) {
            return $query->where('progress', '<', 100);
        })->whereLike(['assignable.name', 'assignable.description'], $this->search)
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.staff.tasks',
            [
                'entries' => $entries,
            ]
        );
    }
}
