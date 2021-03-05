@extends('layouts.app')
@section('content')
@php
$user = Auth::user();
$channels = !is_null($user->profile->channels) ? $user->profile->channels : [];
@endphp
<section id="content">
    <section class="hbox stretch">
        <aside>
            <section class="vbox">
                <header class="px-2 pb-2 bg-white border-b border-gray-400 panel-heading">
                    <div class="flex justify-between text-gray-500">
                        <div>
                            <span class="text-xl font-semibold text-gray-600">{{ $user->name }}</span>
                        </div>
                        <div>
                            <a href="{{ route('users.gdpr.export') }}" class="btn {{themeButton()}}">
                                @icon('solid/database') GDPR Data
                            </a>
                            <a href="{{ route('users.api') }}" class="btn {{themeButton()}}">
                                @icon('solid/code') API Settings
                            </a>
                            <a href="{{ route('users.2fa') }}" class="btn {{themeButton()}}" data-toggle="ajaxModal">
                                @icon('solid/fingerprint') 2FAuth
                            </a>
                            <a href="{{ route('logged-in-devices.list') }}" class="btn {{themeButton()}}">
                                @icon('solid/user-lock') Devices
                            </a>
                        </div>
                    </div>
                </header>

                <section class="scrollable wrapper bg">
                    @if (Auth::user()->on_holiday)
                    <x-alert type="warning" icon="solid/exclamation-triangle" class="text-sm leading-5">
                        @langapp('holiday_enabled')
                    </x-alert>
                    @endif

                    <div class="row">
                        {!! Form::open(['route' => 'users.change', 'class' => 'bs-example ajaxifyForm']) !!}
                        <div class="col-lg-6">
                            <section class="panel panel-default">
                                <header class="p-3 panel-heading">
                                    <span class="text-xl">@langapp('information')</span>
                                    @if($user->profile->company > 0 && $user->profile->business->primary_contact == Auth::id())
                                    <a href="{{ route('contacts.create', Auth::user()->profile->company) }}" class="btn {{themeButton()}} pull-right" data-toggle="ajaxModal"
                                        title="Add Contact Person" data-rel="tooltip" data-placement="bottom">@icon('regular/user-circle') @langapp('contact')</a>
                                    @endif

                                    @if(!Auth::user()->hasRole('client'))
                                    @if (Auth::user()->on_holiday)
                                    <a href="{{ route('users.holiday', 'disable') }}" class="btn {{themeButton()}} pull-right">
                                        @icon('solid/plane-arrival')
                                        @langapp('disable_holiday')</a>
                                    @else
                                    <a href="{{ route('users.holiday', 'enable') }}" class="btn {{themeButton()}} pull-right">
                                        @icon('solid/plane-departure')
                                        @langapp('enable_holiday')
                                    </a>
                                    @endif

                                    @endif
                                </header>
                                <div class="panel-body">

                                    <div class="form-group">
                                        <label>@langapp('fullname') @required</label>
                                        <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>@langapp('hourly_rate') </label>
                                        <input type="text" class="form-control" name="profile[hourly_rate]" value="{{ $user->profile->hourly_rate }}">
                                    </div>
                                    <input type="hidden" value="{{  $user->profile->company }}" name="profile[company]">
                                    @if ($user->profile->company > 0)
                                    <div class="form-group">
                                        <label>@langapp('company')</label>
                                        <input type="text" class="form-control" name="company[name]" value="{{ optional($user->profile)->business->name }}">
                                    </div>

                                    <div class="form-group">
                                        <label data-rel="tooltip" title="Company Mobile">@langapp('company') @langapp('mobile')</label>
                                        <input type="text" class="form-control" name="company[mobile]" value="{{ optional($user->profile)->business->mobile  }}">
                                    </div>
                                    <div class="form-group">
                                        <label>@langapp('company_email')</label>
                                        <input type="text" class="form-control" name="company[email]" value="{{ optional($user->profile)->business->email  }}">
                                    </div>
                                    <div class="form-group">
                                        <label>@langapp('address1')</label>
                                        <input type="text" class="form-control" name="company[address1]" value="{{ optional($user->profile)->business->address1 }}">
                                    </div>
                                    <div class="form-group">
                                        <label>@langapp('address2')</label>
                                        <input type="text" class="form-control" name="company[address2]" value="{{ optional($user->profile)->business->address2 }}">
                                    </div>
                                    <div class="form-group">
                                        <label>@langapp('tax_number')</label>
                                        <input type="text" class="form-control" name="company[tax_number]" value="{{ optional($user->profile)->business->tax_number }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Slack URL <span data-rel="tooltip" title="Your company slack webhook">@icon('brands/slack', 'text-info')</span></label>
                                        <input type="text" class="form-control" name="company[slack_webhook_url]"
                                            value="{{ optional($user->profile)->business->slack_webhook_url }}">
                                    </div>
                                    @endif
                                    <div class="form-group">
                                        <label>@langapp('mobile') </label>
                                        <input type="text" class="form-control" name="profile[mobile]" value="{{ $user->profile->mobile }}">
                                    </div>

                                    <div class="form-group">
                                        <label>@langapp('locale')</label>
                                        <select class="select2-option form-control" name="locale">
                                            @foreach (languages() as $language)
                                            <option value="{{ $language['code'] }}" {{ $user->locale == $language['code'] ? ' selected' : '' }}>{{ ucfirst($language['name']) }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <span class="thumb-sm avatar pull-right">
                                            <img src="{{ $user->profile->photo }}" width="50" class="img-circle m-sm">
                                        </span>
                                        <label>@langapp('avatar') </label>
                                        <input type="file" name="avatar">

                                    </div>

                                    <div class="form-group">

                                        <label>{{ langapp('signature') }}</label>
                                        @if (!is_null($user->profile->signature))
                                        <span class="flex justify-center">
                                            <img class="w-56" src="{{ $user->profile->sign }}" alt="">
                                        </span>
                                        @endif
                                        @if (settingEnabled('enable_signaturepad'))
                                        <input type="hidden" id="saveit" name="signature_image" value="">
                                        <center><canvas id="userSignature" class="m-2 border-gray-300 rounded-md sig" width=400 height=200></canvas></center>
                                        <center>
                                            <button type="button" class="text-white bg-red-500 btn hover:text-white focus:outline-none" onclick="cleartheform()">
                                                Clear Pad
                                            </button>
                                        </center>
                                        @else
                                        <input type="file" name="signature">
                                        @endif
                                    </div>


                                    <div class="form-group">
                                        <label>@langapp('email_signature')</label>
                                        <textarea class="form-control ta" name="profile[email_signature]"
                                            placeholder="{{Auth::user()->name}} &raquo; {{Auth::user()->email}} &raquo; {{get_option('company_domain')}}">{{ $user->profile->email_signature }}</textarea>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="col-lg-6">
                            <section class="panel panel-default">
                                <header class="panel-heading">@langapp('authorization')</header>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label>Slack Webhook URL <span data-rel="tooltip" title="Your slack webhook url">@icon('brands/slack', 'text-red-600')</span></label>
                                        <input type="text" class="form-control" name="slack_webhook_url" value="{{ $user->slack_webhook_url }}">
                                    </div>

                                    <div class="form-group">
                                        <label>Telegram Chat ID <span data-rel="tooltip" title="Your Telegram username (in the format @channelusername)">@icon('brands/telegram',
                                                'text-red-600')</span> <a href="https://telegram.me/userinfobot" target="_blank">View your Chat ID</a> </label>
                                        <input type="text" class="form-control" name="telegram_user_id" value="{{ $user->telegram_user_id }}">
                                    </div>

                                    <div class="form-group">
                                        <label>Calendar Token <a href="{{ route('users.token') }}" class="btn btn-xs btn-info">
                                                @icon('solid/sync-alt')
                                            </a></label>
                                        <input type="text" class="form-control" readonly="readonly" value="{{ $user->calendar_token }}">
                                    </div>
                                    <div class="form-group">
                                        <label>@langapp('notification_channels') @required</label>
                                        <div class="text-gray-600 form-check">
                                            <label>
                                                <input type="checkbox" name="profile[channels][slack]" {{ in_array('slack', $channels) ? 'checked' : '' }}> <span
                                                    class="label-text">@langapp('receive_slack_notifications')</span>
                                            </label>
                                        </div>

                                        <div class="text-gray-600 form-check">
                                            <label>
                                                <input type="checkbox" name="profile[channels][mail]" {{ in_array('mail', $channels) ? 'checked' : '' }}> <span
                                                    class="label-text">@langapp('receive_mail_notifications')</span>
                                            </label>
                                        </div>
                                        <div class="text-gray-600 form-check">
                                            <label>
                                                <input type="checkbox" name="profile[channels][database]" {{ in_array('database', $channels) ? 'checked' : '' }}> <span
                                                    class="label-text">@langapp('receive_app_notifications')</span>
                                            </label>
                                        </div>
                                        <div class="text-gray-600 form-check">
                                            <label>
                                                <input type="checkbox" name="profile[channels][broadcast]" {{ in_array('broadcast', $channels) ? 'checked' : '' }}> <span
                                                    class="label-text">@langapp('receive_broadcast_notification')</span>
                                            </label>
                                        </div>
                                        @if (settingEnabled('sms_active'))
                                        <div class="text-gray-600 form-check">
                                            <label>
                                                <input type="checkbox" name="profile[channels][sms]" {{ in_array('sms', $channels) ? 'checked' : '' }}> <span
                                                    class="label-text">@langapp('receive_sms_notification')</span>
                                            </label>
                                        </div>
                                        @endif
                                        <div class="text-gray-600 form-check">
                                            <label>
                                                <input type="checkbox" name="profile[channels][telegram]" {{ in_array('telegram', $channels) ? 'checked' : '' }}> <span
                                                    class="label-text">@langapp('receive_telegram_notification')</span>
                                            </label>
                                        </div>

                                        @if(settingEnabled('whatsapp_enabled'))
                                        <div class="text-gray-600 form-check">
                                            <label>
                                                <input type="checkbox" name="profile[channels][whatsapp]" {{ in_array('whatsapp', $channels) ? 'checked' : '' }}> <span
                                                    class="label-text">@langapp('receive_whatsapp_notification') <a href="{{ route('whatsapp.subscribe') }}"
                                                        class="btn btn-xs btn-success" data-toggle="ajaxModal">@langapp('subscribe')</a> </span>
                                            </label>
                                        </div>
                                        @endif

                                    </div>
                                    <div class="form-group">
                                        <label>@langapp('email') @required</label>
                                        <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>@langapp('username') @required</label>
                                        <input type="text" class="form-control" name="username" placeholder="@langapp('new_username') " value="{{ $user->username }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>@langapp('password')</label>
                                        <input type="password" class="form-control" name="password" placeholder="@langapp('password') ">
                                    </div>
                                    <div class="form-group">
                                        <label>@langapp('confirm_password')</label>
                                        <input type="password" class="form-control" name="confirm_password" placeholder="@langapp('confirm_password') ">
                                    </div>
                                    <div class="form-group">
                                        <label class="font-semibold text-red-600">@icon('solid/exclamation-triangle') @langapp('danger_zone')</label>
                                        <div class="text-red-600 form-check">
                                            <label>
                                                <input type="checkbox" name="unsubscribed_at" {{ is_null(Auth::user()->unsubscribed_at) ? '' : 'checked' }}
                                                    value="{{ now()->toDateTimeString() }}">
                                                <span class="font-semibold label-text" data-toggle="tooltip"
                                                    title="The right to restrict processing">@langapp('do_not_contact_me')</span>
                                            </label>
                                        </div>

                                        <div class="text-red-600 form-check">
                                            <label>
                                                <input type="checkbox" name="deleted_at" value="{{ now()->toDateTimeString() }}">
                                                <span class="font-semibold label-text" data-toggle="tooltip"
                                                    title="The right to erasure (known as the ‘right to be forgotten’)">@langapp('delete_account_permanent')</span>
                                            </label>
                                        </div>

                                    </div>

                                    {!! renderAjaxButton() !!}

                                </div>
                            </section>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </section>

            </section>

        </aside>
    </section>
</section>
<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
@push('pagestyle')
@include('stacks.css.form')
@endpush
@push('pagescript')
@include('stacks.js.form')
@if (settingEnabled('enable_signaturepad'))
@include('stacks.js.signature')
<script type="text/javascript">
    signaturePad = new SignaturePad(document.getElementById("userSignature"), {
      onEnd: function () {
          document.getElementById("saveit").value = signaturePad.toDataURL();
      }
    });
    function cleartheform() {
     signaturePad.clear();
    }
</script>
@endif
@endpush
@endsection