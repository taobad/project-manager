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
                            <a href="{{  route('clients.create')  }}" class="btn {{themeButton()}}" data-toggle="ajaxModal" title="@langapp('new_company')  "
                                data-placement="bottom">
                                @icon('solid/building') @langapp('new_client') </a>
                            @endcan
                        </div>
                        <div class="col-sm-4 m-b-xs">
                        </div>
                    </div>
                </header>
                <section class="scrollable wrapper bg">
                    <div class="row">
                        {!! Form::open(['route' => 'credits.api.save', 'class' => 'bs-example ajaxifyForm', 'data-toggle' => 'validator']) !!}

                        <div class="col-md-6">
                            <section class="panel panel-default">
                                <header class="panel-heading">@icon('regular/file-alt') @langapp('information') </header>
                                <div class="panel-body">
                                    <input type="hidden" name="exchange_rate" value="{{ xchangeRate(get_option('default_currency')) }}">
                                    <input type="hidden" name="reference_no" value="{{ generateCode('credits') }}">
                                    <input type="hidden" name="tax" value="0">
                                    <input type="hidden" name="tax_per_item" value="{{settingEnabled('show_creditnote_tax') ? '1' : '0'}} ">


                                    <div class="form-group">
                                        <label>@langapp('client') @required</label>
                                        <select class="select2-option form-control" name="client_id" required>
                                            @foreach (Modules\Clients\Entities\Client::select('id', 'name')->get() as $client)
                                            <option value="{{ $client->id }}" {!! $selectClient==$client->id ? 'selected' : '' !!}>{{ $client->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>@langapp('date_issued')</label>
                                        <div class="input-group">
                                            <input class="datepicker-input form-control" size="16" type="text" value="{{ datePickerFormat(now()) }}" name="created_at"
                                                data-date-format="{{ get_option('date_picker_format')  }}" required>
                                            <label class="input-group-addon btn" for="date">
                                                @icon('solid/calendar-alt', 'text-muted')
                                            </label>
                                        </div>
                                    </div>

                                    @if (!settingEnabled('show_creditnote_tax'))
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
                                        <label>@langapp('currency') </label>
                                        <select class="select2-option form-control" name="currency">
                                            <option value="CL">@langapp('client_default_currency') </option>
                                            @foreach (currencies() as $cur)
                                            <option value="{{$cur['code']}}">{{$cur['title']}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>@langapp('private_notes')</label>
                                        <textarea name="notes" class="form-control" placeholder="Private notes goes here"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>@langapp('tags')</label>
                                        <select class="select2-tags form-control" name="tags[]" multiple="multiple">
                                            @foreach (App\Entities\Tag::all() as $tag)
                                            <option value="{{  $tag->name  }}">{{  ucfirst($tag->name)  }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                        </div>
                        <div class="col-md-6">
                            <section class="panel panel-default">
                                <header class="panel-heading">@langapp('notes')</header>
                                <div class="panel-body">

                                    <div class="form-group terms">
                                        <x-inputs.wysiwyg name="terms" class="{{ get_option('htmleditor') }}" id="{{ get_option('htmleditor') }}">
                                            {{ get_option('creditnote_terms')}}
                                        </x-inputs.wysiwyg>
                                    </div>

                                    <div class="mt-1 form-check">
                                        <label>
                                            <input type="hidden" name="show_shipping_on_credits" value="0">
                                            <input type="checkbox" name="show_shipping_on_credits" {{settingEnabled('show_shipping_on_credits') ? 'checked' : ''  }} value="1">
                                            <span class="font-semibold text-gray-600 label-text" data-toggle="tooltip"
                                                title="Show shipping address">@langapp('show_shipping_address')</span>
                                        </label>
                                    </div>

                                    <span class="pull-right">{!! renderAjaxButton() !!}</span>
                                </div>
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
<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
</section>
@push('pagestyle')
@include('stacks.css.form')
@include('stacks.css.datepicker')
@include('stacks.css.wysiwyg')
@endpush
@push('pagescript')
@include('stacks.js.form')
@include('stacks.js.wysiwyg')
@include('stacks.js.datepicker')
@endpush
@endsection