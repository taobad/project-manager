<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;

class IntegrationSetup extends Component
{
    public $settings;

    public function mount()
    {
        $this->settings = [
            'nexmo_key' => config('services.nexmo.key'),
            'nexmo_secret' => config('services.nexmo.secret'),
            'nexmo_from' => config('services.nexmo.sms_from'),
            'twilio_username' => config('services.twilio.username'),
            'twilio_password' => config('services.twilio.password'),
            'twilio_auth_token' => config('services.twilio.auth_token'),
            'twilio_account_sid' => config('services.twilio.account_sid'),
            'twilio_from' => config('services.twilio.from'),
            'twitter_client_id' => config('services.twitter.client_id'),
            'twitter_client_secret' => config('services.twitter.client_secret'),
            'github_client_id' => config('services.github.client_id'),
            'github_client_secret' => config('services.github.client_secret'),
            'facebook_client_id' => config('services.facebook.client_id'),
            'facebook_client_secret' => config('services.facebook.client_secret'),
            'google_client_id' => config('services.google.client_id'),
            'google_client_secret' => config('services.google.client_secret'),
            'gitlab_client_id' => config('services.gitlab.client_id'),
            'gitlab_client_secret' => config('services.gitlab.client_secret'),
            'linkedin_client_id' => config('services.linkedin.client_id'),
            'linkedin_client_secret' => config('services.linkedin.client_secret'),
            'enable_onesignal' => config('system.enable_onesignal') ? 'true' : 'false',
            'onesignal_app_id' => config('services.onesignal.app_id'),
            'onesignal_rest_api_key' => config('services.onesignal.rest_api_key'),
            'messagebird_access_key' => config('services.messagebird.access_key'),
            'messagebird_originator' => config('services.messagebird.originator'),
            'messagebird_recipients' => config('services.messagebird.recipients'),
            'telegram_bot_token' => config('services.telegram-bot-api.token'),
            'nocaptcha_secret' => config('captcha.secret'),
            'nocaptcha_sitekey' => config('captcha.sitekey'),
            'pusher_app_id' => config('broadcasting.connections.pusher.app_id'),
            'pusher_app_key' => config('broadcasting.connections.pusher.key'),
            'pusher_app_secret' => config('broadcasting.connections.pusher.secret'),
            'pusher_app_cluster' => config('broadcasting.connections.pusher.options.cluster'),
            'pusher_enabled' => config('system.pusher_enabled') ? 'true' : 'false',
            'dropbox_authorization_token' => config('filesystems.disks.dropbox.authorizationToken'),
            'aws_access_key_id' => config('filesystems.disks.s3.key'),
            'aws_secret_access_key' => config('filesystems.disks.s3.secret'),
            'aws_default_region' => config('filesystems.disks.s3.region'),
            'aws_bucket' => config('filesystems.disks.s3.bucket'),
            'aws_url' => config('filesystems.disks.s3.url'),
            'enable_drift' => config('system.drift_enabled') ? 'true' : 'false',
            'enable_crisp' => config('system.crisp_enabled') ? 'true' : 'false',
            'enable_tawk' => config('system.enable_tawk') ? 'true' : 'false',
            'enable_purechat' => config('system.enable_purechat') ? 'true' : 'false',
            'google_static_map_key' => config('system.google.mapkey'),
            'aws_pinpoint_region' => config('aws.Pinpoint.region'),
            'aws_pinpoint_application_id' => config('aws.Pinpoint.application_id'),
            'aws_pinpoint_sender_id' => config('aws.Pinpoint.sender_id'),
            'aws_pinpoint_key' => config('aws.Pinpoint.key'),
            'aws_pinpoint_secret' => config('aws.Pinpoint.secret'),
            'shoutout_api_key' => config('shoutout.api_key'),
            'shoutout_sms_source' => config('shoutout.sms_source'),
        ];
        $allowedKeys = ['enable_drift'];
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
            foreach ($this->settings as $key => $value) {
                $key = strtoupper($key);
                $value = preg_replace('/\s+/', '', $value);
                $values = array($key => $value);
                setEnvironmentValue($values);
            }
            \Artisan::call('config:clear');
            \Cache::forget(settingsCacheName());
            session()->flash('success', langapp('changes_saved_successful'));
        } else {
            toastr()->error('Not allowed in demo mode');
        }
        return redirect()->to('/settings/integrations');
    }
    public function render()
    {
        return view('livewire.settings.integration-setup');
    }
}
