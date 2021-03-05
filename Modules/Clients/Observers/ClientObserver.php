<?php

namespace Modules\Clients\Observers;

use Auth;
use Modules\Clients\Entities\Client;

class ClientObserver
{

    /**
     * Listen to the Client creating event.
     *
     * @param Client $client
     */
    public function creating(Client $client)
    {
        $client->code = generateCode('clients');
        $client->owner = Auth::check() ? Auth::id() : firstAdminId();
    }

    /**
     * Listen to the Client saved event.
     *
     * @param Client $client
     */
    public function saved(Client $client)
    {
        if (request()->has('client_tags')) {
            $client->retag(collect(request('client_tags'))->implode(','));
        }
        $client->saveCustom(request('custom'));
    }

    /**
     * Listen to the Client deleting event.
     *
     * @param Client $client
     */
    public function deleting(Client $client)
    {
        foreach ($client->invoices as $invoice) {
            $invoice->delete();
        }
        foreach ($client->estimates as $estimate) {
            $estimate->delete();
        }
        foreach ($client->expenses as $expense) {
            $expense->delete();
        }
        foreach ($client->credits as $credit) {
            $credit->delete();
        }
        foreach ($client->projects as $project) {
            $project->delete();
        }
        foreach ($client->contracts as $contract) {
            $contract->delete();
        }
        foreach ($client->contacts as $contact) {
            $contact->update(['company' => 0]);
        }
        foreach ($client->payments as $payment) {
            $payment->delete();
        }
        foreach ($client->files as $files) {
            $file->delete();
        }
        foreach ($client->comments as $comment) {
            $comment->delete();
        }
        foreach ($client->activities as $activity) {
            $activity->delete();
        }
        foreach ($client->custom as $field) {
            $field->delete();
        }
        foreach ($client->deals as $deal) {
            $deal->delete();
        }
        $client->detag();

        if ($client->logo != 'default_avatar.png' && !is_null($client->logo) && !isDemo()) {
            \Storage::delete(config('system.logos_dir') . '/' . $client->logo);
        }
    }
}
