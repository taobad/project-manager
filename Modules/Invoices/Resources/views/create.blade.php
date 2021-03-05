@extends('layouts.app')
@section('content')
<section id="content">
    <section class="hbox stretch">
        <aside>
            <section class="vbox">
                <header class="px-2 pb-2 bg-white border-b border-gray-400 panel-heading">
                    <div class="flex justify-between text-gray-500">
                        <div>
                            @can('clients_create')
                            <a href="{{route('clients.create')}}" class="btn {{themeButton()}}" data-toggle="ajaxModal">
                                @icon('solid/building') @langapp('new_client')
                            </a>
                            @endcan
                        </div>
                    </div>
                </header>
                <section class="scrollable wrapper bg">
                    <div class="row">
                        {!! Form::open(['route' => 'invoices.api.save', 'class' => 'ajaxifyForm validator']) !!}

                        <input type="hidden" name="id" value="0">
                        <input type="hidden" name="tax_per_item" value="{{ settingEnabled('show_invoice_tax') ? '1' : '0' }}">
                        <input type="hidden" name="discount_per_item" value="{{ settingEnabled('invoice_discount_per_item') ? '1' : '0' }}">
                        <input type="hidden" name="gateways[paypal]" value="inactive">
                        <input type="hidden" name="gateways[braintree]" value="inactive">
                        <input type="hidden" name="gateways[stripe]" value="inactive">
                        <input type="hidden" name="gateways[2checkout]" value="inactive">
                        <input type="hidden" name="gateways[bitcoin]" value="inactive">
                        <input type="hidden" name="gateways[mollie]" value="inactive">
                        <input type="hidden" name="gateways[wepay]" value="inactive">
                        <div class="col-md-6 form-horizontal">
                            <section class="panel panel-default">
                                <header class="panel-heading">@langapp('information')</header>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">@langapp('reference_no') @required</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="reference_no" value="{{ generateCode('invoices') }}" class="input-sm form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">@langapp('title')</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="title" placeholder="Website Project" class="input-sm form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">@langapp('client') @required</label>
                                        <div class="col-lg-9">
                                            <select class="select2-option form-control" name="client_id" required>

                                                @foreach (Modules\Clients\Entities\Client::select('id', 'name')->get()
                                                as $client)
                                                <option value="{{  $client->id  }}" {!! $selectClient==$client->id ?
                                                    'selected="selected"' : '' !!}>{{ $client->name  }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">@langapp('date_issued')</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <input class="datepicker-input form-control" size="16" type="text" value="{{ datePickerFormat(now()) }}" name="created_at"
                                                    data-date-format="{{ get_option('date_picker_format')  }}" required>
                                                <label class="input-group-addon btn" for="date">
                                                    @icon('solid/calendar-alt', 'text-muted')
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    @if (!settingEnabled('partial_payments'))

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">@langapp('due_date')</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <input class="datepicker-input form-control" size="16" type="text"
                                                    value="{{ datePickerFormat(now()->addDays(get_option('invoices_due_after'))) }}" name="due_date"
                                                    data-date-format="{{ get_option('date_picker_format')  }}" required>
                                                <label class="input-group-addon btn" for="date">
                                                    @icon('solid/calendar-alt', 'text-muted')
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">@langapp('currency')</label>
                                        <div class="col-lg-9">
                                            <select name="currency" class="select2-option form-control">
                                                <option value="CL">@langapp('client_default_currency') </option>
                                                @foreach (currencies() as $cur)
                                                <option value="{{ $cur['code'] }}">{{ $cur['native'] }} -
                                                    {{ $cur['title'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="m-8">

                                        <div class="form-group">
                                            <label class="ml-6">@langapp('payment_methods')</label>
                                            <hr class="m-2">
                                            <div class="row">
                                                @php $counter = 0; @endphp
                                                @foreach (explode(',', get_option('enabled_gateways')) as $gateway)
                                                @if (!(($counter++) % 2))
                                            </div>
                                            <div class="px-6 row">
                                                @endif
                                                <div class="col-md-6">
                                                    <div class="mt-2 text-gray-600 form-check">
                                                        <label>
                                                            <input type="checkbox" name="gateways[{{ $gateway }}]" {!! $gateway=='braintree' ? 'id="use_braintree"' : '' !!} checked
                                                                value="active">
                                                            <span class="label-text">{{ ucfirst($gateway) }}</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div id="braintree_setup" class="display-none">
                                            <div class="form-group">
                                                <label>@langapp('braintree_merchant_account') ID</label>
                                                <input type="text" class="form-control" name="gateways[braintree_merchant_account]" value="">
                                                <span class="help-block m-b-none ">If using multi currency
                                                    <a href="https://articles.braintreepayments.com/control-panel/important-gateway-credentials#merchant-account-id-versus-merchant-id"
                                                        target="_blank" class="text-indigo-600">Read More
                                                    </a>
                                                </span>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                        </div>

                        <div class="col-md-6">
                            <section class="panel panel-default">
                                <header class="panel-heading"> @langapp('terms')</header>
                                <div class="panel-body">

                                    @if (!settingEnabled('show_invoice_tax'))

                                    <div class="form-group">
                                        <label class="">@langapp('tax_rates')</label>
                                        <select class="select2-tags form-control" name="tax_types[]" multiple>
                                            @php $currentRates = json_decode(get_option('default_tax_rates')); @endphp
                                            <option value="" {{ is_null($currentRates[0]) ? 'selected' : ''}}>None</option>
                                            @foreach (App\Entities\TaxRate::all() as $tax)
                                            <option value="{{ $tax->id }}" {{ !is_null($currentRates) && in_array($tax->id, $currentRates) ? 'selected' : '' }}>
                                                {{ $tax->name }} ({{ $tax->rate }})
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    @endif

                                    @if (settingEnabled('partial_payments'))

                                    <div class="form-group">
                                        <label for="partial-payments">@langapp('partial_payments')</label>
                                        <div class="partial-labels row m-xs">
                                            <div class="amount">
                                                <label for="partial-amount" class="partial-amount">@langapp('amount')</label>
                                            </div>
                                            <div class="due">
                                                <label for="partial-due_date" class="partial-due_date">@langapp('due_date')</label>
                                            </div>
                                            <div class="notes">
                                                <label for="partial-notes" class="partial-notes">@langapp('notes')
                                                </label>
                                            </div>
                                        </div>
                                        <div class="partial-input-container m-xs">
                                            <div class="partial-inputs row height40">
                                                <div class="percent">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">%</span>
                                                        <input class="form-control" type="number" max="100" value="100" name="partial-amount[1]" id="partial-amount" required>
                                                    </div>
                                                </div>
                                                <div class="due">
                                                    <input class="datepicker-input form-control" size="16" type="text"
                                                        value="{{ datePickerFormat(now()->addDays(get_option('invoices_due_after'))) }}" name="partial-due_date[1]"
                                                        data-date-format="{{ get_option('date_picker_format')  }}" id="partial-due_date" required>
                                                </div>
                                                <div class="notes">
                                                    <input type="text" class="form-control" value="" name="partial-notes[1]" id="partial-notes">
                                                </div>
                                                <div class="paid">
                                                    <a href="#" data-details="1" class="btn-danger btn btn-sm partial-payment-delete">
                                                        <span class="display-inline">✗</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="partial-addmore">
                                            <div class="payment-plan-amounts row">
                                                <div class="twelve columns">
                                                    <a href="#" class="btn btn-xs text-info"><span>@langapp('add_payment_schedule')
                                                        </span></a>
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                    @endif

                                    <div class="form-group">
                                        <label>@langapp('notes') </label>
                                        <x-inputs.wysiwyg name="notes" class="{{ get_option('htmleditor') }}" id="{{ get_option('htmleditor') }}">
                                            {!! get_option('default_terms') !!}
                                        </x-inputs.wysiwyg>
                                    </div>



                                    <div class="form-group">
                                        <label>@langapp('tags')</label>
                                        <select class="select2-tags form-control" name="tags[]" multiple>
                                            @foreach (App\Entities\Tag::all() as $tag)
                                            <option value="{{  $tag->name  }}">{{  $tag->name  }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mt-1 form-check">
                                        <label>
                                            <input type="hidden" name="show_shipping_on_invoice" value="0">
                                            <input type="checkbox" name="show_shipping_on_invoice" {{settingEnabled('show_shipping_on_invoice') ? 'checked' : ''  }} value="1">
                                            <span class="font-semibold text-gray-600 label-text" data-toggle="tooltip"
                                                title="Show shipping address">@langapp('show_shipping_address')</span>
                                        </label>
                                    </div>

                                    @php
                                    $data['fields'] = App\Entities\CustomField::invoices()->orderBy('order',
                                    'desc')->get();
                                    @endphp
                                    @include('partial.customfields.createNoCol', $data)
                                    <span class="pull-right">
                                        {!! renderAjaxButton() !!}
                                    </span>
                                    {!! Form::close() !!}
                                </div>
                            </section>
                        </div>
                </section>
                </div>
            </section>
    </section>
    </aside>
</section>
<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav">

</a>
</section>
@push('pagestyle')
@include('stacks.css.datepicker')
@include('stacks.css.form')
@include('stacks.css.wysiwyg')
@endpush
@push('pagescript')
@include('stacks.js.datepicker')
@include('stacks.js.form')
@include('stacks.js.wysiwyg')
<script src="{{ getAsset('plugins/apps/payment_schedule.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function () {
    $('#use_braintree').change(function() {
    if($(this).is(":checked")) {
        $("#braintree_setup").show("fast");
    $(this).attr("checked");
    }else{
        $("#braintree_setup").hide("fast");
    }
}).change();
});
</script>
@endpush
@endsection