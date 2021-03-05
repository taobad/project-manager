@extends('layouts.app')

@section('content')

<section id="content">

    <section class="hbox stretch">
        <aside>
            <section class="vbox">
                <header class="px-2 pb-2 bg-white border-b border-gray-400 panel-heading">

                    <div class="flex justify-between text-gray-500">

                        <div>
                            @can('estimates_send')
                            <a data-toggle="ajaxModal" class="btn {{themeButton()}}" href="{{ route('estimates.send', $estimate->id) }}">
                                @icon('solid/envelope-open-text') @langapp('send')
                            </a>
                            @endif
                            @can('invoices_create')
                            @if($estimate->status === 'Accepted' && is_null($estimate->invoiced_at))
                            <a class="btn {{themeButton()}} {{ ($estimate->client_id == '0') ? 'disabled' : '' }}" data-rel="tooltip" data-placement="bottom"
                                data-toggle="ajaxModal" href="{{ route('estimates.convert', $estimate->id) }}" title="@langapp('convert_to_invoice')">
                                @icon('solid/file-invoice-dollar')
                            </a>
                            @endif
                            @endcan
                            @can('estimates_update')
                            @if ($estimate->is_visible)
                            <a class="btn {{themeButton()}}" data-placement="bottom" data-title="@langapp('hide_to_client')" data-toggle="tooltip"
                                href="{{ route('estimates.hide', $estimate->id) }}">
                                @icon('solid/eye-slash')
                            </a>
                            @else
                            <a class="btn {{themeButton()}}" data-placement="bottom" data-title="@langapp('show_to_client')" data-toggle="tooltip"
                                href="{{route('estimates.show', $estimate->id)}}">
                                @icon('solid/eye')
                            </a>
                            @endif
                            @endcan


                            @can('reminders_create')
                            <a class="btn {{themeButton()}}" data-toggle="ajaxModal" data-rel="tooltip" data-placement="bottom"
                                href="{{ route('calendar.reminder', ['module' => 'estimates', 'id' => $estimate->id])}}" title="@langapp('set_reminder')">
                                @icon('solid/clock')
                            </a>
                            @endcan


                            @if ($estimate->client_id != \Auth::user()->profile->company)
                            <div class="btn-group">
                                <button class="{{themeButton()}} dropdown-toggle" data-toggle="dropdown">
                                    @langapp('more_actions')
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    @can('estimates_update')
                                    <li>
                                        <a href="{{ route('estimates.edit', $estimate->id) }}">
                                            @langapp('edit')
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('items.insert', ['id' => $estimate->id, 'module' => 'estimates'])  }}" data-toggle="ajaxModal" data-rel="tooltip"
                                            data-placement="bottom" title="From Templates">
                                            @langapp('items')
                                        </a>
                                    </li>
                                    @endcan
                                    @can('estimates_create')
                                    <li>
                                        <a href="{{ route('estimates.duplicate', $estimate->id) }}" data-toggle="ajaxModal">
                                            @langapp('copy')
                                        </a>
                                    </li>
                                    @endcan
                                    @if ($estimate->status != 'Declined')
                                    <li>
                                        <a data-toggle="ajaxModal" href="{{ route('estimates.declined', $estimate->id) }}">
                                            @langapp('mark_as_declined')
                                        </a>
                                    </li>
                                    @endif
                                    @if ($estimate->status != 'Accepted')
                                    <li>
                                        <a href="{{ route('estimates.accepted', $estimate->id) }}" {!! settingEnabled('estimate_to_project')
                                            ? 'title="A new project will be created" data-toggle="tooltip"' : '' !!}>
                                            @langapp('mark_as_accepted')
                                        </a>
                                    </li>
                                    @endif

                                    @if ($estimate->status == 'Accepted')
                                    <li>
                                        <a href="{{route('estimates.project', $estimate->id)}}" data-toggle="ajaxModal" title="Convert estimate to project" data-toggle="tooltip">
                                            @langapp('convert_to_project')
                                        </a>
                                    </li>
                                    @endif

                                    @can('estimates_delete')
                                    <li class="divider">
                                    </li>
                                    <li>
                                        <a data-toggle="ajaxModal" href="{{ route('estimates.delete', $estimate->id) }}">
                                            @langapp('delete')
                                        </a>
                                    </li>
                                    @endcan
                                </ul>
                            </div>
                            @else
                            <a class="btn {{themeButton('text-green-600')}}" href="{{ route('estimates.accepted', $estimate->id) }}">
                                @langapp('mark_as_accepted')
                            </a>
                            <a class="btn {{themeButton('text-red-600')}}" href="{{ route('estimates.declined', $estimate->id) }}" data-toggle="ajaxModal">
                                @langapp('mark_as_declined')
                            </a>
                            @endif
                        </div>

                        <div>
                            @can('estimates_update')
                            <a class="btn {{themeButton()}}" data-placement="bottom" data-rel="tooltip" data-toggle="ajaxModal" href="{{ route('estimates.share', $estimate->id) }}"
                                title="Share Estimate">
                                @icon('solid/share-alt')
                            </a>
                            @endcan

                            <a class="btn {{themeButton()}}" href="{{route('estimates.pdf', $estimate->id)}}">
                                @icon('solid/file-pdf') PDF
                            </a>
                            <a href="#aside-files" data-toggle="class:show" class="btn {{themeButton()}}">
                                @icon('regular/folder-open')
                            </a>
                        </div>
                    </div>
                </header>
                <section class="p-4 bg-gray-300 scrollable ie-details">


                    <div class="p-4 bg-white rounded-sm col-md-12">

                        <div class="ribbon {{$estimate->ribbonColor()}}"><span>{{$estimate->status}}</span></div>

                        @if (strtotime($estimate->due_date) < time() && $estimate->getRawOriginal('status') ==
                            'Pending')
                            <div class="mb-2 bg-indigo-100 border-indigo-600 alert">
                                <button class="close" data-dismiss="alert" type="button">×</button>
                                @icon('solid/calendar-times','text-indigo-600') @langapp('estimate_overdue')
                            </div>
                            @endif
                            @if(!is_null($estimate->invoiced_at))
                            <div class="mb-2 bg-teal-100 border-teal-500 alert">
                                <button class="close" data-dismiss="alert" type="button">×</button>
                                @icon('solid/check-circle', 'text-teal-600')
                                Estimate {{ $estimate->reference_no }} has been
                                <a href="{{ route('invoices.view', $estimate->invoiced_id) }}">
                                    Invoiced.
                                </a>
                            </div>
                            @endif
                            <div class="mt-4 row">
                                <div class="col-md-6 col-xs-12">
                                    <div style="height: {{ get_option('invoice_logo_height') }}px">
                                        <img class="ie-logo img-responsive" src="{{ getStorageUrl(config('system.media_dir').'/'.get_option('invoice_logo')) }}">
                                    </div>
                                </div>
                                <div class="text-right text-gray-600 col-md-6 col-xs-12">
                                    <span class="text-3xl font-semibold">
                                        {{ $estimate->reference_no }}
                                    </span>
                                    <span class="text-gray-600">
                                        {!! $estimate->isDraft() ? '<span class="label label-danger">Draft</span>' :
                                        '' !!}
                                    </span>
                                    <div class="py-1">
                                        @langapp('estimate_date')
                                        <span class="col-xs-4 no-gutter-right pull-right">
                                            <strong>
                                                {{ dateString($estimate->created_at) }}
                                            </strong>
                                        </span>
                                    </div>
                                    <div class="py-1">
                                        @langapp('expiry_date')
                                        <span class="col-xs-4 no-gutter-right pull-right">
                                            <strong>
                                                {{ dateString($estimate->due_date) }}
                                            </strong>
                                        </span>
                                    </div>
                                    <div class="py-1">
                                        @langapp('status')
                                        <span class="col-xs-4 no-gutter-right pull-right">
                                            <span class="{{themeBg()}} label">
                                                {{ $estimate->status }}
                                            </span>
                                        </span>
                                    </div>
                                    @if($estimate->getRawOriginal('status') == 'Declined')
                                    <div class="py-1">
                                        @langapp('decline')
                                        <span class="col-xs-4 no-gutter-right pull-right">
                                            <span class="text-red-700">
                                                {{ dateTimeFormatted($estimate->rejected_time) }}
                                            </span>
                                        </span>
                                    </div>
                                    @endif
                                    @if($estimate->currency != 'USD')
                                    <div class="py-1">
                                        @langapp('xrate')
                                        <span class="col-xs-4 no-gutter-right pull-right">
                                            <strong>
                                                1 USD = {{ $estimate->currency }} {{ $estimate->exchange_rate }}
                                            </strong>
                                        </span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            @php
                            $data['company'] = $estimate->company;
                            $address_span = $estimate->show_shipping_on_estimate == 1 ? 4 : 6;
                            @endphp
                            <div class="p-4 mt-2 mb-3 bg-gray-100 border rounded-lg">
                                <div class="row">
                                    @if (get_option('swap_to_from') == 'FALSE')
                                    <div class="col-xs-{{$address_span}}">
                                        <strong>@langapp('received_from'):</strong>
                                        <address>
                                            {!! formatCompanyAddress($data) !!}
                                        </address>
                                        @if(get_option('contact_person'))
                                        <address>
                                            <strong>@langapp('contact_person') </strong><br>
                                            <a class="text-indigo-600" href="mailto:{{ get_option('company_email') }}">{{ get_option('contact_person') }}</a>
                                        </address>
                                        @endif
                                    </div>
                                    @endif
                                    {{-- / SWAP FROM ADDRESS --}}

                                    <div class="col-xs-{{$address_span}}">
                                        <strong>@langapp('bill_to'):</strong>
                                        <div class="pmd-card-body">
                                            <address>
                                                {!! formatClientAddress($estimate, 'estimate', 'billing', true) !!}
                                            </address>
                                            @if($estimate->company->primary_contact)
                                            <address>
                                                <strong>@langapp('contact_person') </strong><br>
                                                <a class="text-indigo-600" href="mailto:{{ $estimate->company->contact->email }}">{{ $estimate->company->contact->name }}</a>
                                            </address>
                                            @endif
                                        </div>
                                    </div>
                                    @if (get_option('swap_to_from') == 'TRUE')
                                    <div class="col-xs-{{$address_span}}">
                                        <strong>@langapp('received_from'):</strong>
                                        <address>
                                            {!! formatCompanyAddress($data) !!}
                                        </address>
                                        @if(get_option('contact_person'))
                                        <address>
                                            <strong>@langapp('contact_person') </strong><br>
                                            <a class="text-indigo-600" href="mailto:{{ get_option('company_email') }}">{{ get_option('contact_person') }}</a>
                                        </address>
                                        @endif
                                    </div>
                                    @endif
                                    @if($estimate->show_shipping_on_estimate == 1)
                                    <div class="col-xs-{{$address_span}}">
                                        <strong>Ship To:</strong>
                                        <address>
                                            {!! formatClientAddress($estimate, 'estimate', 'shipping') !!}
                                        </address>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            @php
                            $showtax = $estimate->tax_per_item == 1 ? true :false;
                            $showDiscount = $estimate->discount_per_item == 1 ? true :false;
                            @endphp
                            <div class="line"></div>
                            <div class="table-responsive">

                                {!! Form::open(['url' => '#', 'class' => 'bs-example form-horizontal', 'id' =>
                                'saveItem']) !!}
                                <table class="table sorted_table small" id="est-details" type="estimates">
                                    <thead>
                                        <tr class="uppercase bg-indigo-100">
                                            <th></th>
                                            <th style="width:20%">@langapp('product')</th>
                                            <th style="width:25%" class="hidden-xs">@langapp('description')</th>
                                            <th style="width:8%" class="text-right">@langapp('qty')</th>
                                            @if ($showtax)
                                            <th style="width:15%" class="text-right">@langapp('tax_rate')</th>
                                            @endif
                                            <th class="text-right">{{ itemUnit() }}</th>
                                            @if ($showDiscount)
                                            <th style="width:10%" class="text-right">@langapp('disc')</th>
                                            @endif
                                            <th style="width:10%" class="text-right">@langapp('total')</th>
                                            <th class="text-right inv-actions"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($estimate->items as $key => $item)
                                        <tr class="sortable" data-id="{{  $item->id  }}" data-name="{{  $item->name  }}" id="item-{{ $item->id }}">
                                            <td class="drag-handle">
                                                @icon('solid/bars')
                                            </td>
                                            <td class="{{themeLinks('font-semibold')}}">
                                                @if(can('estimates_update'))
                                                <a data-toggle="ajaxModal" href="{{ route('items.edit', $item->id) }}">
                                                    {{  $item->name == '' ? '...' : $item->name  }}
                                                </a>
                                                @else
                                                {{ $item->name }}
                                                @endif
                                            </td>
                                            <td class="text-gray-600 hidden-xs">
                                                @parsedown($item->description)
                                            </td>
                                            <td class="text-right">
                                                {{  formatQuantity($item->quantity) }}
                                            </td>
                                            @if ($showtax)
                                            <td class="text-right small">
                                                {{ $item->tax_total }}</td>
                                            @endif
                                            <td class="text-right">
                                                {{ formatDecimal($item->unit_cost) }}
                                            </td>
                                            @if ($showDiscount)
                                            <td class="text-right text-dark">
                                                {{ $item->discount }}%
                                            </td>
                                            @endif
                                            <td class="font-semibold text-right text-gray-600">
                                                {{ formatCurrency($estimate->currency, $item->total_cost) }}
                                            </td>
                                            <td class="text-right">
                                                @if(can('estimates_update') && $estimate->isEditable())
                                                <a class="hidden-print deleteItem" data-item-id="{{ $item->id }}" href="#">
                                                    @icon('solid/trash-alt', 'text-danger')
                                                </a>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach

                                        @if (can('estimates_update') && $estimate->isEditable())
                                        @widget('Items\CreateItemWidget', ['module_id' => $estimate->id, 'module' =>
                                        'estimates', 'order' => count($estimate->items) + 1 , 'taxes' => $showtax,'discount' => $showDiscount])
                                        @endif
                                        <div class="ajaxTotals">
                                            <tr>
                                                <td class="text-right no-border totalsColspan">
                                                    <strong>
                                                        @langapp('sub_total')
                                                    </strong>
                                                </td>
                                                <td class="text-right">
                                                    <span id="estimate-subtotal">
                                                        {{ formatCurrency($estimate->currency, $estimate->subTotal()) }}
                                                    </span>
                                                </td>
                                                <td>
                                                </td>
                                            </tr>
                                            @foreach ($estimate->taxes->groupBy('tax_type_id') as $taxes)
                                            <tr class="taxes">
                                                <td class="text-right no-border totalsColspan">
                                                    <strong>{{ $taxes[0]->taxtype->name }}
                                                        ({{ formatTax($taxes[0]->percent) }}%)</strong>
                                                </td>
                                                <td class="text-right">
                                                    <span id="tax-{{$taxes[0]->id}}">
                                                        {{ formatCurrency($estimate->currency, $estimate->taxTypeAmount($taxes)) }}
                                                    </span>
                                                </td>
                                                <td></td>
                                            </tr>
                                            @endforeach
                                            @if ($estimate->tax > 0)
                                            <tr>
                                                <td class="text-right no-border totalsColspan">
                                                    <strong>
                                                        {{get_option('tax1Label')}}
                                                        ({{formatTax($estimate->tax)}}%)
                                                    </strong>
                                                </td>
                                                <td class="text-right">
                                                    <span id="estimate-tax1">
                                                        {{formatCurrency($estimate->currency, $estimate->tax1Amount())}}
                                                    </span>
                                                </td>
                                                <td>
                                                </td>
                                            </tr>
                                            @endif
                                            @if ($estimate->tax2 > 0)
                                            <tr>
                                                <td class="text-right no-border totalsColspan">
                                                    <strong>
                                                        {{get_option('tax2Label')}}
                                                        ({{formatTax($estimate->tax2)}}%)
                                                    </strong>
                                                </td>
                                                <td class="text-right">
                                                    <span id="estimate-tax2">
                                                        {{formatCurrency($estimate->currency, $estimate->tax2Amount())}}
                                                    </span>
                                                </td>
                                                <td>
                                                </td>
                                            </tr>
                                            @endif
                                            @if ($estimate->discount > 0)
                                            <tr>
                                                <td class="text-right no-border totalsColspan">
                                                    <strong>
                                                        @langapp('discount') -
                                                        {{formatDecimal($estimate->discount)  }}{{ ($estimate->discount_percent) ? '%' : ''}}
                                                    </strong>
                                                </td>
                                                <td class="text-right">
                                                    <span id="estimate-discount">
                                                        {{formatCurrency($estimate->currency, $estimate->discounted())}}
                                                    </span>
                                                </td>
                                                <td>
                                                </td>
                                            </tr>
                                            @endif
                                            <tr class="bg-indigo-100">
                                                <td class="text-right no-border totalsColspan">
                                                    <strong>
                                                        @langapp('total')
                                                    </strong>
                                                </td>
                                                <td class="font-semibold text-right">
                                                    <span id="estimate-total">
                                                        {{ formatCurrency($estimate->currency, $estimate->amount()) }}
                                                    </span>
                                                </td>
                                                <td>
                                                </td>
                                            </tr>
                                        </div>
                                    </tbody>
                                </table>
                                {!! Form::close() !!}
                            </div>
                            @if (settingEnabled('amount_in_words'))
                            @widget('Payments\AmountWords', ['currency' => $estimate->currency, 'amount' =>
                            $estimate->amount()])
                            @endif

                            <div class="line line-dashed"></div>
                            <div class="mt-3 notes-section">
                                <h4 class="font-semibold text-gray-700 uppercase">@langapp('notes')</h4>
                                <div class="text-sm prose-lg">
                                    @parsedown($estimate->notes)
                                </div>

                            </div>

                            @widget('CustomFields\Extras', ['custom' => $estimate->custom])

                            @if($estimate->status == 'Declined')
                            <div class="py-3 text-sm prose-lg">
                                <h4 class="text-gray-700 uppercase">@langapp('feedback')</h4>
                                <blockquote>
                                    @parsedown($estimate->rejected_reason)
                                </blockquote>
                            </div>
                            @endif

                            {{ $estimate->clientViewed() }}

                            <div class="line line-dashed"></div>

                            <div x-data="{ tab: 'activities' }">
                                <div class="">
                                    <nav class="flex flex-col sm:flex-row">
                                        <a href="#" :class="{ '{{themeLinks('border-b-2 border-indigo-500')}}': tab === 'activities' }" @click="tab = 'activities'"
                                            class="block px-6 py-4 text-gray-600 text-semibold hover:text-indigo-500 focus:outline-none">
                                            <i class="fas fa-history"></i> @langapp('activities')
                                        </a>
                                        <a href="#" :class="{ '{{themeLinks('border-b-2 border-indigo-500')}}': tab === 'comments' }" @click="tab = 'comments'"
                                            class="block px-6 py-4 text-gray-600 text-semibold hover:text-indigo-500 focus:outline-none">
                                            <i class="fas fa-comments"></i> @langapp('comments')
                                        </a>

                                    </nav>
                                </div>

                                <div class="py-2 bg-gray-100 rounded">

                                    <div x-show="tab === 'activities'" class="py-1">
                                        <div class="comments-history">
                                            @canany(['estimates_create', 'estimates_update'])

                                            @livewire('common.activities',['activities' => $estimate->activities])

                                            @endcanany
                                        </div>
                                    </div>
                                    <div x-show="tab === 'comments'" class="py-1">

                                        <section class="block comment-list">
                                            @can('estimates_comment')
                                            <article class="comment-item" id="comment-form">
                                                <a class="pull-left thumb-sm avatar">
                                                    <img src="{{ avatar() }}" class="img-circle">
                                                </a>
                                                <span class="arrow left"></span>
                                                <section class="comment-body">
                                                    <section class="p-2 panel panel-default">
                                                        @widget('Comments\CreateWidget', ['commentable_type' => 'estimates' , 'commentable_id' => $estimate->id])
                                                    </section>
                                                </section>
                                            </article>

                                            @widget('Comments\ShowComments', ['comments' => $estimate->comments])
                                            @endcan
                                        </section>
                                    </div>
                                </div>
                            </div>
                    </div>
                </section>
            </section>
        </aside>

        <aside class="bg-white aside-lg b-l hide" id="aside-files">
            <header class="p-2 border-b">
                <div class="flex justify-between">
                    <div>
                        <span class="text-lg text-gray-600">
                            @langapp('files')
                        </span>
                    </div>
                    <div>
                        @can('files_create')
                        <a href="{{route('files.upload', ['module' => 'estimates', 'id' => $estimate->id])}}" data-placement="left" data-rel="tooltip"
                            title="@langapp('upload_file')" data-toggle="ajaxModal" class="btn {{themeButton()}}">
                            @icon('solid/upload')
                        </a>
                        @endcan
                    </div>
                </div>
            </header>
            <div class="m-1">
                @include('partial._show_files', ['files' => $estimate->files, 'limit' => true])
            </div>

        </aside>

    </section>


</section>
<a class="hide nav-off-screen-block" data-target="#nav" data-toggle="class:nav-off-screen" href="#">
</a>
@push('pagestyle')
<link href="{{ getAsset('plugins/typeahead/typeahead.css') }}" rel="stylesheet" type="text/css">
@include('stacks.css.form')
@include('stacks.css.wysiwyg')
@endpush

@push('pagescript')
<script src="{{ getAsset('plugins/typeahead/typeahead.jquery.min.js') }}"></script>
@include('stacks.js.typeahead')
@include('stacks.js.form')
@include('stacks.js.wysiwyg')
@include('stacks.js.sortable')
@include('estimates::_includes.items_ajax')
@include('comments::_ajax.ajaxify')
<script>
    $(".totalsColspan").attr('colspan',document.getElementById('est-details').rows[0].cells.length - 2);
    $('#tabs').on('click','.tablink,#prodTabs a',function (e) {
    e.preventDefault();
    var url = $(this).attr("data-url");
    if (typeof url !== "undefined") {
        var pane = $(this), href = this.hash;
    $(href).load(url,function(result){
        pane.tab('show');
    });
    } else {
        $(this).tab('show');
    }
    });
</script>
@endpush

@endsection