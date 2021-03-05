<?php

namespace Modules\Clients\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Messages\Entities\Emailing;

class ClientMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $mail;
    public $module;
    public $signature;

    /**
     * Create a new message instance.
     */
    public function __construct(Emailing $mail, $signature)
    {
        $this->mail      = $mail;
        $this->signature = $signature;
        $this->module    = 'clients';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->mail->files()->count() > 0) {
            foreach ($this->mail->files as $file) {
                $this->attach(storage_path('app/' . $file->path . '/' . $file->filename));
            }
        }
        return $this->subject($this->mail->subject)
            ->from(get_option('company_email'), get_option('company_name'))
            ->markdown('emails.send_email');
    }
}
