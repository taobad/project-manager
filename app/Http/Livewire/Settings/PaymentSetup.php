<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;

class PaymentSetup extends Component
{
    public $settings;

    public function mount()
    {
        $this->settings = [
            'payment_prefix' => get_option('payment_prefix'),
            'payment_number_format' => get_option('payment_number_format'),
            'enabled_gateways' => get_option('enabled_gateways'),
            'paypal_live' => get_option('paypal_live'),
            'paypal_email' => get_option('paypal_email'),
            'pagseguro_live' => get_option('pagseguro_live'),
            'pagseguro_email' => get_option('pagseguro_email'),
            'pagseguro_token' => get_option('pagseguro_token'),
            '2checkout_live' => get_option('2checkout_live'),
            'braintree_live' => get_option('braintree_live'),
            'wepay_live' => get_option('wepay_live'),
            'bank_details' => get_option('bank_details'),
            'gocardless_auto_collect' => get_option('gocardless_auto_collect'),

            'stripe_key' => config('cashier.key'),
            'stripe_secret' => config('cashier.secret'),
            'stripe_webhook_secret' => config('cashier.webhook.secret'),
            'stripe_webhook_tolerance' => config('cashier.webhook.tolerance'),
            'razorpay_key' => config('services.razorpay.keyId'),
            'razorpay_secret' => config('services.razorpay.secretKey'),
            '2checkout_merchant_code' => config('services.2checkout.merchantCode'),
            '2checkout_secret_key' => config('services.2checkout.secretKey'),
            '2checkout_publishable_key' => config('services.2checkout.publishableKey'),
            '2checkout_private_key' => config('services.2checkout.privateKey'),
            'braintree_merchant_id' => config('services.braintree.merchantId'),
            'braintree_public_key' => config('services.braintree.publicKey'),
            'braintree_private_key' => config('services.braintree.privateKey'),
            'wepay_account_id' => config('services.wepay.accountId'),
            'wepay_client_id' => config('services.wepay.clientId'),
            'wepay_secret_id' => config('services.wepay.secretId'),
            'wepay_access_token' => config('services.wepay.accessToken'),
            'paytm_env' => config('services.paytm-wallet.env'),
            'paytm_merchant_id' => config('services.paytm-wallet.merchant_id'),
            'paytm_merchant_key' => config('services.paytm-wallet.merchant_key'),
            'paytm_website' => config('services.paytm-wallet.merchant_website'),
            'paytm_channel' => config('services.paytm-wallet.channel'),
            'paytm_industry_type' => config('services.paytm-wallet.industry_type'),
            'square_sandbox' => config('services.square.sandbox') ? 'true' : 'false',
            'square_app_id' => config('services.square.app_id'),
            'square_access_token' => config('services.square.access_token'),
            'square_location_id' => config('services.square.location_id'),
            'mollie_key' => config('mollie.key'),
            'gocardless_environment' => config('gocardless.environment'),
            'gocardless_token' => config('gocardless.token'),
            'gocardless_webhook_endpoint_secret' => config('gocardless.webhooks.webhook_endpoint_secret'),
        ];
        $allowedKeys = ['bank_details', 'payment_number_format', 'enabled_gateways'];
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
            $toDatabase = [
                'payment_prefix', 'payment_number_format', 'enabled_gateways', 'paypal_live', 'paypal_email',
                'pagseguro_live', 'pagseguro_email', 'pagseguro_token', '2checkout_live', 'braintree_live',
                'wepay_live', 'bank_details', 'gocardless_auto_collect',
            ];
            foreach ($this->settings as $key => $value) {
                if (!in_array($key, $toDatabase)) {
                    $key = strtoupper($key);
                    $value = preg_replace('/\s+/', '', $value);
                    $values = array($key => $value);
                    setEnvironmentValue($values);
                } else {
                    $value = is_null($value) ? '' : $value;
                    update_option($key, $value);
                }
            }
            \Artisan::call('config:clear');
            \Cache::forget(settingsCacheName());
            session()->flash('success', langapp('changes_saved_successful'));
        } else {
            toastr()->error('Not allowed in demo mode');
        }

        return redirect()->to('/settings/payments');
    }
    public function render()
    {
        return view('livewire.settings.payment-setup');
    }
}
