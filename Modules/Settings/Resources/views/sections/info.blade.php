<div class="row">

    <div class="col-lg-12">

        <div class="alert alert-warning small">
            @icon('solid/exclamation-circle') Always make a backup before updating
            @admin
            <a href="#" class="btn {{themeButton()}} pull-right" id="updatesBtn" data-rel="tooltip" title="Check for updates now">
                @icon('solid/code-branch') @langapp('check_for_updates')
            </a>
            <a href="#" class="btn {{themeButton()}} pull-right" id="backupBtn">
                @icon('solid/database') Backup
            </a>
            @endadmin
        </div>

        <div id="changelogs"></div>

        <div class="alert alert-info small">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p><strong data-toggle="tooltip" title="Run command crontab -e and enter this command" data-placement="right">CRON: </strong>
                <span class="p-1 m-1 leading-5 tracking-wide text-gray-100 bg-gray-700 rounded-sm text-gray">
                    * * * * * php {{ isDemo() ? '' : base_path() }}/artisan schedule:run >/dev/null
                </span>
                <a href="https://discuss.workice.com/d/9-setting-up-cron" class="ml-3 font-semibold text-blue-700" target="_blank">Read More</a>
            </p>
            <p><strong data-toggle="tooltip" title="Set the command to run every Minute" data-placement="right">CPANEL CRON Command:</strong>
                <span class="p-1 m-1 leading-5 tracking-wide text-gray-100 bg-gray-700 rounded-sm text-gray">
                    /opt/cpanel/ea-php74/root/usr/bin/php {{ isDemo() ? '' : base_path() }}/artisan schedule:run >/dev/null
                </span>
            </p>
            <p><strong data-toggle="tooltip" title="Use a service e.g https://cron-job.org to set cron via URL" data-placement="right">CRON URL</strong>
                <span class="p-1 m-1 leading-5 tracking-wide text-gray-100 bg-gray-700 rounded-sm text-gray">
                    {{ route('artisan.schedule', ['token' => get_option('cron_key')]) }}
                </span>
            </p>
            <p><strong>WhatsApp Webhook URL</strong>
                <span class="p-1 m-1 leading-5 tracking-wide text-gray-100 bg-gray-700 rounded-sm text-gray">
                    {{ route('whatsapp.incoming', get_option('cron_key')) }}
                </span>
                <a href="https://discuss.workice.com/d/18-whatsapp-workice-integration" class="ml-3 font-semibold text-blue-700" target="_blank">Read More</a>
            </p>
            <p><strong>SMS Inbound Webhook</strong>
                <span class="p-1 m-1 leading-5 tracking-wide text-gray-100 bg-gray-700 rounded-sm text-gray">
                    {{ route('sms.inbound', get_option('cron_key')) }}</soan>
            </p>
            <p><strong>Aircall Webhook</strong>
                <span class="p-1 m-1 leading-5 tracking-wide text-gray-100 bg-gray-700 rounded-sm text-gray">
                    {{ route('aircall.inbound', get_option('cron_key')) }}
                </span>
                <a href="https://discuss.workice.com/d/32-aircall-integration-with-workice-crm" class="ml-3 font-semibold text-blue-700" target="_blank">Read More</a>
            </p>

        </div>

        <div class="m-xs">
            <span class="text-dark">Laravel Version</span>: <span class="text-gray-600">{{ app()->version() }}</span>
        </div>
        <div class="line"></div>
        @php
        $latest = getLastVersion();
        @endphp
        <div class="m-1">
            <span class="text-dark">Workice CRM Version</span>: <span class="text-gray-600">{{ getCurrentVersion()['version'] }}</span>
            @if (isset($latest['id']))
            <span class="p-1 ml-2 text-white bg-blue-600 border border-blue-600 rounded-md">
                {{ $latest['attributes']['build'] <= getCurrentVersion()['build'] ? 'Latest Version' : 'Update v.'.$latest['attributes']['version'].' Available' }}
            </span>
            @if ($latest['attributes']['build'] > getCurrentVersion()['build'] )
            <h2 class="p-3 font-semibold text-gray-500 uppercase">Changelogs</h2>
            <div class="ml-6 leading-5 text-gray-600">
                @parsedown($latest['attributes']['description'])
            </div>
            @endif

            @endif

        </div>
        <div class="line"></div>
        <div class="m-xs">
            <span class="text-dark">Build</span>: <span class="text-gray-600">{{ getCurrentVersion()['build'] }}</span>
        </div>
        <div class="line"></div>
        <div class="m-xs">
            <span class="text-dark">OS Version</span>: <span class="text-gray-600">{{ php_uname('s') }}</span>
        </div>
        <div class="line"></div>
        <div class="m-xs">
            <span class="text-dark">PHP Version</span>: <span class="text-gray-600">{{ phpversion() }}</span>
        </div>
        <div class="line"></div>
        <div class="m-xs">
            <span class="text-dark">Your App Name</span>: <span class="text-gray-600">{{ config('app.name') }}</span>
        </div>
        <div class="line"></div>
        <div class="m-xs">
            <span class="text-dark">Timezone</span>: <span class="text-gray-600">{{ date_default_timezone_get() }}</span>
        </div>
        <div class="line"></div>
        <div class="m-xs">
            <span class="text-dark">Server Time</span>: <span class="text-gray-600">{{ dateTimeFormatted(now()) }}</span>
        </div>
        <div class="line"></div>
        @if(!settingEnabled('demo_mode'))
        <div class="m-xs">
            <span class="text-dark">Purchase Code</span>: <span class="text-gray-600">{{ get_option('purchase_code') }}</span>
        </div>
        <div class="line"></div>
        @endif


    </div>
</div>

@push('pagescript')
<script>
    $("#backupBtn").click(function() {
        $("#backupBtn").html('Backing up, please wait..<i class="fas fa-spin fa-spinner"></i>');
        axios.get('{{ route('updates.backup') }}')
        .then(function (response) {
            toastr.success(response.data.message, '@langapp('response_status')');
            $("#backupBtn").html('Completed');
        })
        .catch(function (error) {
            toastr.error('Oops! Request failed to complete.', '@langapp('response_status')');
            $("#backupBtn").html('Try Again');
        });
    });
    $("#updatesBtn").click(function() {
        $("#updatesBtn").html('Checking updates, please wait..<i class="fas fa-spin fa-spinner"></i>');
        axios.get('{{ route('updates.check') }}')
        .then(function (response) {
            toastr.success(response.data.message, '@langapp('response_status')');
            $("#updatesBtn").html('Completed');
            location.reload();
        })
        .catch(function (error) {
            toastr.error('Oops! Request failed to complete.', '@langapp('response_status') ');
            $("#updatesBtn").html('Try Again');
        });
    });
</script>
@endpush