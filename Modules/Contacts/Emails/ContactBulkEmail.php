<?php

namespace Modules\Contacts\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Messages\Entities\Emailing;

class ContactBulkEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $mail;
    public $signature;
    public $module;

    /**
     * Create a new message instance.
     *
     * @return void
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
            ->from(leadsEmail()['email'], leadsEmail()['name'])
            ->replyTo($this->mail->sender->email, $this->mail->sender->name)
            ->markdown('emails.contacts.bulkemail');
    }
}
