<?php

namespace App\Http\Livewire\Clients;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Outstanding extends Component
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
        $invoices = Auth::user()->profile->business->invoices()->where('balance', '>', 0)->whereLike(['reference_no', 'payable', 'balance', 'title', 'paid_amount'], $this->search)
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.clients.outstanding',
            [
                'invoices' => $invoices,
            ]
        );
    }
}
