<?php

namespace Modules\Invoices\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Modules\Invoices\Entities\Invoice;

class InvoiceOverpaid extends Notification
{
    use Queueable;

    public $invoice;
    public $amount;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice, $amount)
    {
        $this->invoice = $invoice;
        $this->amount = $amount;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from(get_option('company_email'), get_option('company_name'))
            ->greeting('Hey')
            ->subject('Invoice Overpayment')
            ->line('An attempt has been made to pay ' . formatCurrency($this->invoice->currency, $this->amount) . ' to invoice ' . $this->invoice->reference_no)
            ->line('The invoice has a balance of ' . formatCurrency($this->invoice->currency, $this->invoice->due()))
            ->line('The system has not saved the transaction because we think it is a duplicate transaction')
            ->action('Review Manually', route('invoices.view', $this->invoice->id))
            ->line('Thank you for using Workice!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
