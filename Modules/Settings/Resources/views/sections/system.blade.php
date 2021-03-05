<div class="row">
    <div class="col-lg-12">
        <section class="panel panel-default">
            <header class="panel-heading">
                @icon('solid/cogs') @langapp('system_settings')
            </header>

            @php
            $currencies = currencies();
            $current_language = get_option('default_language');
            $current_timezone = get_option('timezone');
            $current_symbol = get_option('default_currency_symbol');
            $current_currency = get_option('default_currency');
            $current_locale = get_option('locale');
            @endphp

            {!! Form::open(['route' => ['settings.edit', $section], 'class' => 'bs-example form-horizontal ajaxifyForm']) !!}

            <div class="panel-body">
                <div class="form-group">
                    <label class="col-lg-3 control-label">Purchase Code <span data-toggle="tooltip" title="Get your code from Envato">@icon('regular/question-circle')</span>
                        @required</label>
                    <div class="col-lg-6">
                        <input type="text" name="purchase_code" class="form-control" value="{{ get_option('purchase_code') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('default_language') </label>
                    <div class="col-lg-6">
                        <select name="default_language" class="form-control select2-option">
                            @foreach (languages() as $lang)
                            <option value="{{ $lang['name'] }}" {{ $current_language == $lang['name'] ? ' selected' : '' }}>{{ ucfirst($lang['name'])  }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('locale') </label>
                    <div class="col-lg-6">
                        <select class="form-control select2-option" name="locale" required>
                            @foreach (locales() as $loc)
                            <option value="{{  $loc['code']  }}" {{ $current_locale == $loc['code'] ? ' selected' : '' }}>{{ ucfirst($loc['language']) }} - {{ $loc['code'] }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('timezone')</label>
                    <div class="col-lg-6">
                        <select class="form-control select2-option" name="timezone" required>
                            @foreach (timezones() as $timezone => $description)
                            <option value="{{  $timezone  }}" {{ $current_timezone == $timezone ? ' selected' : '' }}>{{ $description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('default_currency') </label>
                    <div class="col-lg-6">
                        <select name="default_currency" class="form-control select2-option">
                            @foreach ($currencies as $cur)
                            <option value="{{  $cur['code']  }}" {{ $current_currency == $cur['code'] ? ' selected' : '' }}>{{ $cur['title'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('default_currency_symbol') </label>
                    <div class="col-lg-6">
                        <select name="default_currency_symbol" class="form-control select2-option">
                            @foreach ($currencies as $cur)
                            <option value="{{ $cur['symbol'] }}" {{ $current_symbol == $cur['symbol'] ? ' selected' : '' }}>{{ $cur['native'] }}
                                - {{ $cur['title']  }}</option>
                            @endforeach
                        </select>
                    </div>
                    <span class="help-block m-b-none small text-danger">Overwritten by Client's Currency</span>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('thousand_separator')</label>
                    <div class="col-lg-6">
                        <select name="thousand_separator" class="form-control">
                            <option value="," {{ get_option('thousand_separator') == ',' ? 'selected' : '' }}>,</option>
                            <option value="." {{ get_option('thousand_separator') == '.' ? 'selected' : '' }}>.</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('decimal_separator')</label>
                    <div class="col-lg-6">
                        <select name="decimal_separator" class="form-control">
                            <option value="." {{ get_option('decimal_separator') == '.' ? 'selected' : '' }}>.</option>
                            <option value="," {{ get_option('decimal_separator') == ',' ? 'selected' : '' }}>,</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('default_calendar')</label>
                    <div class="col-lg-6">
                        <select class="form-control select2-option" name="default_calendar" required>
                            @foreach (Modules\Calendar\Entities\CalendarType::get() as $cal)
                            <option value="{{  $cal->id  }}" {{  get_option('default_calendar') === $cal->id ? ' selected="selected"' : ''  }}>{{  $cal->name  }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('tax_rates')</label>
                    <div class="col-md-6">
                        <select class="select2-tags form-control" name="default_tax_rates[]" multiple>
                            @php $currentRates = json_decode(get_option('default_tax_rates')); @endphp
                            <option value="" {{ is_null($currentRates[0]) ? 'selected' : ''}}>None</option>
                            @foreach (App\Entities\TaxRate::all() as $tax)
                            <option value="{{ $tax->id }}" {{ !is_null($currentRates) && in_array($tax->id, $currentRates) ? 'selected' : '' }}>
                                {{ $tax->name }} ({{ $tax->rate }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('tax') 1</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control money" value="{{  get_option('default_tax')  }}" name="default_tax">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">Default Subscription</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" value="{{ get_option('default_subscription') }}" name="default_subscription">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">Tax1 Label</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" value="{{ get_option('tax1Label') }}" name="tax1Label">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('tax') 2</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control money" value="{{ get_option('default_tax2') }}" name="default_tax2">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Tax2 Label</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" value="{{ get_option('tax2Label') }}" name="tax2Label">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('tax_decimals')</label>
                    <div class="col-lg-6">
                        <select name="tax_decimals" class="form-control">
                            <option value="0" {{ get_option('tax_decimals') == 0 ? ' selected' : '' }}>0</option>
                            <option value="1" {{ get_option('tax_decimals') == 1 ? ' selected' : '' }}>1</option>
                            <option value="2" {{ get_option('tax_decimals') == 2 ? ' selected' : '' }}>2</option>
                            <option value="3" {{ get_option('tax_decimals') == 3 ? ' selected' : '' }}>3</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('quantity_decimals')</label>
                    <div class="col-lg-6">
                        <select name="quantity_decimals" class="form-control">
                            <option value="0" {{ get_option('quantity_decimals') == 0 ? ' selected' : '' }}>0</option>
                            <option value="1" {{ get_option('quantity_decimals') == 1 ? ' selected' : '' }}>1</option>
                            <option value="2" {{ get_option('quantity_decimals') == 2 ? ' selected' : '' }}>2</option>
                            <option value="3" {{ get_option('quantity_decimals') == 3 ? ' selected' : '' }}>3</option>
                        </select>
                    </div>
                </div>
                @php $date_format = get_option('date_format') @endphp
                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('date_format') </label>
                    <div class="col-lg-6">
                        <select name="date_format" class="form-control">
                            <option value="%d-%m-%Y" {{ $date_format == '%d-%m-%Y' ? ' selected="selected"' : '' }}>{{  strftime('%d-%m-%Y', time())  }}</option>
                            <option value="%m-%d-%Y" {{ $date_format == '%m-%d-%Y' ? ' selected="selected"' : '' }}>{{  strftime('%m-%d-%Y', time())  }}</option>
                            <option value="%Y-%m-%d" {{ $date_format == '%Y-%m-%d' ? ' selected="selected"' : '' }}>{{  strftime('%Y-%m-%d', time())  }}</option>
                            <option value="%Y.%m.%d" {{ $date_format == '%Y.%m.%d' ? ' selected="selected"' : '' }}>{{  strftime('%Y.%m.%d', time())  }}</option>
                            <option value="%d.%m.%Y" {{ $date_format == '%d.%m.%Y' ? ' selected="selected"' : '' }}>{{  strftime('%d.%m.%Y', time())  }}</option>
                            <option value="%m.%d.%Y" {{ $date_format == '%m.%d.%Y' ? ' selected="selected"' : '' }}>{{  strftime('%m.%d.%Y', time())  }}</option>
                            <option value="%d/%m/%Y" {{ $date_format == '%d/%m/%Y' ? ' selected="selected"' : '' }}>{{  strftime('%d/%m/%Y', time())  }}</option>
                            <option value="%m/%d/%Y" {{ $date_format == '%m/%d/%Y' ? ' selected="selected"' : '' }}>{{  strftime('%m/%d/%Y', time())  }}</option>
                            <option value="%d %b, %Y" {{ $date_format == '%d %b, %Y' ? ' selected="selected"' : '' }}>{{  strftime('%d %b, %Y', time())  }}</option>
                            <option value="%b %d, %Y" {{ $date_format == '%b %d, %Y' ? ' selected="selected"' : '' }}>{{  strftime('%b %d, %Y', time())  }}</option>
                        </select>
                    </div>
                </div>
                @php $date_picker_format = get_option('date_picker_format') @endphp
                <div class="form-group">
                    <label class="col-lg-3 control-label">Date Picker Format</label>
                    <div class="col-lg-6">
                        <select name="date_picker_format" class="form-control">
                            <option value="dd-mm-yyyy" {{ $date_picker_format == 'dd-mm-yyyy' ? ' selected="selected"' : '' }}>{{  strftime('%d-%m-%Y', time())  }}</option>
                            <option value="mm-dd-yyyy" {{ $date_picker_format == 'mm-dd-yyyy' ? ' selected="selected"' : '' }}>{{  strftime('%m-%d-%Y', time())  }}</option>
                            <option value="mm/dd/yyyy" {{ $date_picker_format == 'mm/dd/yyyy' ? ' selected="selected"' : '' }}>{{  strftime('%m/%d/%Y', time())  }}</option>
                            <option value="yyyy-mm-dd" {{ $date_picker_format == 'yyyy-mm-dd' ? ' selected="selected"' : '' }}>{{  strftime('%Y-%m-%d', time())  }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('file_max_size') @required </label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" value="{{ get_option('file_max_size') }}" name="file_max_size">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('allowed_files') </label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" value="{{ get_option('allowed_files') }}" name="allowed_files">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">Privacy Policy URL </label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" value="{{ get_option('privacy_policy_url') }}" name="privacy_policy_url">
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-lg-3 control-label">Slack Webhook URL <span data-toggle="tooltip"
                            title="Receives system alerts">@icon('regular/question-circle')</span></label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" value="{{ get_option('slack_webhook') }}" name="slack_webhook">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">Wablas Token <span data-toggle="tooltip"
                            title="API Key obtained from Wablas">@icon('regular/question-circle')</span></label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" value="{{ get_option('whatsapp_key') }}" name="whatsapp_key">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">WhatsApp Number <span data-toggle="tooltip"
                            title="Default whatsapp number">@icon('regular/question-circle')</span></label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" placeholder="+14081234567" value="{{ get_option('whatsapp_number') }}" name="whatsapp_number">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">WhatsApp Subscribe Text <span data-toggle="tooltip"
                            title="Text that users need to send to your whatsapp to subscribe. Default is SUB">@icon('regular/question-circle')</span></label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" placeholder="SUB" value="{{ get_option('whatsapp_sub_text') }}" name="whatsapp_sub_text">
                    </div>

                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('sms_driver') </label>
                    <div class="col-lg-6">
                        <select name="sms_driver" class="form-control">
                            <option value="nexmo" {{ get_option('sms_driver') == 'nexmo' ? 'selected' : '' }}>Nexmo</option>
                            <option value="twilio" {{ get_option('sms_driver') == 'twilio' ? 'selected' : '' }}>Twilio</option>
                            <option value="pinpoint" {{ get_option('sms_driver') == 'pinpoint' ? 'selected' : '' }}>AWS Pinpoint</option>
                            <option value="messagebird" {{ get_option('sms_driver') == 'messagebird' ? 'selected' : '' }}>Messagebird</option>
                            <option value="shoutout" {{ get_option('sms_driver') == 'shoutout' ? 'selected' : '' }}>ShoutOUT</option>
                        </select>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-lg-3 control-label">Open Exchange API</label>
                    <div class="col-lg-6">
                        <input type="text" name="xrates_app_id" class="form-control" placeholder="Leave blank" value="{{ get_option('xrates_app_id') }}">
                        <span class="help-block text-danger">Leave blank to use the default <a href="https://openexchangerates.org/" target="_blank">open exchange rates</a>
                            API</span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">Google Calendar API Key</label>
                    <div class="col-lg-6">
                        <input type="text" name="gcal_api_key" class="form-control" placeholder="API Key" value="{{ get_option('gcal_api_key') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">Google Calendar ID</label>
                    <div class="col-lg-6">
                        <input type="text" name="gcal_id" class="form-control" placeholder="Calendar ID" value="{{ get_option('gcal_id') }}">
                    </div>
                </div>



                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('default_role') </label>
                    <div class="col-lg-6">
                        <select name="default_role" class="form-control">
                            @foreach (Role::all() as $role)
                            <option value="{{ $role->name }}" {{ $role->name === 'client' ? 'selected="selected"' : '' }}>{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">PDF Engine</label>
                    <div class="col-lg-6">
                        <select name="pdf_engine" class="form-control">
                            <option value="mpdf" {{ get_option('pdf_engine') == 'mpdf' ? 'selected' : '' }}>Dompdf</option>
                            <option value="invoicr" {{ get_option('pdf_engine') == 'invoicr' ? 'selected' : '' }}>Invoicr</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('company_address_format')</label>
                    <div class="col-lg-6">
                        <textarea class="form-control ta" name="company_address_format">{!! get_option('company_address_format') !!}</textarea>
                    </div>

                </div>
                <p>
                    <span class="text-gray-600">{company_name}</span> |
                    <span class="text-gray-600">{street}</span> |
                    <span class="text-gray-600">{city}</span> |
                    <span class="text-gray-600">{state}</span> |
                    <span class="text-gray-600">{zip}</span> |
                    <span class="text-gray-600">{country_code}</span> |
                    <span class="text-gray-600">{country_name}</span> |
                    <span class="text-gray-600">{phone}</span> |
                    <span class="text-gray-600">{tax_number}</span>
                </p>


                <div class="line line-dashed line-lg pull-in"></div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Options</label>
                    <div class="col-sm-9">

                        <div class="row">
                            <div class="col-sm-6">


                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" value="FALSE" name="enable_signaturepad" />
                                        <input type="checkbox" name="enable_signaturepad" {{ settingEnabled('enable_signaturepad') ? 'checked' : '' }} value="TRUE">
                                        <span class="label-text" data-rel="tooltip" title="Enabled signature pad for signatures.">@langapp('enable_signaturepad')</span>
                                    </label>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" value="FALSE" name="automatic_reminders" />
                                        <input type="checkbox" name="automatic_reminders" {{ settingEnabled('automatic_reminders') ? 'checked' : '' }} value="TRUE">
                                        <span class="label-text" data-rel="tooltip"
                                            title="Send email reminders for estimates, contracts, tasks or todos when almost overdue">@langapp('automatic_reminders')</span>
                                    </label>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" value="FALSE" name="enable_languages" />
                                        <input type="checkbox" name="enable_languages" {{  settingEnabled('enable_languages') ? 'checked' : ''  }} value="TRUE">
                                        <span class="label-text">@langapp('enable_languages')</span>
                                    </label>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" value="FALSE" name="allow_client_registration" />
                                        <input type="checkbox" name="allow_client_registration" {{  settingEnabled('allow_client_registration') ? 'checked' : '' }} value="TRUE">
                                        <span class="label-text">@langapp('allow_client_registration') </span>
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" value="FALSE" name="amount_in_words" />
                                        <input type="checkbox" name="amount_in_words" {{ settingEnabled('amount_in_words') ? 'checked' : '' }} value="TRUE">
                                        <span class="label-text">@langapp('amount_in_words')</span>
                                    </label>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" value="FALSE" name="social_login" />
                                        <input type="checkbox" name="social_login" {{ settingEnabled('social_login') ? 'checked' : '' }} value="TRUE">
                                        <span class="label-text" data-rel="tooltip"
                                            title="Use Facebook, Twitter, LinkedIn, Google, GitHub and GitLab to login">@langapp('social_login') </span>
                                    </label>
                                </div>



                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" value="FALSE" name="whatsapp_enabled" />
                                        <input type="checkbox" name="whatsapp_enabled" value="TRUE" {{ settingEnabled('whatsapp_enabled') ? 'checked' : '' }}>
                                        <span class="label-text" data-rel="tooltip"
                                            title="Enable WhatApp Integration. Guide available on discuss.workice.com">@langapp('whatsapp_enabled')
                                            @icon('brands/whatsapp','text-success') </span>
                                    </label>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" value="FALSE" name="sms_active" />
                                        <input type="checkbox" name="sms_active" value="TRUE" {{ settingEnabled('sms_active') ? 'checked' : '' }}>
                                        <span class="label-text" data-rel="tooltip" title="Enable SMS Sending">@langapp('sms_active') </span>
                                    </label>
                                </div>



                            </div>
                            <div class="col-sm-6">

                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" value="FALSE" name="update_xrates" />
                                        <input type="checkbox" name="update_xrates" value="TRUE" {{ settingEnabled('update_xrates') ? 'checked' : '' }}>
                                        <span class="label-text" data-rel="tooltip"
                                            title="This action will automatically fetch daily exchange rates for foreign currencies.">@langapp('update_xrates') </span>
                                    </label>
                                </div>


                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" value="FALSE" name="use_recaptcha" />
                                        <input type="checkbox" name="use_recaptcha" {{  settingEnabled('use_recaptcha') ? 'checked' : ''  }}
                                            {{empty(config('captcha.secret')) ? 'disabled' : ''}} value="TRUE">
                                        <span class="label-text" data-rel="tooltip" title="Enable Google ReCaptcha. Instructions here docs.workice.com">@langapp('use_recaptcha')
                                        </span>
                                    </label>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" value="FALSE" name="client_create_project" />
                                        <input type="checkbox" name="client_create_project" {{  settingEnabled('client_create_project') ? 'checked' : ''  }} value="TRUE">
                                        <span class="label-text">@langapp('client_create_project') </span>
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" value="FALSE" name="stop_timer_logout" />
                                        <input type="checkbox" name="stop_timer_logout" {{ settingEnabled('stop_timer_logout') ? 'checked' : '' }} value="TRUE">
                                        <span class="label-text">@langapp('stop_timer_logout') </span>
                                    </label>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" value="FALSE" name="contract_to_project" />
                                        <input type="checkbox" name="contract_to_project" {{ settingEnabled('contract_to_project') ? 'checked' : '' }} value="TRUE">
                                        <span class="label-text" data-rel="tooltip" title="Automatically create project when contract signed">@langapp('contract_to_project')</span>
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" value="FALSE" name="updates_alert" />
                                        <input type="checkbox" name="updates_alert" {{ settingEnabled('updates_alert') ? 'checked' : '' }} value="TRUE">
                                        <span class="label-text" data-rel="tooltip" title="Notify me when there is an update available">@langapp('updates_alert')</span>
                                    </label>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" value="FALSE" name="cookie_consent" />
                                        <input type="checkbox" name="cookie_consent" {{ settingEnabled('cookie_consent') ? 'checked' : '' }} value="TRUE">
                                        <span class="label-text" data-rel="tooltip" title="Show cookie consent">@langapp('cookie_consent')</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="panel-footer">
                {!! renderAjaxButton('save') !!}
            </div>
            {!! Form::close() !!}

            @php unset($currencies) @endphp
        </section>

    </div>

</div>
@push('pagestyle')
@include('stacks.css.form')
@endpush
@push('pagescript')
@include('stacks.js.form')
@endpush