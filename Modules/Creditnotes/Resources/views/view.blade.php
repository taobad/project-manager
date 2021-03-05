@extends('layouts.app')
@section('content')
<section id="content">
    <section class="hbox stretch">
        <aside>
            <section class="vbox">
                <header class="px-2 pb-2 bg-white border-b border-gray-400 panel-heading">
                    <div class="flex justify-between text-gray-500">
                        <div>
                            @can('credits_send')
                            @if ($creditnote->company->email)
                            <a href="{{route('creditnotes.send', $creditnote->id) }}" data-toggle="ajaxModal" class="btn {{themeButton()}}">
                                @icon('solid/envelope-open-text') @langapp('send')
                            </a>
                            @endif
                            @endcan
                            @can('credits_update')
                            <a href="{{route('creditnotes.edit', $creditnote->id)}}" class="btn {{themeButton()}}" title="@langapp('make_changes')" data-toggle="tooltip"
                                data-placement="bottom">
                                @icon('solid/pencil-alt')
                            </a>
                            <a href="{{route('items.insert', ['id' => $creditnote->id, 'module' => 'creditnotes'])}}" title="@langapp('item_quick_add')"
                                class="btn {{themeButton()}}" data-toggle="ajaxModal">
                                @icon('solid/list') @langapp('items')
                            </a>
                            @endcan
                        </div>
                        <div>
                            <a href="{{route('creditnotes.pdf', $creditnote->id)}}" class="btn {{themeButton()}}">
                                @icon('solid/file-pdf') PDF
                            </a>
                            @can('credits_delete')
                            <a href="{{route('creditnotes.delete', $creditnote->id) }}" class="btn {{themeButton()}}" title="@langapp('delete')" data-toggle="ajaxModal">
                                @icon('solid/trash-alt')
                            </a>
                            @endcan
                            <a href="#aside-files" data-toggle="class:show" class="btn {{themeButton()}}">
                                @icon('regular/folder-open')
                            </a>
                        </div>
                    </div>
                </header>
                <section class="p-4 bg-gray-300 scrollable ie-details">
                    <div class="p-4 bg-white rounded-sm col-md-12">
                        <div class="ribbon {{$creditnote->ribbonColor()}}"><span>{{$creditnote->status}}</span></div>
                        @if ($creditnote->status == 'void')
                        <div class="alert alert-danger hidden-print">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            @icon('solid/exclamation-circle') This Credit Note is marked as VOID
                        </div>
                        @endif

                        <div class="mt-4 row">
                            <div class="col-md-6 col-xs-12">
                                <div style="height: {{ get_option('invoice_logo_height') }}px">
                                    <img class="ie-logo img-responsive" src="{{ getStorageUrl(config('system.media_dir').'/'.get_option('invoice_logo')) }}">
                                </div>
                            </div>
                            <div class="text-right col-md-6 col-xs-12 credit-text">
                                <p class="h4">
                                    <span class="text-3xl font-semibold">{{ $creditnote->reference_no }}</span>
                                </p>
                                <div class="py-1">
                                    @langapp('credit_date')
                                    <span class="col-xs-4 no-gutter-right pull-right">
                                        <strong>
                                            {{ dateString($creditnote->created_at) }}
                                        </strong>
                                    </span>
                                </div>
                                <div class="py-1">
                                    @langapp('status')
                                    <span class="col-xs-4 no-gutter-right pull-right">
                                        <span class="label {{themeBg()}}">
                                            @langapp($creditnote->status)
                                        </span>
                                        @if ($creditnote->is_refunded)
                                        <span class="bg-red-600 label m-l-xs">
                                            @langapp('refunded')
                                        </span>
                                        @endif
                                    </span>
                                </div>
                                <div class="py-1">
                                    @langapp('balance')
                                    <span class="col-xs-4 no-gutter-right pull-right">
                                        <strong>{{  formatCurrency($creditnote->currency, $creditnote->balance) }}</strong></span>
                                </div>
                                @if($creditnote->currency != 'USD')
                                <div>
                                    @langapp('xrate')
                                    <span class="col-xs-4 no-gutter-right pull-right">
                                        <strong>
                                            1 USD = {{ $creditnote->currency }}
                                            {{$creditnote->exchange_rate}}
                                        </strong>
                                    </span>
                                </div>
                                @endif
                            </div>
                        </div>
                        @php
                        $data['company'] = $creditnote->company;
                        $address_span = $creditnote->show_shipping_on_credits == 1 ? 4 : 6;
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
                                            {!! formatClientAddress($creditnote, 'credits', 'billing', true) !!}
                                        </address>
                                        @if($creditnote->company->primary_contact)
                                        <address>
                                            <strong>@langapp('contact_person') </strong><br>
                                            <a class="text-indigo-600" href="mailto:{{ $creditnote->company->contact->email }}">{{ $creditnote->company->contact->name }}</a>
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
                                @if($creditnote->show_shipping_on_credits == 1)
                                <div class="col-xs-{{$address_span}}">
                                    <strong>Ship To:</strong>
                                    <address>
                                        {!! formatClientAddress($creditnote, 'credits', 'shipping') !!}
                                    </address>
                                </div>
                                @endif
                            </div>
                        </div>
                        @php $showtax = $creditnote->tax_per_item == 1 ? true :false; @endphp
                        <div class="line"></div>
                        <div class="table-responsive">
                            {!! Form::open(['url' => '#', 'class' => 'bs-example form-horizontal', 'id' =>
                            'saveItem']) !!}
                            <table id="cr-details" class="table sorted_table small" type="creditnotes">
                                <thead>
                                    <tr class="uppercase bg-indigo-100">
                                        <th></th>

                                        <th width="20%">@langapp('product') </th>
                                        <th width="25%" class="hidden-xs">@langapp('description') </th>
                                        <th class="text-right" width="10%">@langapp('qty') </th>
                                        @if ($showtax)
                                        <th class="text-right" width="10%">@langapp('tax_rate') </th>
                                        @endif
                                        <th class="text-right" width="12%">{{ itemUnit() }}</th>
                                        <th class="text-right" width="12%">@langapp('total') </th>
                                        <th class="text-right inv-actions"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($creditnote->items as $key => $item)
                                    <tr class="sortable" data-id="{{$item->id}}" data-name="{{$item->name}}" id="item-{{ $item->id }}">
                                        <td class="drag-handle">@icon('solid/bars')</td>
                                        <td class="{{themeLinks('font-semibold')}}">
                                            @if (can('credits_update'))
                                            <a href="{{route('items.edit', $item->id) }}" data-toggle="ajaxModal">
                                                {{$item->name == '' ? '...' : $item->name}}
                                            </a>
                                            @else
                                            {{$item->name}}
                                            @endif
                                        </td>
                                        <td class="text-gray-600 hidden-xs">@parsedown($item->description)</td>
                                        <td class="text-right">{{  formatQuantity($item->quantity) }}</td>
                                        @if ($showtax)
                                        <td class="text-right">
                                            {{ $item->tax_total }}</td>
                                        @endif
                                        <td class="text-right">{{ $item->unit_cost }}</td>

                                        <td class="font-semibold text-right">
                                            {{  formatCurrency($creditnote->currency, $item->total_cost)}}
                                        </td>
                                        <td class="text-right">
                                            @if(can('credits_update') && $creditnote->isEditable())
                                            <a class="hidden-print deleteItem" data-item-id="{{ $item->id }}" href="#">
                                                @icon('solid/trash-alt', 'text-red-600')
                                            </a>
                                            @endif
                                        </td>

                                    </tr>
                                    @endforeach
                                    @if(can('credits_update') && $creditnote->isEditable())
                                    @widget('Items\CreateItemWidget', [
                                    'module_id' => $creditnote->id,
                                    'module' => 'credits',
                                    'order' => count($creditnote->items) + 1 ,
                                    'taxes' => $showtax
                                    ])
                                    @endif
                                    <tr>
                                        <td class="text-right no-border totalsColspan">
                                            <strong>@langapp('total') </strong></td>
                                        <td class="text-right">
                                            <span id="cr-subtotal">{{  formatCurrency($creditnote->currency, $creditnote->subTotal())}}</span>
                                        </td>
                                        <td></td>
                                    </tr>
                                    @foreach ($creditnote->taxes->groupBy('tax_type_id') as $taxes)
                                    <tr class="taxes">
                                        <td class="text-right no-border totalsColspan">
                                            <strong>{{ $taxes[0]->taxtype->name }}
                                                ({{ formatTax($taxes[0]->percent) }}%)</strong>
                                        </td>
                                        <td class="text-right">
                                            <span id="tax-{{$taxes[0]->id}}">
                                                {{ formatCurrency($creditnote->currency, $creditnote->taxTypeAmount($taxes)) }}
                                            </span>
                                        </td>
                                        <td></td>
                                    </tr>
                                    @endforeach
                                    @if ($creditnote->tax > 0)
                                    <tr>
                                        <td class="text-right no-border totalsColspan">
                                            <strong>@langapp('tax')
                                                ({{  formatTax($creditnote->tax)}}%)</strong>
                                        </td>
                                        <td class="text-right text-red-600">
                                            <span id="cr-tax">{{  formatCurrency($creditnote->currency, $creditnote->tax())}}</span>
                                        </td>
                                        <td></td>
                                    </tr>
                                    @endif

                                    @if ($creditnote->used > 0)
                                    <tr>
                                        <td class="text-right no-border totalsColspan">
                                            <strong>@langapp('credits_used') </strong></td>
                                        <td class="text-right text-red-600">
                                            <span id="cr-used">
                                                {{  formatCurrency($creditnote->currency, $creditnote->used)}}</span>
                                        </td>
                                        <td></td>
                                    </tr>
                                    @endif
                                    <tr class="bg-indigo-100">
                                        <td class="text-right no-border totalsColspan">
                                            <strong>
                                                @langapp('balance') </strong></td>
                                        <td class="font-semibold text-right">
                                            <span id="cr-balance">
                                                {{  formatCurrency($creditnote->currency, $creditnote->balance())}}
                                            </span>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                            {!! Form::close() !!}
                        </div>
                        {{-- START INVOICES CREDITED --}}
                        @if($creditnote->used > 0)
                        <div class="m-b-60">
                            <h4 class="py-3 font-bold uppercase">@langapp('invoices_credited')</h4>
                            <table class="table">
                                <tbody>
                                    <tr class="text-muted">
                                        <td>@langapp('date')</td>
                                        <td>@langapp('invoice') #</td>
                                        <td class="tr">@langapp('amount_credited')</td>
                                        <td></td>
                                    </tr>
                                    @foreach ($creditnote->credited as $credited)
                                    <tr class="table-row">
                                        <td> {{ dateTimeString($credited->created_at) }} </td>
                                        <td class="{{themeLinks('font-semibold')}}">
                                            <a href="{{route('invoices.view', $credited->invoice->id) }}">{{$credited->invoice->reference_no}}</a>
                                        </td>
                                        <td class="tr">
                                            {{ formatCurrency($credited->credit->currency, $credited->credited_amount) }}
                                        </td>
                                        <td>
                                            <a href="{{route('creditnotes.remove_credit', $credited->id) }}" data-toggle="ajaxModal">
                                                @icon('regular/trash-alt', 'text-indigo-600')
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif

                        @admin
                        <div class="mt-3 notes-section">
                            <h4 class="font-semibold text-gray-700 uppercase">@langapp('notes')</h4>
                            <div class="text-sm prose-lg">
                                @parsedown($creditnote->notes)
                            </div>

                        </div>

                        <div class="line line-dashed"></div>
                        @endadmin

                        <div class="mt-3 notes-section">
                            <h4 class="font-semibold text-gray-700 uppercase">@langapp('terms')</h4>
                            <div class="text-sm prose-lg">
                                @parsedown($creditnote->terms)
                            </div>

                        </div>

                        <div class="line line-dashed m-sm"></div>

                        <div x-data="{ tab: 'activities' }">
                            <div class="">
                                <nav class="flex flex-col sm:flex-row">
                                    <a href="#" :class="{ '{{themeLinks('border-b-2 border-indigo-500')}}': tab === 'activities' }" @click="tab = 'activities'"
                                        class="block px-6 py-4 font-semibold text-gray-600 hover:text-indigo-500 focus:outline-none">
                                        <i class="fas fa-history"></i> @langapp('activities')
                                    </a>
                                    <a href="#" :class="{ '{{themeLinks('border-b-2 border-indigo-500')}}': tab === 'comments' }" @click="tab = 'comments'"
                                        class="block px-6 py-4 font-semibold text-gray-600 hover:text-indigo-500 focus:outline-none">
                                        <i class="fas fa-comments"></i> @langapp('comments')
                                    </a>
                                </nav>
                            </div>

                            <div class="py-2 bg-gray-100 rounded">

                                <div x-show="tab === 'activities'" class="py-1">
                                    <div class="comments-history">
                                        @canany(['credits_create', 'credits_update'])
                                        @livewire('common.activities',['activities' => $creditnote->activities])
                                        @endcanany
                                    </div>
                                </div>
                                <div x-show="tab === 'comments'" class="py-1">

                                    <section class="block comment-list">
                                        <article class="comment-item" id="comment-form">
                                            <a class="pull-left thumb-sm avatar">
                                                <img src="{{ avatar() }}" class="img-circle">
                                            </a>
                                            <span class="arrow left"></span>
                                            <section class="comment-body">
                                                <section class="p-2 panel panel-default">
                                                    @widget('Comments\CreateWidget', ['commentable_type' =>
                                                    'credits' , 'commentable_id' => $creditnote->id])
                                                </section>
                                            </section>
                                        </article>

                                        @widget('Comments\ShowComments', ['comments' =>
                                        $creditnote->comments])
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </section>
        </aside>
        <aside class="bg-white aside-lg b-l hide" id="aside-files">
            <header class="px-1 py-2 border-b">
                <div class="flex justify-between">
                    <div>
                        <span class="text-lg text-gray-600">
                            @langapp('files')
                        </span>
                    </div>
                    <div>
                        @can('files_create')
                        <a href="{{route('files.upload', ['module' => 'credits', 'id' => $creditnote->id])}}" title="@langapp('upload_file')" data-toggle="ajaxModal"
                            class="btn {{themeButton()}}">
                            @icon('solid/upload')
                        </a>
                        @endcan
                    </div>
                </div>
            </header>
            <div class="m-xs">
                @include('partial._show_files', ['files' => $creditnote->files, 'limit' => true])
            </div>

        </aside>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
</section>
@push('pagestyle')
<link href="{{ getAsset('plugins/typeahead/typeahead.css') }}" rel="stylesheet" type="text/css">
@include('stacks.css.form')
@include('stacks.css.wysiwyg')
@endpush
@push('pagescript')
<script src="{{ getAsset('plugins/typeahead/typeahead.jquery.min.js') }}"></script>
@include('stacks.js.form')
@include('stacks.js.wysiwyg')
@include('stacks.js.sortable')
@include('stacks.js.typeahead')
@include('creditnotes::_includes.items_ajax')
@include('comments::_ajax.ajaxify')
<script>
    $(".totalsColspan").attr('colspan',document.getElementById('cr-details').rows[0].cells.length - 2);
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