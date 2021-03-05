<?php

namespace Modules\Invoices\Listeners;

use App\Services\EventCreatorFactory;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Modules\Invoices\Notifications\InvoiceViewedAlert;
use Modules\Users\Entities\User;

class InvoiceEventSubscriber
{
    protected $user;
    protected $eventCreator;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(EventCreatorFactory $eventfactory)
    {
        $this->user = Auth::check() ? Auth::id() : firstAdminId();
        $this->eventCreator = new \App\Services\EventCreator($eventfactory, 'invoices');
    }

    /**
     * Invoice created listener
     */
    public function onInvoiceCreated($event)
    {
        if (!App::runningUnitTests()) {
            $event->invoice->activities()->create([
                'action' => 'activity_create_invoice', 'icon' => 'fa-file-invoice-dollar', 'user_id' => $this->user,
                'value1' => $event->invoice->reference_no, 'value2' => optional($event->invoice->company)->name,
                'url' => $event->invoice->url,
            ]);
            $this->eventCreator->logEvent($event->invoice);
        }
    }

    /**
     * Invoice updated listener
     */
    public function onInvoiceUpdated($event)
    {
        $event->invoice->activities()->create([
            'action' => 'activity_update_invoice', 'icon' => 'fa-pencil-alt', 'user_id' => $this->user,
            'value1' => $event->invoice->reference_no, 'value2' => $event->invoice->company->name,
            'url' => $event->invoice->url,
        ]);
        $this->eventCreator->logEvent($event->invoice);
        Artisan::call('clients:balance');
    }

    /**
     * Invoice polite reminder sent listener
     */
    public function onInvoicePoliteReminder($event)
    {
        $event->invoice->activities()->create([
            'action' => 'activity_invoice_polite_reminder', 'icon' => 'fa-comments-dollar', 'user_id' => $this->user,
            'value1' => $event->invoice->name, 'value2' => $event->invoice->company->email,
            'url' => $event->invoice->url,
        ]);
    }
    /**
     * Invoice firm reminder sent listener
     */
    public function onInvoiceFirmReminder($event)
    {
        $event->invoice->activities()->create([
            'action' => 'activity_invoice_firm_reminder', 'icon' => 'fa-comment-dollar', 'user_id' => $this->user,
            'value1' => $event->invoice->name, 'value2' => $event->invoice->company->email,
            'url' => $event->invoice->url,
        ]);
    }

    /**
     * Invoice final reminder sent listener
     */
    public function onInvoiceFinalReminder($event)
    {
        $event->invoice->activities()->create([
            'action' => 'activity_invoice_final_reminder', 'icon' => 'fa-exclamation-circle', 'user_id' => $this->user,
            'value1' => $event->invoice->name, 'value2' => $event->invoice->company->email,
            'url' => $event->invoice->url,
        ]);
    }

    /**
     * Invoice deleted listener
     */
    public function onInvoiceDeleted($event)
    {
        $event->invoice->activities()->create([
            'action' => 'activity_delete_invoice', 'icon' => 'fa-trash-alt', 'user_id' => $this->user,
            'value1' => $event->invoice->name, 'value2' => $event->invoice->company->name,
            'url' => $event->invoice->url,
        ]);
        $this->eventCreator->deleteEvent($event->invoice);
    }

    /**
     * Invoice sent listener
     */
    public function onInvoiceSent($event)
    {
        $event->invoice->activities()->create([
            'action' => 'activity_sent_invoice', 'icon' => 'fa-envelope-open', 'user_id' => $this->user,
            'value1' => formatCurrency($event->invoice->currency, $event->invoice->balance), 'value2' => $event->invoice->company->name,
            'url' => $event->invoice->url,
        ]);
    }
    /**
     * Invoice paid listener
     */
    public function onInvoicePaid($event)
    {
        if (settingEnabled('archive_invoice')) {
            $event->invoice->update(['archived_at' => now()->toDateTimeString()]);
        }
    }
    /**
     * Invoice viewed listener
     */
    public function onInvoiceViewed($event)
    {
        if (!is_null($event->invoice->sent_at)) {
            $event->invoice->unsetEventDispatcher();
            $event->invoice->activities()->create(
                [
                    'action' => 'activity_viewed_invoice', 'icon' => 'fa-check-circle', 'user_id' => $this->user,
                    'value1' => $event->invoice->reference_no, 'value2' => '',
                    'url' => $event->invoice->url,
                ]
            );

            $user = User::role('admin')->first();
            $user->notify(new InvoiceViewedAlert($event->invoice));
            $event->invoice->update(['viewed_at' => now()->toDateTimeString()]);
        }
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Modules\Invoices\Events\InvoiceCreated',
            'Modules\Invoices\Listeners\InvoiceEventSubscriber@onInvoiceCreated'
        );

        $events->listen(
            'Modules\Invoices\Events\InvoiceUpdated',
            'Modules\Invoices\Listeners\InvoiceEventSubscriber@onInvoiceUpdated'
        );
        $events->listen(
            'Modules\Invoices\Events\InvoiceDeleted',
            'Modules\Invoices\Listeners\InvoiceEventSubscriber@onInvoiceDeleted'
        );
        $events->listen(
            'Modules\Invoices\Events\InvoiceSent',
            'Modules\Invoices\Listeners\InvoiceEventSubscriber@onInvoiceSent'
        );
        $events->listen(
            'Modules\Invoices\Events\InvoicePaid',
            'Modules\Invoices\Listeners\InvoiceEventSubscriber@onInvoicePaid'
        );
        $events->listen(
            'Modules\Invoices\Events\InvoiceViewed',
            'Modules\Invoices\Listeners\InvoiceEventSubscriber@onInvoiceViewed'
        );
        $events->listen(
            'Modules\Invoices\Events\InvoicePoliteReminder',
            'Modules\Invoices\Listeners\InvoiceEventSubscriber@onInvoicePoliteReminder'
        );
        $events->listen(
            'Modules\Invoices\Events\InvoiceFirmReminder',
            'Modules\Invoices\Listeners\InvoiceEventSubscriber@onInvoiceFirmReminder'
        );
        $events->listen(
            'Modules\Invoices\Events\InvoiceFinalReminder',
            'Modules\Invoices\Listeners\InvoiceEventSubscriber@onInvoiceFinalReminder'
        );
    }
}
