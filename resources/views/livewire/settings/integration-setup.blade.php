<div class="">
    <header class="p-2 text-lg font-semibold text-gray-600 bg-gray-200 rounded-t">
        @icon('solid/tools') @langapp('integration_settings')
    </header>

    <div class="mt-2">
        <form wire:submit.prevent="submit" x-on:submit.prevent>
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="px-4 py-5 bg-gray-100 sm:p-6">

                    <div class="bg-gray-100 border-b border-gray-300">
                        <header class="p-2 font-semibold text-gray-100 uppercase bg-gray-700 rounded-t-md">Nexmo (SMS)</header>
                        <div class="grid grid-cols-1 row-gap-4 col-gap-6 py-2 sm:grid-cols-3">
                            <div>
                                <x-inputs.group label="Nexmo Key" for="nexmo_key">
                                    <x-inputs.text for="nexmo_key" name="nexmo_key" wire:model.lazy="settings.nexmo_key" />
                                    @error('settings.nexmo_key') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="Nexmo Secret" for="nexmo_secret">
                                    <x-inputs.text for="nexmo_secret" name="nexmo_secret" wire:model.lazy="settings.nexmo_secret" />
                                    @error('settings.nexmo_secret') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="Nexmo From" for="nexmo_from">
                                    <x-inputs.text for="nexmo_from" name="nexmo_from" wire:model.lazy="settings.nexmo_from" />
                                    @error('settings.nexmo_from') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>

                        </div>
                    </div>
                    <div class="mt-1 bg-gray-100 border-b border-gray-300">
                        <header class="p-2 font-semibold text-gray-100 uppercase bg-gray-700 rounded-t-md">Twilio (SMS)</header>
                        <div class="grid grid-cols-1 row-gap-4 col-gap-6 py-2 sm:grid-cols-3">
                            <div>
                                <x-inputs.group label="Twilio Key" for="twilio_username">
                                    <x-inputs.text for="twilio_username" name="twilio_username" wire:model.lazy="settings.twilio_username" />
                                    @error('settings.twilio_username') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="Twilio Password" for="twilio_password">
                                    <x-inputs.text for="twilio_password" name="twilio_password" wire:model.lazy="settings.twilio_password" />
                                    @error('settings.twilio_password') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="Twilio Auth Token" for="twilio_auth_token">
                                    <x-inputs.text for="twilio_auth_token" name="twilio_auth_token" wire:model.lazy="settings.twilio_auth_token" />
                                    @error('settings.twilio_auth_token') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>

                        </div>
                        <div class="grid grid-cols-1 row-gap-3 col-gap-5 py-2 sm:grid-cols-2">
                            <div>
                                <x-inputs.group label="Twilio Account SID" for="twilio_account_sid">
                                    <x-inputs.text for="twilio_account_sid" name="twilio_account_sid" wire:model.lazy="settings.twilio_account_sid" />
                                    @error('settings.twilio_account_sid') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="Twilio From" for="twilio_from">
                                    <x-inputs.text for="twilio_from" name="twilio_from" wire:model.lazy="settings.twilio_from" />
                                    @error('settings.twilio_from') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>

                        </div>
                    </div>
                    <div class="mt-1 bg-gray-100 border-b border-gray-300">
                        <header class="p-2 font-semibold text-gray-100 uppercase bg-gray-700 rounded-t-md">Twitter (Social Login)</header>
                        <div class="grid grid-cols-1 row-gap-3 col-gap-5 py-2 sm:grid-cols-2">
                            <div>
                                <x-inputs.group label="Twitter Client ID" for="twitter_client_id">
                                    <x-inputs.text for="twitter_client_id" name="twitter_client_id" wire:model.lazy="settings.twitter_client_id" />
                                    @error('settings.twitter_client_id') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="Twitter Client Secret" for="twitter_client_secret">
                                    <x-inputs.text for="twitter_client_secret" name="twitter_client_secret" wire:model.lazy="settings.twitter_client_secret" />
                                    @error('settings.twitter_client_secret') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>

                        </div>
                    </div>
                    <div class="mt-1 bg-gray-100 border-b border-gray-300">
                        <header class="p-2 font-semibold text-gray-100 uppercase bg-gray-700 rounded-t-md">Github (Social Login)</header>
                        <div class="grid grid-cols-1 row-gap-3 col-gap-5 py-2 sm:grid-cols-2">
                            <div>
                                <x-inputs.group label="Github Client ID" for="github_client_id">
                                    <x-inputs.text for="github_client_id" name="github_client_id" wire:model.lazy="settings.github_client_id" />
                                    @error('settings.github_client_id') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="Github Client Secret" for="github_client_secret">
                                    <x-inputs.text for="github_client_secret" name="github_client_secret" wire:model.lazy="settings.github_client_secret" />
                                    @error('settings.github_client_secret') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>

                        </div>
                    </div>
                    <div class="mt-1 bg-gray-100 border-b border-gray-300">
                        <header class="p-2 font-semibold text-gray-100 uppercase bg-gray-700 rounded-t-md">Facebook (Social Login)</header>
                        <div class="grid grid-cols-1 row-gap-3 col-gap-5 py-2 sm:grid-cols-2">
                            <div>
                                <x-inputs.group label="Facebook Client ID" for="facebook_client_id">
                                    <x-inputs.text for="facebook_client_id" name="facebook_client_id" wire:model.lazy="settings.facebook_client_id" />
                                    @error('settings.facebook_client_id') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="Facebook Client Secret" for="facebook_client_secret">
                                    <x-inputs.text for="facebook_client_secret" name="facebook_client_secret" wire:model.lazy="settings.facebook_client_secret" />
                                    @error('settings.facebook_client_secret') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>

                        </div>
                    </div>

                    <div class="mt-1 bg-gray-100 border-b border-gray-300">
                        <header class="p-2 font-semibold text-gray-100 uppercase bg-gray-700 rounded-t-md">Google (Social Login)</header>
                        <div class="grid grid-cols-1 row-gap-3 col-gap-5 py-2 sm:grid-cols-2">
                            <div>
                                <x-inputs.group label="Google Client ID" for="google_client_id">
                                    <x-inputs.text for="google_client_id" name="google_client_id" wire:model.lazy="settings.google_client_id" />
                                    @error('settings.google_client_id') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="Google Client Secret" for="google_client_secret">
                                    <x-inputs.text for="google_client_secret" name="google_client_secret" wire:model.lazy="settings.google_client_secret" />
                                    @error('settings.google_client_secret') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>

                        </div>
                    </div>

                    <div class="mt-1 bg-gray-100 border-b border-gray-300">
                        <header class="p-2 font-semibold text-gray-100 uppercase bg-gray-700 rounded-t-md">Gitlab (Social Login)</header>
                        <div class="grid grid-cols-1 row-gap-3 col-gap-5 py-2 sm:grid-cols-2">
                            <div>
                                <x-inputs.group label="Gitlab Client ID" for="gitlab_client_id">
                                    <x-inputs.text for="gitlab_client_id" name="gitlab_client_id" wire:model.lazy="settings.gitlab_client_id" />
                                    @error('settings.gitlab_client_id') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="Gitlab Client Secret" for="gitlab_client_secret">
                                    <x-inputs.text for="gitlab_client_secret" name="gitlab_client_secret" wire:model.lazy="settings.gitlab_client_secret" />
                                    @error('settings.gitlab_client_secret') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>

                        </div>
                    </div>
                    <div class="mt-1 bg-gray-100 border-b border-gray-300">
                        <header class="p-2 font-semibold text-gray-100 uppercase bg-gray-700 rounded-t-md">LinkedIn (Social Login)</header>
                        <div class="grid grid-cols-1 row-gap-3 col-gap-5 py-2 sm:grid-cols-2">
                            <div>
                                <x-inputs.group label="LinkedIn Client ID" for="linkedin_client_id">
                                    <x-inputs.text for="linkedin_client_id" name="linkedin_client_id" wire:model.lazy="settings.linkedin_client_id" />
                                    @error('settings.linkedin_client_id') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="Linkedin Client Secret" for="linkedin_client_secret">
                                    <x-inputs.text for="linkedin_client_secret" name="linkedin_client_secret" wire:model.lazy="settings.linkedin_client_secret" />
                                    @error('settings.linkedin_client_secret') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>

                        </div>
                    </div>




                    <div class="mt-1 bg-gray-100 border-b border-gray-300">
                        <header class="p-2 font-semibold text-gray-100 uppercase bg-gray-700 rounded-t-md">Onesignal (Push Notifications)</header>
                        <div>
                            <x-inputs.group label="Enable Onesignal" for="enable_onesignal">
                                <x-inputs.select for="enable_onesignal" name="enable_onesignal" wire:model="settings.enable_onesignal">
                                    <option value="true">Enable</option>
                                    <option value="false">Disable</option>
                                </x-inputs.select>
                                @error('settings.enable_onesignal') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
                        <div class="grid grid-cols-1 row-gap-3 col-gap-5 py-2 sm:grid-cols-2">
                            <div>
                                <x-inputs.group label="Onesignal App ID" for="onesignal_app_id">
                                    <x-inputs.text for="onesignal_app_id" name="onesignal_app_id" wire:model.lazy="settings.onesignal_app_id" />
                                    @error('settings.onesignal_app_id') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="Onesignal REST API Key" for="onesignal_rest_api_key">
                                    <x-inputs.text for="onesignal_rest_api_key" name="onesignal_rest_api_key" wire:model.lazy="settings.onesignal_rest_api_key" />
                                    @error('settings.onesignal_rest_api_key') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>

                        </div>

                    </div>

                    <div class="mt-1 bg-gray-100 border-b border-gray-300">
                        <header class="p-2 font-semibold text-gray-100 uppercase bg-gray-700 rounded-t-md">Messagebird (SMS)</header>
                        <div class="grid grid-cols-1 row-gap-4 col-gap-6 py-2 sm:grid-cols-3">
                            <div>
                                <x-inputs.group label="Messagebird Access Key" for="messagebird_access_key">
                                    <x-inputs.text for="messagebird_access_key" name="messagebird_access_key" wire:model.lazy="settings.messagebird_access_key" />
                                    @error('settings.messagebird_access_key') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="Messagebird Originator" for="messagebird_originator">
                                    <x-inputs.text for="messagebird_originator" name="messagebird_originator" wire:model.lazy="settings.messagebird_originator" />
                                    @error('settings.messagebird_originator') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="Messagebird Recipients" for="messagebird_recipients">
                                    <x-inputs.text for="messagebird_recipients" name="messagebird_recipients" wire:model.lazy="settings.messagebird_recipients" />
                                    @error('settings.messagebird_recipients') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>

                        </div>

                    </div>

                    <div class="mt-1 bg-gray-100 border-b border-gray-300">
                        <header class="p-2 font-semibold text-gray-100 uppercase bg-gray-700 rounded-t-md">ShoutOUT (SMS)</header>
                        <div class="grid grid-cols-1 row-gap-3 col-gap-5 py-2 sm:grid-cols-2">
                            <div>
                                <x-inputs.group label="ShoutOUT API Key" for="shoutout_api_key">
                                    <x-inputs.text for="shoutout_api_key" name="shoutout_api_key" wire:model.lazy="settings.shoutout_api_key" />
                                    @error('settings.shoutout_api_key') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="ShoutOUT SMS Source" for="shoutout_sms_source">
                                    <x-inputs.text for="shoutout_sms_source" name="shoutout_sms_source" wire:model.lazy="settings.shoutout_sms_source" />
                                    @error('settings.shoutout_sms_source') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>

                        </div>

                    </div>

                    <div class="mt-1 bg-gray-100 border-b border-gray-300">
                        <header class="p-2 font-semibold text-gray-100 uppercase bg-gray-700 rounded-t-md">Telegram</header>
                        <x-inputs.group label="Telegram Bot Token" for="telegram_bot_token">
                            <x-inputs.text for="telegram_bot_token" name="telegram_bot_token" wire:model.lazy="settings.telegram_bot_token" />
                            @error('settings.telegram_bot_token') <span class="text-red-500">{{ $message }}</span> @enderror
                        </x-inputs.group>
                    </div>

                    <div class="mt-1 bg-gray-100 border-b border-gray-300">
                        <header class="p-2 font-semibold text-gray-100 uppercase bg-gray-700 rounded-t-md">Re-Captcha (Google Re-Captcha v2)</header>
                        <div class="grid grid-cols-1 row-gap-3 col-gap-5 py-2 sm:grid-cols-2">
                            <div>
                                <x-inputs.group label="Recaptcha Secret" for="nocaptcha_secret">
                                    <x-inputs.text for="nocaptcha_secret" name="nocaptcha_secret" wire:model.lazy="settings.nocaptcha_secret" />
                                    @error('settings.nocaptcha_secret') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="Recaptcha SiteKey" for="nocaptcha_sitekey">
                                    <x-inputs.text for="nocaptcha_sitekey" name="nocaptcha_sitekey" wire:model.lazy="settings.nocaptcha_sitekey" />
                                    @error('settings.nocaptcha_sitekey') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>

                        </div>
                    </div>
                    <div class="mt-1 bg-gray-100 border-b border-gray-300">
                        <header class="p-2 font-semibold text-gray-100 uppercase bg-gray-700 rounded-t-md">Pusher (Push Notifications)</header>
                        <div>
                            <x-inputs.group label="Enable Pusher" for="pusher_enabled">
                                <x-inputs.select for="pusher_enabled" name="pusher_enabled" wire:model.lazy="settings.pusher_enabled">
                                    <option value="true">Enable</option>
                                    <option value="false">Disable</option>
                                </x-inputs.select>
                                @error('settings.pusher_enabled') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
                        <div class="grid grid-cols-1 row-gap-3 col-gap-5 py-2 sm:grid-cols-2">
                            <div>
                                <x-inputs.group label="Pusher App Key" for="pusher_app_key">
                                    <x-inputs.text for="pusher_app_key" name="pusher_app_key" wire:model.lazy="settings.pusher_app_key" />
                                    @error('settings.pusher_app_key') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="Pusher App Secret" for="pusher_app_secret">
                                    <x-inputs.text for="pusher_app_secret" name="pusher_app_secret" wire:model.lazy="settings.pusher_app_secret" />
                                    @error('settings.pusher_app_secret') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 row-gap-3 col-gap-5 py-2 sm:grid-cols-2">
                            <div>
                                <x-inputs.group label="Pusher App ID" for="pusher_app_id">
                                    <x-inputs.text for="pusher_app_id" name="pusher_app_id" wire:model.lazy="settings.pusher_app_id" />
                                    @error('settings.pusher_app_id') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>

                            <div>
                                <x-inputs.group label="Pusher Cluster" for="pusher_app_cluster">
                                    <x-inputs.text for="pusher_app_cluster" name="pusher_app_cluster" wire:model.lazy="settings.pusher_app_cluster" />
                                    @error('settings.pusher_app_cluster') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>

                        </div>
                    </div>

                    <div class="mt-1 bg-gray-100 border-b border-gray-300">
                        <header class="p-2 font-semibold text-gray-100 uppercase bg-gray-700 rounded-t-md">Dropbox (File Storage)</header>
                        <x-inputs.group label="Dropbox Auth Token" for="dropbox_authorization_token">
                            <x-inputs.text for="dropbox_authorization_token" name="dropbox_authorization_token" wire:model.lazy="settings.dropbox_authorization_token" />
                            @error('settings.dropbox_authorization_token') <span class="text-red-500">{{ $message }}</span> @enderror
                        </x-inputs.group>
                    </div>



                    <div class="mt-1 bg-gray-100 border-b border-gray-300">
                        <header class="p-2 font-semibold text-gray-100 uppercase bg-gray-700 rounded-t-md">AWS Services</header>
                        <div class="grid grid-cols-1 row-gap-3 col-gap-5 py-2 sm:grid-cols-2">
                            <div>
                                <x-inputs.group label="AWS Access Key ID" for="aws_access_key_id">
                                    <x-inputs.text for="aws_access_key_id" name="aws_access_key_id" wire:model.lazy="settings.aws_access_key_id" />
                                    @error('settings.aws_access_key_id') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="AWS Secret Access Key" for="aws_secret_access_key">
                                    <x-inputs.text for="aws_secret_access_key" name="aws_secret_access_key" wire:model.lazy="settings.aws_secret_access_key" />
                                    @error('settings.aws_secret_access_key') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>

                        </div>
                        <div class="grid grid-cols-1 row-gap-4 col-gap-6 py-2 sm:grid-cols-3">
                            <div>
                                <x-inputs.group label="AWS Default Region" for="aws_default_region">
                                    <x-inputs.text for="aws_default_region" name="aws_default_region" wire:model.lazy="settings.aws_default_region" />
                                    @error('settings.aws_default_region') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="AWS Bucket" for="aws_bucket">
                                    <x-inputs.text for="aws_bucket" name="aws_bucket" wire:model.lazy="settings.aws_bucket" />
                                    @error('settings.aws_bucket') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="AWS URL" for="aws_url">
                                    <x-inputs.text for="aws_url" name="aws_url" wire:model.lazy="settings.aws_url" />
                                    @error('settings.aws_url') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>

                        </div>
                    </div>

                    <div class="mt-1 bg-gray-100 border-b border-gray-300">
                        <header class="p-2 font-semibold text-gray-100 uppercase bg-gray-700 rounded-t-md">AWS Pinpoint (SMS)</header>
                        <div class="grid grid-cols-1 row-gap-3 col-gap-5 py-2 sm:grid-cols-2">
                            <div>
                                <x-inputs.group label="AWS Pinpoint Key" for="aws_pinpoint_key">
                                    <x-inputs.text for="aws_pinpoint_key" name="aws_pinpoint_key" wire:model.lazy="settings.aws_pinpoint_key" />
                                    @error('settings.aws_pinpoint_key') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="AWS Pinpoint Secret" for="aws_pinpoint_secret">
                                    <x-inputs.text for="aws_pinpoint_secret" name="aws_pinpoint_secret" wire:model.lazy="settings.aws_pinpoint_secret" />
                                    @error('settings.aws_pinpoint_secret') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>

                            </div>

                        </div>
                        <div class="grid grid-cols-1 row-gap-4 col-gap-6 py-2 sm:grid-cols-3">
                            <div>
                                <x-inputs.group label="AWS Pinpoint Sender ID" for="aws_pinpoint_sender_id">
                                    <x-inputs.text for="aws_pinpoint_sender_id" name="aws_pinpoint_sender_id" wire:model.lazy="settings.aws_pinpoint_sender_id" />
                                    @error('settings.aws_pinpoint_sender_id') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="AWS Pinpoint Region" for="aws_pinpoint_region">
                                    <x-inputs.text for="aws_pinpoint_region" name="aws_pinpoint_region" wire:model.lazy="settings.aws_pinpoint_region" />
                                    @error('settings.aws_pinpoint_region') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>
                            <div>
                                <x-inputs.group label="AWS Pinpoint Application ID" for="aws_pinpoint_application_id">
                                    <x-inputs.text for="aws_pinpoint_application_id" name="aws_pinpoint_application_id" wire:model.lazy="settings.aws_pinpoint_application_id" />
                                    @error('settings.aws_pinpoint_application_id') <span class="text-red-500">{{ $message }}</span> @enderror
                                </x-inputs.group>
                            </div>

                        </div>
                    </div>



                    <div class="mt-1 bg-gray-100 border-b border-gray-300">
                        <header class="p-2 font-semibold text-gray-100 uppercase bg-gray-700 rounded-t-md">Drift Chat</header>
                        <x-inputs.group label="Enable Drift" for="enable_drift">
                            <x-inputs.select for="enable_drift" name="enable_drift" wire:model="settings.enable_drift">
                                <option value="true">Enable</option>
                                <option value="false">Disable</option>
                            </x-inputs.select>
                            @error('settings.enable_drift') <span class="text-red-500">{{ $message }}</span> @enderror
                        </x-inputs.group>
                    </div>

                    <div class="mt-1 bg-gray-100 border-b border-gray-300">
                        <header class="p-2 font-semibold text-gray-100 uppercase bg-gray-700 rounded-t-md">Crisp Chat</header>
                        <x-inputs.group label="Enable Crisp" for="enable_crisp">
                            <x-inputs.select for="enable_crisp" name="enable_crisp" wire:model="settings.enable_crisp">
                                <option value="true">Enable</option>
                                <option value="false">Disable</option>
                            </x-inputs.select>
                            @error('settings.enable_crisp') <span class="text-red-500">{{ $message }}</span> @enderror
                        </x-inputs.group>
                    </div>
                    <div class="mt-1 bg-gray-100 border-b border-gray-300">
                        <header class="p-2 font-semibold text-gray-100 uppercase bg-gray-700 rounded-t-md">Tawk Chat</header>
                        <x-inputs.group label="Enable Tawk" for="enable_tawk">
                            <x-inputs.select for="enable_tawk" name="enable_tawk" wire:model="settings.enable_tawk">
                                <option value="true">Enable</option>
                                <option value="false">Disable</option>
                            </x-inputs.select>
                            @error('settings.enable_tawk') <span class="text-red-500">{{ $message }}</span> @enderror
                        </x-inputs.group>
                    </div>
                    <div class="mt-1 bg-gray-100 border-b border-gray-300">
                        <header class="p-2 font-semibold text-gray-100 uppercase bg-gray-700 rounded-t-md">Purechat</header>
                        <x-inputs.group label="Enable Purechat" for="enable_purechat">
                            <x-inputs.select for="enable_purechat" name="enable_purechat" wire:model="settings.enable_purechat">
                                <option value="true">Enable</option>
                                <option value="false">Disable</option>
                            </x-inputs.select>
                            @error('settings.enable_purechat') <span class="text-red-500">{{ $message }}</span> @enderror
                        </x-inputs.group>
                    </div>

                    <div class="mt-1 bg-gray-100 border-b border-gray-300">
                        <header class="p-2 font-semibold text-gray-100 uppercase bg-gray-700 rounded-t-md">Google Static Map</header>
                        <x-inputs.group label="Google Static Map Key" for="google_static_map_key">
                            <x-inputs.text for="google_static_map_key" name="google_static_map_key" wire:model.lazy="settings.google_static_map_key" />
                            @error('settings.google_static_map_key') <span class="text-red-500">{{ $message }}</span> @enderror
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