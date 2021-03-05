<?php

namespace App\Http\Livewire\Settings;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class ExtraSetup extends Component
{
    public $settings = [];

    public function mount()
    {
        $this->settings = [
            'cookie_consent_enabled' => config('cookie-consent.enabled') ? 'true' : 'false',
            'pdf_font' => config('system.pdf_font'),
            'email_verification' => config('system.verification') ? 'true' : 'false',
            'pwned_password' => config('system.secure_password') ? 'true' : 'false',
            'imap_enabled' => config('system.imap_enabled') ? 'true' : 'false',
            'daily_digest_enabled' => config('system.daily_digest.enabled') ? 'true' : 'false',
            'daily_digest_at' => config('system.daily_digest.send_at'),
            'subscription_currency' => config('system.cashier.currency'),
            'subscription_symbol' => config('system.cashier.symbol'),
            'sms_active' => config('system.sms_active') ? 'true' : 'false',
            'task_due_days' => config('system.task_due_after'),
            'budget_exceeds' => config('system.budget_exceeds'),
            'tasks_remind_overdue' => config('system.remind_overdue_tasks') ? 'true' : 'false',
            'show_items_invoice_mail' => config('system.show_items_invoice_mail') ? 'true' : 'false',
            'show_items_estimate_mail' => config('system.show_items_estimate_mail') ? 'true' : 'false',
            'date_format' => config('system.preferred_date_format'),
            'alert_todo_days' => config('system.alert_todo_before'),
            'auto_remind_contracts' => config('system.autoremind_contracts') ? 'true' : 'false',
            'contract_remind_days' => config('system.remind_contracts_before'),
            'activity_days' => config('system.activity_days'),
            'email_tracking_enable' => config('system.track_emails') ? 'true' : 'false',
            'default_locale' => config('system.default_locale'),
            'invoice_pdf_template' => config('system.pdf.invoices.template'),
            'estimate_pdf_template' => config('system.pdf.estimates.template'),
            'filesystem_driver' => config('filesystems.default'),
            'delete_after' => config('system.delete_after'),
            'backup_disks' => config('backup.backup.destination.disks'),
            'backups_mail_alert' => config('backup.notifications.mail.to'),
            'backups_slack_webhook' => config('backup.notifications.slack.webhook_url'),
            'backups_slack_channel' => config('backup.notifications.slack.channel'),
        ];
        $disallowedKeys = ['backups_mail_alert', 'backups_slack_webhook'];
        if (isDemo()) {
            foreach ($this->settings as $key => $value) {
                if (in_array($key, $disallowedKeys)) {
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
                if (is_array($value)) {
                    $value = implode(",", $value);
                }
                $values = array($key => $value);

                setEnvironmentValue($values);
            }
            Artisan::call('config:clear');
            Cache::forget(settingsCacheName());
            session()->flash('success', langapp('changes_saved_successful'));
        } else {
            toastr()->error('Not allowed in demo mode');
        }
        return redirect()->to('/settings/extras');
    }
    public function render()
    {
        return view('livewire.settings.extra-setup');
    }
}
