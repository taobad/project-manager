@extends('layouts.app')
@section('content')
<section id="content">
    <section class="hbox stretch">
        <aside>
            <section class="vbox">
                <header class="clearfix bg-white header b-b">
                    <div class="row m-t-sm">
                        <div class="col-sm-8 m-b-xs">
                            @can('clients_create')
                            <a href="{{route('clients.create')}}" class="btn {{themeButton()}}" data-toggle="ajaxModal">
                                @icon('solid/building') @langapp('new_client') </a>
                            @endcan
                        </div>
                        <div class="col-sm-4 m-b-xs">
                            @admin
                            <a href="{{route('estimates.export')}}" class="pull-right btn {{themeButton()}}">
                                @icon('solid/cloud-download-alt') CSV</a>
                            @endadmin
                            @can('estimates_create')
                            <a href="{{route('estimates.import')}}" class="pull-right btn {{themeButton()}}" data-toggle="ajaxModal">
                                @icon('solid/cloud-upload-alt') @langapp('import')
                            </a>
                            @endcan
                        </div>
                    </div>
                </header>
                <section class="scrollable wrapper bg">
                    <div class="row">
                        {!! Form::open(['route' => 'estimates.api.save', 'class' => 'bs-example ajaxifyForm', 'data-toggle' => 'validator']) !!}

                        <input type="hidden" name="is_visible" value="0">
                        <input type="hidden" name="reference_no" value="{{ generateCode('estimates') }}">
                        <input type="hidden" name="tax_per_item" value="{{ settingEnabled('show_estimate_tax') ? '1' : '0' }}">
                        <input type="hidden" name="discount_per_item" value="{{ settingEnabled('estimate_discount_per_item') ? '1' : '0' }}">

                        <div class="col-md-6">
                            <section class="panel panel-default">
                                <header class="panel-heading">@icon('solid/file-alt') @langapp('information') </header>
                                <div class="panel-body">


                                    <div class="form-group">
                                        <label class="">@langapp('title')</label>

                                        <input type="text" name="title" placeholder="Website Project Estimate" class="input-sm form-control">

                                    </div>

                                    <div class="form-group">
                                        <label>@langapp('client') @required </label>
                                        <select class="select2-option form-control" name="client_id">
                                            @foreach (Modules\Clients\Entities\Client::select(['id', 'name'])->get() as $client)
                                            <option value="{{ $client->id }}" {!! $selectClient==$client->id ? 'selected' : '' !!}>{{ $client->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>@langapp('due_date') </label>
                                        <div class="input-group">
                                            <input class="datepicker-input form-control" size="16" type="text" value="{{datePickerFormat(now()->addDays(30))}}" name="due_date"
                                                data-date-format="{{get_option('date_picker_format') }}" data-date-start-date="moment()" required>
                                            <label class="input-group-addon btn" for="date">
                                                @icon('solid/calendar-alt', 'text-muted')
                                            </label>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label>@langapp('currency') </label>
                                        <select name="currency" class="form-control select2-option">
                                            @foreach(currencies() as $cur)
                                            <option value="{{$cur['code']}}" {{ ($cur['code'] == get_option('default_currency')) ? 'selected' : '' }}>{{$cur['title'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>@langapp('discount') </label>
                                        <div class="input-group">
                                            <span class="input-group-addon">-</span>
                                            <input class="form-control money" type="text" value="0.00" name="discount" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>@langapp('discount_percent') </label>
                                        <select name="discount_percent" width="100%" class="form-control">
                                            <option value="1">Percentage</option>
                                            <option value="0">Amount</option>
                                        </select>
                                    </div>

                                </div>
                            </section>
                        </div>
                        <div class="col-md-6">
                            <section class="panel panel-default">
                                <header class="panel-heading">@langapp('terms') </header>
                                <div class="panel-body">

                                    @if (!settingEnabled('show_estimate_tax'))
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

                                    <div class="form-group">
                                        <label>@langapp('tags') </label>
                                        <select class="select2-tags form-control" name="tags[]" multiple>
                                            @foreach (App\Entities\Tag::all() as $tag)
                                            <option value="{{$tag->name}}">{{$tag->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>@langapp('notes') </label>
                                        <x-inputs.wysiwyg name="notes" class="{{ get_option('htmleditor') }}" id="{{ get_option('htmleditor') }}">
                                            {!!get_option('estimate_terms')!!}
                                        </x-inputs.wysiwyg>
                                    </div>

                                    <div class="form-group">
                                        <label>@langapp('attach_deal') @required </label>
                                        <select class="select2-option form-control" name="deal_id">
                                            <option value="0" selected>None</option>
                                            @foreach ($deals as $deal)
                                            <option value="{{$deal->id}}">{{ $deal->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mt-1 form-check">
                                        <label>
                                            <input type="hidden" name="show_shipping_on_estimate" value="0">
                                            <input type="checkbox" name="show_shipping_on_estimate" {{settingEnabled('show_shipping_on_estimate') ? 'checked' : ''  }} value="1">
                                            <span class="font-semibold text-gray-600 label-text" data-toggle="tooltip"
                                                title="Show shipping address">@langapp('show_shipping_address')</span>
                                        </label>
                                    </div>

                                    <div class="form-group">
                                        <label>
                                            <input type="checkbox" name="new_deal" value="1">
                                            <span class="font-semibold text-gray-600 label-text">Create new deal and attach estimate</span>
                                        </label>
                                    </div>

                                    @php
                                    $data['fields'] = App\Entities\CustomField::estimates()->orderBy('order', 'desc')->get();
                                    @endphp
                                    @include('partial.customfields.createNoCol', $data)

                                    <span class="pull-right">
                                        {!! renderAjaxButton() !!}
                                    </span>
                                    {!! Form::close() !!}
                                </div>
                            </section>
                        </div>
                    </div>
                </section>
            </section>
        </aside>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
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
@endpush
@endsection