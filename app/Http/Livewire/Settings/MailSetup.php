<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;

class MailSetup extends Component
{
    public $settings = [];

    public function mount()
    {
        $this->settings = [
            'mail_driver' => config('mail.default'),
            'mail_host' => config('mail.mailers.smtp.host'),
            'mail_port' => config('mail.mailers.smtp.port'),
            'mail_encryption' => config('mail.mailers.smtp.encryption'),
            'mail_username' => config('mail.mailers.smtp.username'),
            'mail_password' => config('mail.mailers.smtp.password'),
            'mailgun_domain' => config('services.mailgun.domain'),
            'mailgun_secret' => config('services.mailgun.secret'),
            'ses_key' => config('services.ses.key'),
            'ses_secret' => config('services.ses.secret'),
            'ses_region' => config('services.ses.region'),
            'sparkpost_secret' => config('services.sparkpost.secret'),
            'mail_from_address' => config('mail.from.address'),
            'mail_from_name' => config('mail.from.name'),
        ];
        $allowedKeys = ['mail_driver'];
        if (isDemo()) {
            foreach ($this->settings as $key => $value) {
                if (strlen($value) > 6 && !in_array($key, $allowedKeys)) {
                    $this->settings[$key] = hideString($value);
                }
            }
        }
    }
    public function submit()
    {
        if (!isDemo()) {
            $this->validate([
                'settings.mail_driver' => 'required',
                'settings.mail_from_address' => 'required',
                'settings.mail_from_name' => 'required',
            ]);
            foreach ($this->settings as $key => $value) {
                $key = strtoupper($key);
                if ($key == "MAIL_FROM_NAME") {
                    $value = "\"$value\"";
                } else {
                    $value = preg_replace('/\s+/', '', $value);
                }
                $values = array($key => $value);
                setEnvironmentValue($values);
            }
            \Artisan::call('config:clear');
            \Cache::forget(settingsCacheName());
            session()->flash('success', langapp('changes_saved_successful'));
        } else {
            toastr()->error('Not allowed in demo mode');
        }
        return redirect()->to('/settings/mail');
    }
    public function render()
    {
        return view('livewire.settings.mail-setup');
    }
}
