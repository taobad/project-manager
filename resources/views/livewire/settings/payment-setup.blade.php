<div class="">
    <header class="p-2 text-lg font-semibold text-gray-600 bg-gray-200 rounded-t">
        @icon('solid/sliders-h') @langapp('payment_settings')
    </header>
    <div class="mt-2">

        <form wire:submit.prevent="submit" x-on:submit.prevent>
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="px-4 py-5 bg-gray-100 sm:p-6">
                    <div class="grid grid-cols-1 row-gap-3 col-gap-5 py-2 sm:grid-cols-2">
                        <div class="">
                            <x-inputs.group label="Payment Prefix" for="payment_prefix">
                                <x-inputs.text for="payment_prefix" name="payment_prefix" wire:model.lazy="settings.payment_prefix" />
                                @error('settings.payment_prefix') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>

                        <div class="">
                            <x-inputs.group label="Payment Number Format (YYYY-mm-dd-Number)" for="payment_number_format">
                                <x-inputs.text for="payment_number_format" name="payment_number_format" wire:model.lazy="settings.payment_number_format" />
                                @error('settings.payment_number_format') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
                    </div>

                    <div class="py-1">
                        <x-inputs.group label="Enabled Gateways" for="enabled_gateways">
                            <x-inputs.text for="enabled_gateways" name="enabled_gateways" wire:model.lazy="settings.enabled_gateways" />
                            @error('settings.enabled_gateways') <span class="text-red-500">{{ $message }}</span> @enderror
                        </x-inputs.group>
                        <x-alert type="warning" icon="regular/bell" class="text-sm leading-5">
                            Accepted: <strong>paypal, stripe, mollie, razorpay, checkout, braintree, bank, wepay, paytm, pagseguro, gocardless, square</strong>
                        </x-alert>
                    </div>

                    <div class="mt-1 bg-gray-100 border-b border-gray-300">
                        <header class="p-2 font-semibold text-gray-100 uppercase bg-gray-700 rounded-t-md">Stripe (Payment Gateway)</header>

                        <div class="grid grid-cols-1 row-gap-3 col-gap-5 py-2 sm:grid-cols-2">
                            <div>
                                <x-inputs.group label="Stripe Key" for="stripe_key">
                                    <x-inputs.text for="stripe_key" name="stripe_key" wire:model.lazy="settings.stripe_key" />
                                    @error('settings.stripe_key') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="Stripe Secret" for="stripe_secret">
                                    <x-inputs.text for="stripe_secret" name="stripe_secret" wire:model.lazy="settings.stripe_secret" />
                                    @error('settings.stripe_secret') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>

                        </div>
                        <div class="grid grid-cols-1 row-gap-3 col-gap-5 py-2 sm:grid-cols-2">
                            <div>
                                <x-inputs.group label="Stripe Webhook Secret" for="stripe_webhook_secret">
                                    <x-inputs.text for="stripe_webhook_secret" name="stripe_webhook_secret" wire:model.lazy="settings.stripe_webhook_secret" />
                                    @error('settings.stripe_webhook_secret') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="Stripe Webhook Tolerance" for="stripe_webhook_tolerance">
                                    <x-inputs.text for="stripe_webhook_tolerance" class="bg-blue-200" name="stripe_webhook_tolerance"
                                        wire:model.lazy="settings.stripe_webhook_tolerance" readonly disabled />
                                    @error('settings.stripe_webhook_tolerance') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>

                        </div>
                    </div>

                    <div class="mt-1 bg-gray-100 border-b border-gray-300">
                        <header class="p-2 font-semibold text-gray-100 uppercase bg-gray-700 rounded-t-md">Paypal (Payment Gateway)</header>
                        <div>
                            <x-inputs.group label="Paypal Environment" for="paypal_live">
                                <x-inputs.select for="paypal_live" name="paypal_live" wire:model="settings.paypal_live">
                                    <option value="TRUE">Live</option>
                                    <option value="FALSE">Sandbox</option>
                                </x-inputs.select>
                                @error('settings.paypal_live') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
                        <div>
                            <x-inputs.group label="Paypal Email" for="paypal_email">
                                <x-inputs.text for="paypal_email" name="paypal_email" wire:model.lazy="settings.paypal_email" />
                                @error('settings.paypal_email') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>

                        <x-alert type="success" icon="solid/info-circle" class="text-sm leading-5">
                            Your Paypal IPN URL: {{ route('paypal.ipn') }}
                        </x-alert>

                    </div>

                    <div class="mt-1 bg-gray-100 border-b border-gray-300">
                        <header class="p-2 font-semibold text-gray-100 uppercase bg-gray-700 rounded-t-md">Razorpay (Payment Gateway)</header>
                        <div class="grid grid-cols-1 row-gap-3 col-gap-5 py-2 sm:grid-cols-2">
                            <div>
                                <x-inputs.group label="Razorpay Key" for="razorpay_key">
                                    <x-inputs.text for="razorpay_key" name="razorpay_key" wire:model.lazy="settings.razorpay_key" />
                                    @error('settings.razorpay_key') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="Razorpay Secret" for="razorpay_secret">
                                    <x-inputs.text for="razorpay_secret" name="razorpay_secret" wire:model.lazy="settings.razorpay_secret" />
                                    @error('settings.razorpay_secret') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>

                        </div>
                        <x-alert type="success" icon="solid/info-circle" class="text-sm leading-5">
                            Your RazorPay IPN URL: {{ route('razorpay.webhook') }}
                        </x-alert>

                    </div>

                    <div class="mt-1 bg-gray-100 border-b border-gray-300">
                        <header class="p-2 font-semibold text-gray-100 uppercase bg-gray-700 rounded-t-md">2checkout (Payment Gateway)</header>
                        <div>
                            <x-inputs.group label="2Checkout Live" for="2checkout_live">
                                <x-inputs.select for="2checkout_live" name="2checkout_live" wire:model="settings.2checkout_live">
                                    <option value="FALSE">Sandbox</option>
                                    <option value="TRUE">Live</option>
                                </x-inputs.select>
                                @error('settings.2checkout_live') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
                        <div class="grid grid-cols-1 row-gap-3 col-gap-5 py-2 sm:grid-cols-2">
                            <div>
                                <x-inputs.group label="2checkout Merchant Code" for="2checkout_merchant_code">
                                    <x-inputs.text for="2checkout_merchant_code" name="2checkout_merchant_code" wire:model.lazy="settings.2checkout_merchant_code" />
                                    @error('settings.2checkout_merchant_code') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="2checkout Secret Key" for="2checkout_secret_key">
                                    <x-inputs.text for="2checkout_secret_key" class="bg-blue-200" name="2checkout_secret_key" wire:model.lazy="settings.2checkout_secret_key"
                                        readonly disabled />
                                    @error('settings.2checkout_secret_key') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 row-gap-3 col-gap-5 py-2 sm:grid-cols-2">

                            <div>
                                <x-inputs.group label="2chekout Publishable Key" for="2checkout_publishable_key">
                                    <x-inputs.text for="2checkout_publishable_key" name="2checkout_publishable_key" wire:model.lazy="settings.2checkout_publishable_key" />
                                    @error('settings.2checkout_publishable_key') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="2checkout Private Key" for="2checkout_private_key">
                                    <x-inputs.text for="2checkout_private_key" name="2checkout_private_key" wire:model.lazy="settings.2checkout_private_key" />
                                    @error('settings.2checkout_private_key') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>

                        </div>

                        <x-alert type="success" icon="solid/info-circle" class="text-sm leading-5">
                            Your 2checkout IPN URL: {{ route('2checkout.webhook') }}
                        </x-alert>

                    </div>

                    <div class="mt-1 bg-gray-100 border-b border-gray-300">
                        <header class="p-2 font-semibold text-gray-100 uppercase bg-gray-700 rounded-t-md">Pagseguro (Payment Gateway)</header>
                        <div>
                            <x-inputs.group label="Pagseguro Live" for="pagseguro_live">
                                <x-inputs.select for="pagseguro_live" name="pagseguro_live" wire:model="settings.pagseguro_live">
                                    <option value="TRUE">Live</option>
                                    <option value="FALSE">Sandbox</option>
                                </x-inputs.select>
                                @error('settings.pagseguro_live') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
                        <div class="grid grid-cols-1 row-gap-3 col-gap-5 py-2 sm:grid-cols-2">
                            <div>
                                <x-inputs.group label="Pagseguro Email" for="pagseguro_email">
                                    <x-inputs.text for="pagseguro_email" name="pagseguro_email" wire:model.lazy="settings.pagseguro_email" />
                                    @error('settings.pagseguro_email') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="Pagseguro Token" for="pagseguro_token">
                                    <x-inputs.text for="pagseguro_token" name="pagseguro_token" wire:model.lazy="settings.pagseguro_token" />
                                    @error('settings.pagseguro_token') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>

                        </div>

                    </div>

                    <div class="mt-1 bg-gray-100 border-b border-gray-300">
                        <header class="p-2 font-semibold text-gray-100 uppercase bg-gray-700 rounded-t-md">Braintree (Payment Gateway)</header>
                        <div>
                            <x-inputs.group label="Braintree Environment" for="braintree_live">
                                <x-inputs.select for="braintree_live" name="braintree_live" wire:model="settings.braintree_live">
                                    <option value="FALSE">Sandbox</option>
                                    <option value="TRUE">Live</option>
                                </x-inputs.select>
                                @error('settings.braintree_live') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
                        <div class="grid grid-cols-1 row-gap-4 col-gap-6 py-2 sm:grid-cols-3">
                            <div>
                                <x-inputs.group label="Braintree Merchant ID" for="braintree_merchant_id">
                                    <x-inputs.text for="braintree_merchant_id" name="braintree_merchant_id" wire:model.lazy="settings.braintree_merchant_id" />
                                    @error('settings.braintree_merchant_id') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="Braintree Public Key" for="braintree_public_key">
                                    <x-inputs.text for="braintree_public_key" name="braintree_public_key" wire:model.lazy="settings.braintree_public_key" />
                                    @error('settings.braintree_public_key') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="Braintree Private Key" for="braintree_private_key">
                                    <x-inputs.text for="braintree_private_key" name="braintree_private_key" wire:model.lazy="settings.braintree_private_key" />
                                    @error('settings.braintree_private_key') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>

                        </div>

                    </div>

                    <div class="mt-1 bg-gray-100 border-b border-gray-300">
                        <header class="p-2 font-semibold text-gray-100 uppercase bg-gray-700 rounded-t-md">WePay (Payment Gateway)</header>
                        <div>
                            <x-inputs.group label="WePay Environment" for="wepay_live">
                                <x-inputs.select for="wepay_live" name="wepay_live" wire:model="settings.wepay_live">
                                    <option value="FALSE">Sandbox</option>
                                    <option value="TRUE">Live</option>
                                </x-inputs.select>
                                @error('settings.wepay_live') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
                        <div>
                            <x-inputs.group label="WePay Access Token" for="wepay_access_token">
                                <x-inputs.text for="wepay_access_token" name="wepay_access_token" wire:model.lazy="settings.wepay_access_token" />
                                @error('settings.wepay_access_token') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
                        <div class="grid grid-cols-1 row-gap-4 col-gap-6 py-2 sm:grid-cols-3">
                            <div>
                                <x-inputs.group label="WePay Account ID" for="wepay_account_id">
                                    <x-inputs.text for="wepay_account_id" name="wepay_account_id" wire:model.lazy="settings.wepay_account_id" />
                                    @error('settings.wepay_account_id') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="WePay Client ID" for="wepay_client_id">
                                    <x-inputs.text for="wepay_client_id" name="wepay_client_id" wire:model.lazy="settings.wepay_client_id" />
                                    @error('settings.wepay_client_id') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="WePay Secret ID" for="wepay_secret_id">
                                    <x-inputs.text for="wepay_secret_id" name="wepay_secret_id" wire:model.lazy="settings.wepay_secret_id" />
                                    @error('settings.wepay_secret_id') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>

                        </div>

                        <x-alert type="success" icon="solid/info-circle" class="text-sm leading-5">
                            Your WePay IPN URL: {{ route('wepay.webhook') }}
                        </x-alert>

                    </div>

                    <div class="mt-1 bg-gray-100 border-b border-gray-300">
                        <header class="p-2 font-semibold text-gray-100 uppercase bg-gray-700 rounded-t-md">PayTM (Payment Gateway)</header>
                        <div class="grid grid-cols-1 row-gap-4 col-gap-6 py-2 sm:grid-cols-3">
                            <div>
                                <x-inputs.group label="PayTm ENV (production/local)" for="paytm_env">
                                    <x-inputs.text for="paytm_env" name="paytm_env" wire:model.lazy="settings.paytm_env" />
                                    @error('settings.paytm_env') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="Paytm Merchant ID" for="paytm_merchant_id">
                                    <x-inputs.text for="paytm_merchant_id" name="paytm_merchant_id" wire:model.lazy="settings.paytm_merchant_id" />
                                    @error('settings.paytm_merchant_id') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="Paytm Merchant Key" for="paytm_merchant_key">
                                    <x-inputs.text for="paytm_merchant_key" name="paytm_merchant_key" wire:model.lazy="settings.paytm_merchant_key" />
                                    @error('settings.paytm_merchant_key') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>

                        </div>
                        <div class="grid grid-cols-1 row-gap-4 col-gap-6 py-2 sm:grid-cols-3">
                            <div>
                                <x-inputs.group label="Paytm Merchant Website" for="paytm_website">
                                    <x-inputs.text for="paytm_website" name="paytm_website" wire:model.lazy="settings.paytm_website" />
                                    @error('settings.paytm_website') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="Paytm Channel" for="paytm_channel">
                                    <x-inputs.text for="paytm_channel" name="paytm_channel" wire:model.lazy="settings.paytm_channel" />
                                    @error('settings.paytm_channel') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="Paytm Industry Type" for="paytm_industry_type">
                                    <x-inputs.text for="paytm_industry_type" name="paytm_industry_type" wire:model.lazy="settings.paytm_industry_type" />
                                    @error('settings.paytm_industry_type') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>

                        </div>

                    </div>

                    <div class="mt-1 bg-gray-100 border-b border-gray-300">
                        <header class="p-2 font-semibold text-gray-100 uppercase bg-gray-700 rounded-t-md">Square (Payment Gateway)</header>
                        <div>
                            <x-inputs.group label="Square Environment" for="square_sandbox">
                                <x-inputs.select for="square_sandbox" name="square_sandbox" wire:model="settings.square_sandbox">
                                    <option value="true">Sandbox</option>
                                    <option value="false">Live</option>
                                </x-inputs.select>
                                @error('settings.square_sandbox') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
                        <div class="grid grid-cols-1 row-gap-4 col-gap-6 py-2 sm:grid-cols-3">
                            <div>
                                <x-inputs.group label="Square App ID" for="square_app_id">
                                    <x-inputs.text for="square_app_id" name="square_app_id" wire:model.lazy="settings.square_app_id" />
                                    @error('settings.square_app_id') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>

                            <div>
                                <x-inputs.group label="Square Access Token" for="square_access_token">
                                    <x-inputs.text for="square_access_token" name="square_access_token" wire:model.lazy="settings.square_access_token" />
                                    @error('settings.square_access_token') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="Square Location ID" for="square_location_id">
                                    <x-inputs.text for="square_location_id" name="square_location_id" wire:model.lazy="settings.square_location_id" />
                                    @error('settings.square_location_id') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>

                        </div>
                    </div>

                    <div class="mt-1 bg-gray-100 border-b border-gray-300">
                        <header class="p-2 font-semibold text-gray-100 uppercase bg-gray-700 rounded-t-md">Gocardless (Payment Gateway)</header>
                        <div class="grid grid-cols-1 row-gap-3 col-gap-5 py-2 sm:grid-cols-2">
                            <div>
                                <x-inputs.group label="Gocardless Environment" for="gocardless_environment">
                                    <x-inputs.select for="gocardless_environment" name="gocardless_environment" wire:model="settings.gocardless_environment">
                                        <option value="SANDBOX">Sandbox</option>
                                        <option value="LIVE">Live</option>
                                    </x-inputs.select>
                                    @error('settings.gocardless_environment') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="Auto Collect Money (Mandates)" for="gocardless_auto_collect">
                                    <x-inputs.select for="gocardless_auto_collect" name="gocardless_auto_collect" wire:model="settings.gocardless_auto_collect">
                                        <option value="TRUE">Auto Collect Money</option>
                                        <option value="FALSE">Disabled</option>
                                    </x-inputs.select>
                                    @error('settings.gocardless_auto_collect') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 row-gap-3 col-gap-5 py-2 sm:grid-cols-2">
                            <div>
                                <x-inputs.group label="Gocardless Token" for="gocardless_token">
                                    <x-inputs.text for="gocardless_token" name="gocardless_token" wire:model.lazy="settings.gocardless_token" />
                                    @error('settings.gocardless_token') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="Gocardless Webhook Secret" for="gocardless_webhook_endpoint_secret">
                                    <x-inputs.text for="gocardless_webhook_endpoint_secret" name="gocardless_webhook_endpoint_secret"
                                        wire:model.lazy="settings.gocardless_webhook_endpoint_secret" />
                                    @error('settings.gocardless_webhook_endpoint_secret') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>

                        </div>
                        <x-alert type="success" icon="solid/info-circle" class="text-sm leading-5">
                            Your GoCardless IPN URL: {{ url('/webhook/gocardless/ipn') }}
                        </x-alert>
                    </div>

                    <div class="mt-1 bg-gray-100 border-b border-gray-300">
                        <header class="p-2 font-semibold text-gray-100 uppercase bg-gray-700 rounded-t-md">Mollie (Payment Gateway)</header>
                        <x-inputs.group label="Mollie Key" for="mollie_key">
                            <x-inputs.text for="mollie_key" name="mollie_key" wire:model.lazy="settings.mollie_key" />
                            @error('settings.mollie_key') <span class="text-red-500">{{ $message }}</span> @enderror
                        </x-inputs.group>
                    </div>
                    <x-alert type="success" icon="solid/info-circle" class="text-sm leading-5">
                        Your Mollie IPN URL: {{ route('mollie.ipn') }}
                    </x-alert>
                    <div class="mt-3">
                        <x-inputs.group label="Bank Details (Markdown syntax)" for="bank_details" class="font-semibold">
                            <x-inputs.textarea name="bank_details" for="bank_details" wire:model.lazy="settings.bank_details" rows="4" class="border" />
                            @error('settings.bank_details') <span class="text-red-500">{{ $message }}</span> @enderror
                        </x-inputs.group>
                    </div>

                </div>
                <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                    <div class="inline-flex">
                        <span wire:loading wire:target="submit" class="mt-2 mr-3 text-gray-700">
                            <i class="fas fa-sync fa-spin"></i>
                            Sending...
                        </span>
                        <input wire:loading.class.remove="bg-indigo-500" wire:loading.class="bg-indigo-300" wire:loading.attr="disabled" type="submit" value="{{langapp('save')}}"
                            class="p-3 py-2 mr-4 text-white bg-indigo-500 rounded-md shadow-sm">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="hidden sm:block">
    <div class="py-5">
        <div class="border-t border-gray-200"></div>
    </div>
</div>