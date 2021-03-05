<?php

namespace App\Http\Livewire\Staff;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Deals extends Component
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
    /**
     * Undocumented function
     *
     * @return void
     */
    public function render()
    {
        $deals = Auth::user()->deals()->whereLike(['title', 'AsSource.name', 'category.name', 'status', 'deal_value'], $this->search)
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.staff.deals',
            [
                'deals' => $deals,
            ]
        );
    }
}
