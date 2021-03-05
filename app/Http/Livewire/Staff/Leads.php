<?php

namespace App\Http\Livewire\Staff;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Leads extends Component
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
        $leads = Auth::user()->leads()->whereLike(['name', 'AsSource.name', 'status.name', 'job_title', 'company', 'mobile', 'email', 'city', 'country'], $this->search)
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.staff.leads',
            [
                'leads' => $leads,
            ]
        );
    }
}
