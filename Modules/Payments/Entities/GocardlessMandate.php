<?php

namespace Modules\Payments\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Clients\Entities\Client;
use Modules\Invoices\Entities\Invoice;

class GocardlessMandate extends Model
{
    protected $fillable = [
        'client_id','invoice_id','gocardless_flow_id','gocardless_mandate','gocardless_customer','amount',
        'idempotency_key','payment_id'
    ];
    protected $table = 'gocardless_mandates';

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
