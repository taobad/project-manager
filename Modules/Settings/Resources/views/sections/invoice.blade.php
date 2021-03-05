<div class="row">

    <div class="col-lg-12">

        {!! Form::open(['route' => ['settings.edit', $section], 'class' => 'bs-example form-horizontal ajaxifyForm',
        'files' => true]) !!}

        <section class="panel panel-default">
            <header class="panel-heading">@icon('solid/cogs') @langapp('invoice_settings') </header>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('invoice_color') @required</label>
                    <div class="col-lg-6">
                        <input type="text" name="invoice_color" class="form-control" value="{{  get_option('invoice_color')  }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('creditnote_color') @required</label>
                    <div class="col-lg-6">
                        <input type="text" name="creditnote_color" class="form-control" value="{{  get_option('creditnote_color')  }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('invoice_prefix')</label>
                    <div class="col-lg-6">
                        <input type="text" name="invoice_prefix" class="form-control" value="{{  get_option('invoice_prefix')  }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('creditnote_prefix')</label>
                    <div class="col-lg-6">
                        <input type="text" name="creditnote_prefix" class="form-control" value="{{  get_option('creditnote_prefix')  }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('invoice_number_format')</label>
                    <div class="col-lg-6">
                        <input type="text" name="invoice_number_format" class="form-control" value="{{ get_option('invoice_number_format') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('ref_digits')
                        <span class="" data-toggle="tooltip" title="Number of digits for Invoice Reference Number. Between 1 and 9">@icon('solid/question-circle')</span>
                    </label>
                    <div class="col-lg-6">
                        <input type="number" min="1" max="9" name="ref_digits" class="form-control" value="{{ get_option('ref_digits', 4) }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('creditnote_number_format')</label>
                    <div class="col-lg-6">
                        <input type="text" name="creditnote_number_format" class="form-control" value="{{  get_option('creditnote_number_format')  }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('invoices_due_after') @required</label>
                    <div class="col-lg-6">
                        <input type="text" name="invoices_due_after" class="form-control" data-toggle="tooltip" data-placement="top"
                            data-original-title="Default number of days before an invoice is overdue" value="{{  get_option('invoices_due_after')  }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('remind_invoices_before') @required</label>
                    <div class="col-lg-6">
                        <input type="text" name="remind_invoices_before" class="form-control" data-toggle="tooltip" data-placement="top"
                            data-original-title="Default number of days to remind clients before an invoice is overdue" value="{{ get_option('remind_invoices_before') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('reminder') 1
                        <span class="" data-toggle="tooltip" title="Sends a standard overdue reminder. Default 1 day overdue">@icon('solid/question-circle')</span>
                    </label>
                    <div class="col-lg-6">
                        <input type="text" name="invoices_overdue_reminder1" class="form-control" data-toggle="tooltip" data-placement="top" title="@langapp('days')"
                            value="{{  get_option('invoices_overdue_reminder1')  }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('reminder') 2
                        <span class="" data-toggle="tooltip" title="Warns of overdue charges being added. Default 5 days overdue">@icon('solid/question-circle')</span>
                    </label>
                    <div class="col-lg-6">
                        <input type="text" name="invoices_overdue_reminder2" class="form-control" data-toggle="tooltip" data-placement="top" title="@langapp('days')"
                            value="{{  get_option('invoices_overdue_reminder2')  }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('reminder') 3
                        <span class="" data-toggle="tooltip" title="Adds X% late payment fee. Default 10 days overdue">@icon('solid/question-circle')</span>
                    </label>
                    <div class="col-lg-6">
                        <input type="text" name="invoices_overdue_reminder3" class="form-control" data-toggle="tooltip" data-placement="top" title="@langapp('days')"
                            value="{{  get_option('invoices_overdue_reminder3')  }}" required>

                        <div class="checkbox">
                            <label>
                                <input type="hidden" value="FALSE" name="final_reminder_late_fee" />
                                <input type="checkbox" name="final_reminder_late_fee" {{  settingEnabled('final_reminder_late_fee') ? 'checked' : '' }} value="TRUE">
                                <span class="label-text" data-toggle="tooltip"
                                    title="Apply late fees to Invoices after 3rd overdue reminder.">@langapp('final_reminder_late_fee')</span>
                            </label>
                        </div>
                    </div>


                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('late_fee') @required</label>
                    <div class="col-lg-6">
                        <input type="text" name="late_fee" class="form-control" data-toggle="tooltip" data-placement="top" title="Invoice default late fee. Default 10%"
                            value="{{  get_option('late_fee')  }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('invoice_start_number')
                        <span data-toggle="tooltip" title="Invoice numbers should start from this number">@icon('solid/question-circle')</span>
                    </label>
                    <div class="col-lg-6">
                        <input type="text" name="invoice_start_no" class="form-control" value="{{  get_option('invoice_start_no')  }}">
                    </div>
                </div>

                @if (settingEnabled('dynamic_units'))
                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('custom_item_unit')
                        <span class="" data-toggle="tooltip" title="Items displayed with custom units e.g kg,oz,hour">@icon('solid/question-circle')</span>
                    </label>
                    <div class="col-lg-6">
                        <input type="text" name="custom_item_unit" class="form-control" value="{{  get_option('custom_item_unit') }}">
                    </div>
                </div>
                @endif


                <div class="form-group">
                    <label class="col-lg-3 control-label"></label>
                    <div class="col-sm-9">

                        <div class="row">
                            <div class="col-sm-6">

                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" value="FALSE" name="autoremind_invoices" />
                                        <input type="checkbox" name="autoremind_invoices" {{ settingEnabled('autoremind_invoices')  ? 'checked' : ''  }} value="TRUE">
                                        <span class="label-text" data-toggle="tooltip"
                                            title="Automatically send invoice reminders to clients">@langapp('autoremind_invoices')</span>
                                    </label>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" value="FALSE" name="swap_to_from" />
                                        <input type="checkbox" name="swap_to_from" {{ settingEnabled('swap_to_from')  ? 'checked' : ''  }} value="TRUE">
                                        <span class="label-text">@langapp('swap_to_from_side')</span>
                                    </label>
                                </div>


                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" value="FALSE" name="display_invoice_badge" />
                                        <input type="checkbox" name="display_invoice_badge" {{ settingEnabled('display_invoice_badge') ? 'checked' : '' }} value="TRUE">
                                        <span class="label-text">@langapp('display_invoice_badge')</span>
                                    </label>
                                </div>


                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" value="FALSE" name="increment_invoice_number" />
                                        <input type="checkbox" name="increment_invoice_number" {{ settingEnabled('increment_invoice_number') ? 'checked' : '' }} value="TRUE">
                                        <span class="label-text" data-toggle="tooltip" title="Keep incrementing invoice numbers">@langapp('increment_invoice_number')</span>
                                    </label>
                                </div>


                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" value="FALSE" name="automatic_email_on_recur" />
                                        <input type="checkbox" name="automatic_email_on_recur" {{ settingEnabled('automatic_email_on_recur') ? 'checked' : '' }} value="TRUE">
                                        <span class="label-text" data-toggle="tooltip"
                                            title="Automatically email recurring invoices when they are created.">@langapp('automatic_email_on_recur')</span>
                                    </label>
                                </div>


                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" value="FALSE" name="send_thank_you_email" />
                                        <input type="checkbox" name="send_thank_you_email" {{ settingEnabled('send_thank_you_email') ? 'checked' : '' }} value="TRUE">
                                        <span class="label-text" data-toggle="tooltip"
                                            title="Enable to send thank you emails to client when payment is received">@langapp('send_thank_you_email')
                                        </span>
                                    </label>
                                </div>


                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" value="FALSE" name="show_shipping_on_invoice" />
                                        <input type="checkbox" name="show_shipping_on_invoice" {{ settingEnabled('show_shipping_on_invoice') ? 'checked' : ''  }} value="TRUE">
                                        <span class="label-text" data-toggle="tooltip" title="Show shipping address on invoices">@langapp('invoices') -
                                            @langapp('show_shipping_address') </span>
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" value="FALSE" name="show_shipping_on_credits" />
                                        <input type="checkbox" name="show_shipping_on_credits" {{ settingEnabled('show_shipping_on_credits') ? 'checked' : ''  }} value="TRUE">
                                        <span class="label-text" data-toggle="tooltip" title="Show shipping address on creditnotes">@langapp('creditnotes') -
                                            @langapp('show_shipping_address') </span>
                                    </label>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" value="FALSE" name="invoice_discount_per_item" />
                                        <input type="checkbox" name="invoice_discount_per_item" {{ settingEnabled('invoice_discount_per_item') ? 'checked="checked"' : '' }}
                                            value="TRUE">
                                        <span class="label-text" data-toggle="tooltip" title="Enable invoice discounts per item">@langapp('invoice_discount_per_item')</span>
                                    </label>
                                </div>


                            </div>
                            <div class="col-sm-6">


                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" value="FALSE" name="show_invoice_tax" />
                                        <input type="checkbox" name="show_invoice_tax" {{ settingEnabled('show_invoice_tax') ? 'checked' : ''  }} value="TRUE">
                                        <span class="label-text" data-toggle="tooltip" title="Enable invoice tax per item">@langapp('show_item_tax') </span>
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" value="FALSE" name="show_invoice_sign" />
                                        <input type="checkbox" name="show_invoice_sign" {{ settingEnabled('show_invoice_sign') ? 'checked' : ''  }} value="TRUE">
                                        <span class="label-text" data-toggle="tooltip" title="Show authorized signature on Invoices">@langapp('invoice_signature') </span>
                                    </label>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" value="FALSE" name="show_creditnote_tax" />
                                        <input type="checkbox" name="show_creditnote_tax" {{ settingEnabled('show_creditnote_tax') ? 'checked="checked"' : ''  }} value="TRUE">
                                        <span class="label-text" data-toggle="tooltip" title="Enable creditnotes tax per item">@langapp('creditnote_tax')</span>
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" value="FALSE" name="show_creditnote_sign" />
                                        <input type="checkbox" name="show_creditnote_sign" {{ settingEnabled('show_creditnote_sign') ? 'checked' : ''  }} value="TRUE">
                                        <span class="label-text" data-toggle="tooltip" title="Show authorized signature on Credit Notes">@langapp('creditnote_signature')</span>
                                    </label>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" value="FALSE" name="archive_invoice" />
                                        <input type="checkbox" name="archive_invoice" {{  settingEnabled('archive_invoice') ? 'checked="checked"' : ''  }} value="TRUE">
                                        <span class="label-text" data-toggle="tooltip" title="Automatically archive invoices when they are paid.">@langapp('archive_invoice')</span>
                                    </label>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" value="FALSE" name="apply_credits" />
                                        <input type="checkbox" name="apply_credits" {{  settingEnabled('apply_credits') ? 'checked="checked"' : ''  }} value="TRUE">
                                        <span class="label-text" data-toggle="tooltip"
                                            title="Recurring invoices automatically apply client credit as payment.">@langapp('apply_credits')</span>
                                    </label>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" value="FALSE" name="dynamic_units" />
                                        <input type="checkbox" name="dynamic_units" {{  settingEnabled('dynamic_units') ? 'checked="checked"' : ''  }} value="TRUE">
                                        <span class="label-text" data-toggle="tooltip"
                                            title="Use custom units e.g month, years, oi, fl, oz, kilogram for items">@langapp('dynamic_units')</span>
                                    </label>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" value="FALSE" name="partial_payments" />
                                        <input type="checkbox" name="partial_payments" {{ settingEnabled('partial_payments') ? 'checked="checked"' : '' }} value="TRUE">
                                        <span class="label-text" data-toggle="tooltip" title="Enable partial payments for Invoices">@langapp('partial_payments')</span>
                                    </label>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" value="FALSE" name="show_tax_number" />
                                        <input type="checkbox" name="show_tax_number" {{ settingEnabled('show_tax_number') ? 'checked="checked"' : '' }} value="TRUE">
                                        <span class="label-text" data-toggle="tooltip" title="Show Tax Number on PDFs">@langapp('show_tax_number')</span>
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" value="FALSE" name="bank_on_invoice_pdf" />
                                        <input type="checkbox" name="bank_on_invoice_pdf" {{ settingEnabled('bank_on_invoice_pdf') ? 'checked="checked"' : '' }} value="TRUE">
                                        <span class="label-text" data-toggle="tooltip" title="Will display bank information on invoices where Bank Payment method is enabled">
                                            Bank Info on PDFs
                                        </span>
                                    </label>
                                </div>



                            </div>

                        </div>
                    </div>
                </div>





                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('invoice_logo') </label>
                    <div class="col-lg-9">
                        <div class="row">
                            <div class="col-lg-12">
                                <input type="file" name="invoice_logo">
                            </div>
                        </div>
                        @if (get_option('invoice_logo') != '')
                        <div class="row">
                            <div class="col-lg-6">
                                <div id="invoice-logo-slider"></div>
                            </div>
                            <div class="col-lg-6">
                                <div id="invoice-logo-dimensions">{{  get_option('invoice_logo_height')  }}px
                                    x {{  get_option('invoice_logo_width')  }}px
                                </div>
                            </div>
                        </div>
                        <input id="invoice-logo-height" type="hidden" value="{{ get_option('invoice_logo_height') }}" name="invoice_logo_height" />
                        <input id="invoice-logo-width" type="hidden" value="{{ get_option('invoice_logo_width') }}" name="invoice_logo_width" />
                        <div class="row invoice-logo">
                            <div class="col-lg-12">
                                <div class="invoice_image" style="height: {{ get_option('invoice_logo_height')  }}px">
                                    <img src="{{ getStorageUrl(config('system.media_dir').'/'.get_option('invoice_logo')) }}" />
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="form-group terms">
                    <label class="col-lg-3 control-label">@langapp('invoice_footer') </label>
                    <div class="col-lg-9">
                        <x-inputs.wysiwyg name="invoice_footer" class="{{ get_option('htmleditor') }}" id="invoice_footer">
                            {!!get_option('invoice_footer')!!}
                        </x-inputs.wysiwyg>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('creditnote_footer') </label>
                    <div class="col-lg-9">
                        <x-inputs.wysiwyg name="creditnote_footer" class="{{ get_option('htmleditor') }}" id="creditnote_footer">
                            {!!get_option('creditnote_footer')!!}
                        </x-inputs.wysiwyg>
                    </div>
                </div>

                <div class="form-group terms">
                    <label class="col-lg-3 control-label">@langapp('default_terms') </label>
                    <div class="col-lg-9">
                        <x-inputs.wysiwyg name="default_terms" class="{{ get_option('htmleditor') }}" id="default_terms">
                            {!!get_option('default_terms')!!}
                        </x-inputs.wysiwyg>
                    </div>
                </div>
                <div class="form-group terms">
                    <label class="col-lg-3 control-label">{{ langapp('creditnote_terms') }}</label>
                    <div class="col-lg-9">
                        <x-inputs.wysiwyg name="estimate_terms" class="{{ get_option('htmleditor') }}" id="creditnote_terms">
                            {!!get_option('creditnote_terms')!!}
                        </x-inputs.wysiwyg>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                {!! renderAjaxButton() !!}
            </div>
        </section>
        {!! Form::close() !!}
    </div>
</div>

@push('pagestyle')
@include('stacks.css.nouislider')
@include('stacks.css.wysiwyg')
@endpush
@push('pagescript')
@include('stacks.js.nouislider')
@include('stacks.js.wysiwyg')
@endpush