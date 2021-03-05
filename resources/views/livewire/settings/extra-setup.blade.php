<div class="">
    <header class="p-2 text-lg font-semibold text-gray-600 bg-gray-200 rounded-t">
        @icon('solid/sliders-h') @langapp('settings')
    </header>
    <div class="mt-2">

        <form wire:submit.prevent="submit" x-on:submit.prevent>
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="px-4 py-5 bg-gray-100 sm:p-6">

                    <div class="grid grid-cols-1 row-gap-4 col-gap-6 py-2 sm:grid-cols-3">
                        <div>
                            <x-inputs.group label="Cookie Consent" for="cookie_consent_enabled">
                                <x-inputs.select for="cookie_consent_enabled" name="cookie_consent_enabled" wire:model="settings.cookie_consent_enabled">
                                    <option value="true">Yes</option>
                                    <option value="false">No</option>
                                </x-inputs.select>
                                @error('settings.cookie_consent_enabled') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
                        <div>
                            <x-inputs.group label="Require Email Verification" for="email_verification">
                                <x-inputs.select for="email_verification" name="email_verification" wire:model="settings.email_verification">
                                    <option value="true">Yes</option>
                                    <option value="false">No</option>
                                </x-inputs.select>
                                @error('settings.email_verification') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
                        <div>
                            <x-inputs.group label="Secure Password Check (PWNED)" for="pwned_password">
                                <x-inputs.select for="pwned_password" name="pwned_password" wire:model="settings.pwned_password">
                                    <option value="true">Yes</option>
                                    <option value="false">No</option>
                                </x-inputs.select>
                                @error('settings.pwned_password') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>

                    </div>

                    <div class="grid grid-cols-1 row-gap-4 col-gap-6 py-2 sm:grid-cols-3">
                        <div>
                            <x-inputs.group label="IMAP Enabled" for="imap_enabled">
                                <x-inputs.select for="imap_enabled" name="imap_enabled" wire:model="settings.imap_enabled">
                                    <option value="true">Enabled</option>
                                    <option value="false">Disabled</option>
                                </x-inputs.select>
                                @error('settings.imap_enabled') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
                        <div>
                            <x-inputs.group label="Send Daily Digest Emails" for="daily_digest_enabled">
                                <x-inputs.select for="daily_digest_enabled" name="daily_digest_enabled" wire:model="settings.daily_digest_enabled">
                                    <option value="true">Enabled</option>
                                    <option value="false">Disabled</option>
                                </x-inputs.select>
                                @error('settings.daily_digest_enabled') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
                        <div>
                            <x-inputs.group label="SMS Messaging" for="sms_active">
                                <x-inputs.select for="sms_active" name="sms_active" wire:model="settings.sms_active">
                                    <option value="true">Active</option>
                                    <option value="false">Inactive</option>
                                </x-inputs.select>
                                @error('settings.sms_active') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>

                    </div>
                    <div class="grid grid-cols-1 row-gap-4 col-gap-6 py-2 sm:grid-cols-3">
                        <div>
                            <x-inputs.group label="Remind Overdue Tasks" for="tasks_remind_overdue">
                                <x-inputs.select for="tasks_remind_overdue" name="tasks_remind_overdue" wire:model="settings.tasks_remind_overdue">
                                    <option value="true">Enabled</option>
                                    <option value="false">Disabled</option>
                                </x-inputs.select>
                                @error('settings.tasks_remind_overdue') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
                        <div>
                            <x-inputs.group label="Show Invoice Items on emails" for="show_items_invoice_mail">
                                <x-inputs.select for="show_items_invoice_mail" name="show_items_invoice_mail" wire:model="settings.show_items_invoice_mail">
                                    <option value="true">Show</option>
                                    <option value="false">Hide</option>
                                </x-inputs.select>
                                @error('settings.show_items_invoice_mail') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
                        <div>
                            <x-inputs.group label="Show estimate items on emails" for="show_items_estimate_mail">
                                <x-inputs.select for="show_items_estimate_mail" name="show_items_estimate_mail" wire:model="settings.show_items_estimate_mail">
                                    <option value="true">Show</option>
                                    <option value="false">Hide</option>
                                </x-inputs.select>
                                @error('settings.show_items_estimate_mail') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>

                    </div>

                    <div class="grid grid-cols-1 row-gap-3 col-gap-5 py-2 sm:grid-cols-2">
                        <div>
                            <x-inputs.group label="Remind Overdue Contracts" for="auto_remind_contracts">
                                <x-inputs.select for="auto_remind_contracts" name="auto_remind_contracts" wire:model="settings.auto_remind_contracts">
                                    <option value="true">Enabled</option>
                                    <option value="false">Disabled</option>
                                </x-inputs.select>
                                @error('settings.auto_remind_contracts') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
                        <div>
                            <x-inputs.group label="Enable Emails Tracking" for="email_tracking_enable">
                                <x-inputs.select for="email_tracking_enable" name="email_tracking_enable" wire:model="settings.email_tracking_enable">
                                    <option value="true">Enabled</option>
                                    <option value="false">Disabled</option>
                                </x-inputs.select>
                                @error('settings.email_tracking_enable') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 row-gap-4 col-gap-6 py-2 sm:grid-cols-3">
                        <div>
                            <x-inputs.group label="PDF Font" for="pdf_font">
                                <x-inputs.text for="pdf_font" name="pdf_font" wire:model.lazy="settings.pdf_font" />
                                @error('settings.pdf_font') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
                        <div>
                            <x-inputs.group label="Daily Digest Time (Ex. 00:00)" for="daily_digest_at">
                                <x-inputs.text for="daily_digest_at" name="daily_digest_at" wire:model.lazy="settings.daily_digest_at" />
                                @error('settings.daily_digest_at') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
                        <div>
                            <x-inputs.group label="Date Format (Ex. d-m-Y)" for="date_format">
                                <x-inputs.text for="date_format" name="date_format" wire:model.lazy="settings.date_format" />
                                @error('settings.date_format') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>


                    </div>
                    <div class="grid grid-cols-1 row-gap-4 col-gap-6 py-2 sm:grid-cols-3">
                        <div>
                            <x-inputs.group label="Subscriptions Currency (USD)" for="subscription_currency">
                                <x-inputs.text for="subscription_currency" name="subscription_currency" wire:model.lazy="settings.subscription_currency" />
                                @error('settings.subscription_currency') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
                        <div>
                            <x-inputs.group label="Subscription Currency Symbol" for="subscription_symbol">
                                <x-inputs.text for="subscription_symbol" name="subscription_symbol" wire:model.lazy="settings.subscription_symbol" />
                                @error('settings.subscription_symbol') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
                        <div>
                            <x-inputs.group label="Tasks overdue after (days)" for="task_due_days">
                                <x-inputs.text for="task_due_days" name="task_due_days" wire:model.lazy="settings.task_due_days" />
                                @error('settings.task_due_days') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>

                    </div>

                    <div class="grid grid-cols-1 row-gap-4 col-gap-6 py-2 sm:grid-cols-3">
                        <div>
                            <x-inputs.group label="Alert project budget exceeds (%)" for="budget_exceeds">
                                <x-inputs.text for="budget_exceeds" name="budget_exceeds" wire:model.lazy="settings.budget_exceeds" />
                                @error('settings.budget_exceeds') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
                        <div>
                            <x-inputs.group label="Remind Todo (Days)" for="alert_todo_days">
                                <x-inputs.text for="alert_todo_days" name="alert_todo_days" wire:model.lazy="settings.alert_todo_days" />
                                @error('settings.alert_todo_days') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
                        <div>
                            <x-inputs.group label="Contract Remind (days)" for="contract_remind_days">
                                <x-inputs.text for="contract_remind_days" name="contract_remind_days" wire:model.lazy="settings.contract_remind_days" />
                                @error('settings.contract_remind_days') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>

                    </div>

                    <div class="grid grid-cols-1 row-gap-3 col-gap-5 py-2 sm:grid-cols-2">
                        <div>
                            <x-inputs.group label="Delete Old Activities (days)" for="activity_days">
                                <x-inputs.text for="activity_days" name="activity_days" wire:model.lazy="settings.activity_days" />
                                @error('settings.activity_days') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
                        <div>
                            <x-inputs.group label="Default Locale" for="default_locale">
                                <x-inputs.text for="default_locale" name="default_locale" wire:model.lazy="settings.default_locale" />
                                @error('settings.default_locale') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>

                    </div>
                    <div class="grid grid-cols-1 row-gap-4 col-gap-6 py-2 sm:grid-cols-3">
                        <div>
                            <x-inputs.group label="Invoice PDF Template" for="invoice_pdf_template">
                                <x-inputs.text for="invoice_pdf_template" name="invoice_pdf_template" wire:model.lazy="settings.invoice_pdf_template" />
                                @error('settings.invoice_pdf_template') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
                        <div>
                            <x-inputs.group label="Estimate PDF Template" for="estimate_pdf_template">
                                <x-inputs.text for="estimate_pdf_template" name="estimate_pdf_template" wire:model.lazy="settings.estimate_pdf_template" />
                                @error('settings.estimate_pdf_template') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
                        <div>
                            <x-inputs.group label="Storage Filesystem (local or s3)" for="filesystem_driver">
                                <x-inputs.text for="filesystem_driver" name="filesystem_driver" wire:model.lazy="settings.filesystem_driver" />
                                @error('settings.filesystem_driver') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>

                    </div>

                    <div class="grid grid-cols-1 row-gap-3 col-gap-5 py-2 sm:grid-cols-2">
                        <div>
                            <x-inputs.group label="Backup Disks (local or s3)" for="backup_disks">
                                <x-inputs.text for="backup_disks" name="backup_disks" wire:model.lazy="settings.backup_disks" />
                                @error('settings.backup_disks') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
                        <div>
                            <x-inputs.group label="Send email after backup to" for="backups_mail_alert">
                                <x-inputs.text for="backups_mail_alert" name="backups_mail_alert" wire:model.lazy="settings.backups_mail_alert" />
                                @error('settings.backups_mail_alert') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>

                    </div>
                    <div class="grid grid-cols-1 row-gap-3 col-gap-5 py-2 sm:grid-cols-2">
                        <div>
                            <x-inputs.group label="Backup Slack Notification Webhook" for="backups_slack_webhook">
                                <x-inputs.text for="backups_slack_webhook" name="backups_slack_webhook" wire:model.lazy="settings.backups_slack_webhook" />
                                @error('settings.backups_slack_webhook') <span class="text-red-500">{{ $message }}</span> @enderror
                            </x-inputs.group>
                        </div>
                        <div>
                            <x-inputs.group label="Backup Slack Notification Channel" for="backups_slack_channel">
                                <x-inputs.text for="backups_slack_channel" name="backups_slack_channel" wire:model.lazy="settings.backups_slack_channel" />
                                @error('settings.backups_slack_channel') <span class="text-red-500">{{ $message }}</span> @enderror
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