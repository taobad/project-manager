@extends('layouts.app')
@section('content')
<section id="content">
    <section class="hbox stretch">
        <section class="vbox">
            <header class="clearfix bg-white header b-b hidden-print">
                <div class="row m-t-sm">
                    <div class="col-sm-8 m-b-xs">
                        <a href="{{ route('estimates.view', $estimate->id) }}" class="btn {{themeButton()}}">
                            @icon('solid/chevron-left') @langapp('estimate')
                        </a>

                    </div>
                    <div class="col-sm-4 m-b-xs">

                    </div>
                </div>
            </header>
            <section class="scrollable wrapper bg">
                <div class="row">
                    {!! Form::open(['route' => ['estimates.api.update', $estimate->id], 'class' => 'bs-example ajaxifyForm', 'data-toggle' => 'validator', 'method' => 'PUT']) !!}
                    <div class="col-md-6">
                        <section class="panel panel-default">
                            <header class="panel-heading">@icon('solid/info-circle') @langapp('information') </header>
                            <div class="panel-body">
                                <input type="hidden" name="id" value="{{ $estimate->id}}">
                                <div class="form-group">
                                    <label>@langapp('reference_no') @required</label>
                                    <input type="text" class="form-control" value="{{ $estimate->reference_no}}" name="reference_no" readonly required>
                                </div>
                                <div class="form-group">
                                    <label class="">@langapp('title')</label>
                                    <input type="text" name="title" value="{{ $estimate->title }}" class="input-sm form-control">

                                </div>
                                <div class="form-group">
                                    <label>@langapp('client') @required </label>
                                    <select class="select2-option form-control" name="client_id">
                                        @foreach (Modules\Clients\Entities\Client::select('id','name')->get() as $client)
                                        <option value="{{ $client->id }}" {{ $client->id == $estimate->client_id ? 'selected' : '' }}>{{ $client->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if ($estimate->tax > 0)
                                <div class="form-group">
                                    <label>{{ get_option('tax1Label') }} @required</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">%</span>
                                        <input class="form-control money" type="text" value="{{ $estimate->tax}}" name="tax" required>
                                    </div>
                                </div>
                                @endif
                                @if ($estimate->tax2 > 0)
                                <div class="form-group">
                                    <label>{{ get_option('tax2Label') }} @required</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">%</span>
                                        <input class="form-control money" type="text" value="{{ $estimate->tax2}}" name="tax2" required>
                                    </div>
                                </div>
                                @endif

                                @if ($estimate->tax_per_item == 0)
                                <div class="form-group">
                                    <label>@langapp('tax_rates')</label>
                                    <select class="select2-tags form-control" name="tax_types[]" multiple>
                                        <option value="" {{ isEmptyArray($estimate->tax_types) ? 'selected' : ''}}>None</option>
                                        @foreach (App\Entities\TaxRate::all() as $tax)
                                        <option value="{{ $tax->id }}" {{ !is_null($estimate->tax_types) && in_array($tax->id, $estimate->tax_types) ? 'selected' : '' }}>
                                            {{ $tax->name }} ({{ $tax->rate }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                @endif
                                @if ($estimate->discount_per_item == 0)
                                <div class="form-group">
                                    <label>@langapp('discount') @required </label>
                                    <div class="input-group">
                                        <span class="input-group-addon"> - </span>
                                        <input class="form-control money" type="text" value="{{ $estimate->discount}}" name="discount" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>@langapp('discount_percent') </label>
                                    <select name="discount_percent" class="form-control">
                                        <option value="1" {{ $estimate->discount_percent === 1 ? 'selected="selected"' : '' }}>@langapp('percentage')</option>
                                        <option value="0" {{ $estimate->discount_percent === 0 ? 'selected="selected"' : '' }}>@langapp('amount')</option>
                                    </select>
                                </div>
                                @endif
                                <div class="form-group">
                                    <label>@langapp('currency') </label>
                                    <select name="currency" class="select2-option form-control">
                                        @foreach (currencies() as $cur)
                                        <option value="{{ $cur['code']}}" {{ $cur['code'] == $estimate->currency ? 'selected="selected"' : ''}}>{{ $cur['title']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>{{ langapp('xrate') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">-</span>
                                        <input class="form-control" type="text" value="{{ $estimate->exchange_rate }}" name="exchange_rate" required>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="col-md-6">
                        <section class="panel panel-default">
                            <header class="panel-heading">@icon('solid/pencil-alt') @langapp('terms') </header>
                            <div class="panel-body">


                                <div class="form-group">
                                    <label>@langapp('tags') </label>
                                    <select class="select2-tags form-control" name="tags[]" multiple>
                                        @foreach (App\Entities\Tag::all() as $tag)
                                        <option value="{{ $tag->name}}" {{ in_array($tag->id, array_pluck($estimate->tags->toArray(), 'id')) ? ' selected="selected"' : '' }}>
                                            {{ $tag->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>@langapp('due_date') </label>
                                    <div class="input-group">
                                        <input class="datepicker-input form-control" size="16" type="text" value="{{ datePickerFormat($estimate->due_date)}}" name="due_date"
                                            data-date-format="{{ get_option('date_picker_format') }}" data-date-start-date="moment()" required>
                                        <label class="input-group-addon btn" for="date">
                                            @icon('solid/calendar-alt', 'text-muted')
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>@langapp('notes') </label>
                                    <x-inputs.wysiwyg name="notes" class="{{ get_option('htmleditor') }}" id="{{ get_option('htmleditor') }}">
                                        {!!$estimate->notes!!}
                                    </x-inputs.wysiwyg>
                                </div>
                                <div class="form-group">
                                    <label>@langapp('attach_deal') @required </label>
                                    <select class="select2-option form-control" name="deal_id">
                                        <option value="0" selected="selected">None</option>
                                        @foreach (Modules\Deals\Entities\Deal::select('id', 'title')->open()->get() as $deal)
                                        <option value="{{ $deal->id}}" {{ $estimate->deal_id === $deal->id ? 'selected' : '' }}>{{ $deal->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mt-1 form-check">
                                    <label>
                                        <input type="hidden" name="tax_per_item" value="0">
                                        <input type="checkbox" name="tax_per_item" {{$estimate->tax_per_item == 1 ? 'checked' : ''  }} value="1">
                                        <span class="font-semibold text-gray-600 label-text" data-toggle="tooltip" title="Enable Tax Per Item">@langapp('tax_per_item')</span>
                                    </label>
                                </div>
                                <div class="mt-1 form-check">
                                    <label>
                                        <input type="hidden" name="discount_per_item" value="0">
                                        <input type="checkbox" name="discount_per_item" {{$estimate->discount_per_item == 1 ? 'checked' : ''  }} value="1">
                                        <span class="font-semibold text-gray-600 label-text" data-toggle="tooltip"
                                            title="Enable Tax Per Item">@langapp('estimate_discount_per_item')</span>
                                    </label>
                                </div>

                                <div class="mt-1 form-check">
                                    <label>
                                        <input type="hidden" name="show_shipping_on_estimate" value="0">
                                        <input type="checkbox" name="show_shipping_on_estimate" {{  $estimate->show_shipping_on_estimate == 1 ? 'checked' : ''  }} value="1">
                                        <span class="font-semibold text-gray-600 label-text" data-toggle="tooltip"
                                            title="Show shipping address">@langapp('show_shipping_address')</span>
                                    </label>
                                </div>
                                @php
                                $data['fields'] = App\Entities\CustomField::estimates()->orderBy('order', 'desc')->get();
                                @endphp
                                @include('estimates::_includes.updateCustom', $data)
                                {!! renderAjaxButton() !!}

                                {!! Form::close() !!}
                            </div>
                        </section>
                    </div>
                </div>
            </section>
        </section>
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