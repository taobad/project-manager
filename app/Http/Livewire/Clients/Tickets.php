<?php

namespace App\Http\Livewire\Clients;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Tickets extends Component
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
        $tickets = Auth::user()->tickets()->with(['AsStatus', 'AsPriority', 'dept'])->whereNull('closed_at')->whereLike(['code', 'subject', 'body', 'AsStatus.status', 'dept.deptname'], $this->search)
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.clients.tickets',
            [
                'tickets' => $tickets,
            ]
        );
    }
}
