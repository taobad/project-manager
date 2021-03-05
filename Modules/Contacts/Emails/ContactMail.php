<?php

namespace Modules\Contacts\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Messages\Entities\Emailing;

class ContactMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $mail;
    public $signature;
    public $module;

    /**
     * Create a new message instance.
     */
    public function __construct(Emailing $mail, $signature)
    {
        $this->mail      = $mail;
        $this->signature = $signature;
        $this->module    = 'users';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->mail->files->count() > 0) {
            foreach ($this->mail->files as $file) {
                $this->attach(storage_path('app/' . $file->path . '/' . $file->filename));
            }
        }
        return $this->subject($this->mail->subject)
            ->from(get_option('company_email'), get_option('company_name'))
            ->replyTo($this->mail->sender->email, $this->mail->sender->name)
            ->markdown('emails.send_email');
    }
}
