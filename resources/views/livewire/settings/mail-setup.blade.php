<div class="">
    <header class="p-2 text-lg font-semibold text-gray-600 bg-gray-200 rounded-t">
        @icon('solid/envelope-open-text') @langapp('mail_settings')
    </header>

    <div class="mt-2">
        <form wire:submit.prevent="submit" x-on:submit.prevent>
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="px-4 py-5 bg-white sm:p-6" x-data="{ isShowing: '{{$settings['mail_driver']}}' }">
                    <x-inputs.group label="{{langapp('mail_driver')}}" for="Mail Driver">
                        <x-inputs.select x-on:change="isShowing = $event.target.value" for="mail_driver" name="mail_driver" wire:model="settings.mail_driver">
                            <option value="">Choose Driver</option>
                            <option value="smtp">SMTP</option>
                            <option value="ses">Amazon SES</option>
                            <option value="mailgun">Mailgun</option>
                            <option value="log">Log</option>
                            <option value="sendmail">Sendmail</option>
                        </x-inputs.select>
                        @error('settings.mail_driver') <span class="text-red-500">{{ $message }}</span> @enderror
                    </x-inputs.group>

                    <div x-show="isShowing === 'smtp'">
                        <x-inputs.group label="SMTP Host" class="text-indigo-700" for="mail_host">
                            <x-inputs.text for="mail_host" name="mail_host" wire:model.lazy="settings.mail_host" />
                            @error('settings.mail_host') <span class="text-red-500">{{ $message }}</span> @enderror
                        </x-inputs.group>
                    </div>

                    <div class="grid grid-cols-1 row-gap-3 col-gap-5 py-2 sm:grid-cols-2">
                        <div x-show="isShowing === 'smtp'">
                            <x-inputs.group label="SMTP Username" for="mail_username">
                                <x-inputs.text for="mail_username" name="mail_username" wire:model.lazy="settings.mail_username" />
                                @error('settings.mail_username') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
                        <div x-show="isShowing === 'smtp'">
                            <x-inputs.group label="SMTP Password" for="mail_password">
                                <x-inputs.text for="mail_password" name="mail_password" wire:model.lazy="settings.mail_password" />
                                @error('settings.mail_password') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>

                    </div>
                    <div class="grid grid-cols-1 row-gap-3 col-gap-5 py-2 sm:grid-cols-2" x-show="isShowing === 'smtp'">
                        <div x-show="isShowing === 'smtp'">
                            <x-inputs.group label="SMTP Port" for="mail_port">
                                <x-inputs.text for="mail_port" name="mail_port" wire:model.lazy="settings.mail_port" />
                                @error('settings.mail_port') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
                        <div x-show="isShowing === 'smtp'">
                            <x-inputs.group label="SMTP Encryption" for="mail_encryption">
                                <x-inputs.text for="mail_encryption" name="mail_encryption" wire:model.lazy="settings.mail_encryption" />
                                @error('settings.mail_encryption') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 row-gap-3 col-gap-5 py-2 sm:grid-cols-2" x-show="isShowing === 'mailgun'">
                        <div x-show="isShowing === 'mailgun'">
                            <x-inputs.group label="Mailgun Domain" for="mailgun_domain">
                                <x-inputs.text for="mailgun_domain" name="mailgun_domain" wire:model.lazy="settings.mailgun_domain" />
                                @error('settings.mailgun_domain') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
                        <div>
                            <x-inputs.group label="Mailgun Secret" for="mailgun_secret">
                                <x-inputs.text for="mailgun_secret" name="mailgun_secret" wire:model.lazy="settings.mailgun_secret" />
                                @error('settings.mailgun_secret') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 row-gap-4 col-gap-6 py-2 sm:grid-cols-3" x-show="isShowing === 'ses'">
                        <div>
                            <x-inputs.group label="SES Key" for="ses_key">
                                <x-inputs.text for="ses_key" name="ses_key" wire:model.lazy="settings.ses_key" />
                                @error('settings.ses_key') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
                        <div>
                            <x-inputs.group label="SES Secret" for="ses_secret">
                                <x-inputs.text for="ses_secret" name="ses_secret" wire:model.lazy="settings.ses_secret" />
                                @error('settings.ses_secret') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
                        <div>
                            <x-inputs.group label="SES Region" for="ses_region">
                                <x-inputs.text for="ses_region" name="ses_region" wire:model.lazy="settings.ses_region" />
                                @error('settings.ses_region') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>

                    </div>
                    <x-inputs.group label="Sparkpost Secret" for="sparkpost_secret" x-show="isShowing === 'sparkpost'">
                        <x-inputs.text for="sparkpost_secret" name="sparkpost_secret" wire:model.lazy="settings.sparkpost_secret" />
                        @error('settings.sparkpost_secret') <span class="text-red-500">{{ $message }}</span> @enderror
                    </x-inputs.group>

                    <div class="grid grid-cols-1 row-gap-3 col-gap-5 py-2 sm:grid-cols-2">
                        <div>
                            <x-inputs.group label="{{langapp('mail_from') }}" for="mail_from_address">
                                <x-inputs.text for="mail_from_address" name="mail_from_address" wire:model.lazy="settings.mail_from_address" />
                                @error('settings.mail_from_address') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
                        <div>
                            <x-inputs.group label="{{langapp('mail_from_name') }}" for="mail_from_name">
                                <x-inputs.text for="mail_from_name" name="mail_from_name" wire:model.lazy="settings.mail_from_name" />
                                @error('settings.mail_from_name') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
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