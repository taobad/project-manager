@extends('layouts.app')
@section('content')
<section id="content">
    <section class="hbox stretch">
        <aside>
            <section class="vbox">
                <header class="clearfix bg-white header b-b">
                    <div class="mt-2 row">
                        <div class="col-sm-8 m-b-xs">
                            <a href="{{ route('creditnotes.view', $creditnote->id) }}" title="Back to Credit Note" data-rel="tooltip" data-placement="bottom"
                                class="btn {{themeButton()}}">
                                @icon('regular/file-alt') @langapp('credit_note')
                            </a>
                        </div>
                        <div class="col-sm-4 m-b-xs">
                        </div>
                    </div>
                </header>
                <section class="scrollable wrapper bg">
                    <div class="row">
                        {!! Form::open(['route' => ['credits.api.update', $creditnote->id], 'class' => 'bs-example ajaxifyForm', 'data-toggle' => 'validator', 'method' => 'PUT'])
                        !!}

                        <div class="col-md-6 form-horizontal">
                            <section class="panel panel-default">
                                <header class="panel-heading">@icon('solid/pencil-alt')
                                    @langapp('edit') #{{ $creditnote->reference_no }}
                                </header>
                                <div class="panel-body">
                                    <input type="hidden" name="id" value="{{  $creditnote->id  }}">
                                    @if ($creditnote->used)
                                    <input type="hidden" name="client_id" value="{{  $creditnote->client_id  }}">
                                    @endif
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">@langapp('reference_no') @required</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" value="{{  $creditnote->reference_no  }}" name="reference_no" readonly required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">@langapp('client') </label>
                                        <div class="col-md-9">
                                            <select class="select2-option form-control" {{$creditnote->used ? 'disabled' : ''}} name="client_id">
                                                @if ($creditnote->used)
                                                <option value="{{ $creditnote->client_id }}" selected="selected">
                                                    {{ $creditnote->company->name }}
                                                </option>
                                                @else
                                                @foreach (classByName('clients')->select('id', 'name')->get() as $client)
                                                <option value="{{  $client->id  }}" {{ $creditnote->client_id == $client->id ? 'selected="selected"' : '' }}>
                                                    {{ $client->name }}
                                                </option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">@langapp('date_issued')</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <input class="datepicker-input form-control" size="16" type="text" value="{{  datePickerFormat($creditnote->created_at) }}"
                                                    name="created_at" data-date-format="{{ get_option('date_picker_format') }}" required>
                                                <label class="input-group-addon btn" for="date">
                                                    @icon('solid/calendar-alt', 'text-muted')
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($creditnote->tax > 0)
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">@langapp('tax')</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <span class="input-group-addon">%</span>
                                                <input class="form-control money" type="text" value="{{  $creditnote->tax  }}" name="tax">
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">@langapp('currency') </label>
                                        <div class="col-md-9">
                                            <select name="currency" class="select2-option width100">
                                                @foreach (currencies() as $cur)
                                                <option value="{{  $cur['code']  }}" {{  $creditnote->currency == $cur['code'] ? ' selected="selected"' : '' }}>{{ $cur['title'] }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">{{ langapp('xrate') }}</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <span class="input-group-addon">-</span>
                                                <input class="form-control" type="text" value="{{ $creditnote->exchange_rate }}" name="exchange_rate" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">@langapp('status') </label>
                                        <div class="col-md-9">
                                            <select name="status" class="form-control">
                                                <option value="open" {{ $creditnote->status == 'open' ? ' selected' : '' }}>
                                                    Open
                                                </option>
                                                <option value="closed" {{ $creditnote->status == 'closed' ? ' selected' : '' }}>
                                                    Closed
                                                </option>
                                                <option value="void" {{ $creditnote->status == 'void' ? ' selected' : '' }}>
                                                    Void
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">@langapp('private_notes')</label>
                                        <div class="col-md-9">
                                            <textarea name="notes" class="form-control">{{ $creditnote->notes }}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">@langapp('tags') </label>
                                        <div class="col-md-9">
                                            <select class="select2-tags form-control" name="tags[]" multiple="multiple">
                                                @foreach (App\Entities\Tag::all() as $tag)
                                                <option value="{{ $tag->name }}"
                                                    {{  in_array($tag->id, array_pluck($creditnote->tags->toArray(), 'id')) ? ' selected="selected"' : '' }}>{{ $tag->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <div class="col-md-6">
                            <section class="panel panel-default">
                                <header class="panel-heading">@icon('solid/gavel') @langapp('terms')</header>
                                <div class="panel-body">

                                    <div class="form-group">
                                        <x-inputs.wysiwyg name="terms" class="{{ get_option('htmleditor') }}" id="{{ get_option('htmleditor') }}">
                                            {{ $creditnote->terms}}
                                        </x-inputs.wysiwyg>
                                    </div>

                                    @if ($creditnote->tax_per_item == 0)
                                    <div class="form-group">
                                        <label>@langapp('tax_rates')</label>
                                        <select class="select2-tags form-control" name="tax_types[]" multiple>
                                            <option value="" {{ isEmptyArray($creditnote->tax_types) ? 'selected' : ''}}>None</option>
                                            @foreach (App\Entities\TaxRate::all() as $tax)
                                            <option value="{{ $tax->id }}" {{ !is_null($creditnote->tax_types) && in_array($tax->id, $creditnote->tax_types) ? 'selected' : '' }}>
                                                {{ $tax->name }} ({{ $tax->rate }})
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    @endif

                                    <hr>
                                    <div class="mt-1 form-check">
                                        <label>
                                            <input type="hidden" name="show_shipping_on_credits" value="0">
                                            <input type="checkbox" name="show_shipping_on_credits" {{ $creditnote->show_shipping_on_credits == 1 ? 'checked' : ''  }} value="1">
                                            <span class="font-semibold text-gray-600 label-text" data-toggle="tooltip"
                                                title="Show shipping address">@langapp('show_shipping_address')</span>
                                        </label>
                                    </div>
                                    <div class="mt-1 text-gray-600 form-check">
                                        <label>
                                            <input type="hidden" name="tax_per_item" value="0">
                                            <input type="checkbox" name="tax_per_item" {{$creditnote->tax_per_item == 1 ? 'checked' : ''  }} value="1">
                                            <span class="font-semibold text-gray-600 label-text" data-toggle="tooltip" title="Enable Tax Per Item">@langapp('tax_per_item')</span>
                                        </label>
                                    </div>
                                    <span class="pull-right">{!! renderAjaxButton() !!}</span>
                                </div>
                            </section>
                        </div>
                        {!! Form::close() !!}
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