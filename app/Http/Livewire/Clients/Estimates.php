<?php

namespace App\Http\Livewire\Clients;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Estimates extends Component
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
        $estimates = Auth::user()->profile->business->estimates()->where('status', 'Pending')->whereLike(['reference_no', 'amount', 'sub_total', 'title'], $this->search)
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.clients.estimates',
            [
                'estimates' => $estimates,
            ]
        );
    }
}
