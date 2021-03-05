<?php

namespace App\Http\Livewire\Payment;

use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class PaymentsWidget extends Component
{
    use WithPagination;
    public $invoice;
    public $perPage = 10;

    public function paginationView()
    {
        return 'vendor.pagination.tailwind';
    }

    public function mount($invoice)
    {
        $this->invoice = $invoice;
    }

    public function render(): View
    {
        return view('livewire.payment.payments-widget', [
            'payments' => $this->invoice->payments()->paginate($this->perPage),
        ]);
    }
}
