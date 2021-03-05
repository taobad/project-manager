@extends('layouts.app')
@section('content')
<section id="content" class="bg">
    <section class="hbox stretch">
        <section class="vbox">
            <header class="px-2 pb-2 bg-white border-b border-gray-400 panel-heading">
                <div class="flex justify-between text-gray-500">
                    <div>
                        <span class="text-xl font-semibold text-gray-600">{{ $company->name }}</span>
                    </div>
                    <div>
                        @can('clients_delete')
                        <a href="{{ route('clients.delete', ['client' => $company->id]) }}" class="btn {{themeButton()}}" data-toggle="ajaxModal">
                            @icon('solid/trash-alt')
                        </a>
                        @endcan
                        @can('clients_update')
                        <a href="{{ route('clients.edit', ['client' => $company->id]) }}" class="btn {{themeButton()}}" data-toggle="ajaxModal">
                            @icon('solid/pencil-alt') @langapp('edit')
                        </a>
                        @endcan
                    </div>
                </div>
            </header>
            <section class="scrollable wrapper scrollpane">

                <div class="row">
                    <div class="col-sm-12 m-b-xs">
                        <div class="sub-tab text-uc small m-b-10">
                            <ul class="nav pro-nav-tabs nav-tabs-dashed">

                                <li class="{{ ($tab == 'dashboard') ? themeText('font-semibold border-b border-indigo-500') : ''  }}">

                                    <a href="{{ route('clients.view', ['client' => $company->id, 'tab' => 'dashboard']) }}">
                                        @icon('solid/tachometer-alt') @langapp('overview')
                                        @if ($company->hasUnread())
                                        <span class="label label-dracula">
                                            @icon('solid/envelope') {{ $company->hasUnread() }}
                                        </span>
                                        @endif
                                    </a>
                                </li>
                                <li class="{{ $tab == 'contacts' ? themeText('font-semibold border-b border-indigo-500') : ''  }}">
                                    <a href="{{  route('clients.view', ['client' => $company->id, 'tab' => 'contacts']) }}">
                                        @icon('solid/users') @langapp('contacts') </a>
                                </li>
                                <li class="{{ $tab == 'projects' ? themeText('font-semibold border-b border-indigo-500') : ''  }}">

                                    <a href="{{  route('clients.view', ['client' => $company->id, 'tab' => 'projects']) }}">
                                        @icon('solid/clock') @langapp('projects') </a>
                                </li>
                                <li class="{{ $tab == 'invoices' ? themeText('font-semibold border-b border-indigo-500') : ''  }}">

                                    <a href="{{  route('clients.view', ['client' => $company->id, 'tab' => 'invoices']) }}">
                                        @icon('solid/file-invoice-dollar') @langapp('invoices')
                                    </a>
                                </li>
                                <li class="{{ $tab == 'estimates' ? themeText('font-semibold border-b border-indigo-500') : ''  }}">

                                    <a href="{{  route('clients.view', ['client' => $company->id, 'tab' => 'estimates']) }}">
                                        @icon('solid/file-alt') @langapp('estimates') </a>
                                </li>
                                <li class="{{ $tab == 'payments' ? themeText('font-semibold border-b border-indigo-500') : ''  }}">

                                    <a href="{{  route('clients.view', ['client' => $company->id, 'tab' => 'payments']) }}">
                                        @icon('solid/credit-card') @langapp('payments') </a>
                                </li>
                                <li class="{{ $tab == 'expenses' ? themeText('font-semibold border-b border-indigo-500') : ''  }}">

                                    <a href="{{  route('clients.view', ['client' => $company->id, 'tab' => 'expenses']) }}">
                                        @icon('solid/shopping-basket') @langapp('expenses') </a>
                                </li>
                                <li class="{{ $tab == 'deals' ? themeText('font-semibold border-b border-indigo-500') : ''  }}">

                                    <a href="{{  route('clients.view', ['client' => $company->id, 'tab' => 'deals']) }}">
                                        @icon('solid/euro-sign') @langapp('deals') </a>
                                </li>
                                <li class="{{ $tab == 'files' ? themeText('font-semibold border-b border-indigo-500') : ''  }}">

                                    <a href="{{  route('clients.view', ['client' => $company->id, 'tab' => 'files']) }}">
                                        @icon('solid/hdd') @langapp('files') </a>
                                </li>
                                <li class="{{ $tab == 'subscriptions' ? themeText('font-semibold border-b border-indigo-500') : ''  }}">

                                    <a href="{{  route('clients.view', ['client' => $company->id, 'tab' => 'subscriptions']) }}">
                                        @icon('regular/calendar-alt') @langapp('subscriptions') </a>
                                </li>

                                <li class="{{ $tab == 'creditnotes' ? themeText('font-semibold border-b border-indigo-500') : ''  }}">

                                    <a href="{{  route('clients.view', ['client' => $company->id, 'tab' => 'creditnotes']) }}">
                                        @icon('solid/receipt') @langapp('creditnotes') </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @if ($company->balance > 0)
                <x-alert type="warning" icon="solid/exclamation-triangle" class="text-sm leading-5">
                    @langapp('client_has_balance', ['balance' => formatCurrency($company->currency, $company->balance)])
                </x-alert>
                @endif
                <div class="row">

                    @include('clients::tab._'.$tab)
                </div>
            </section>
        </section>
    </section>
</section>
@push('pagestyle')
@include('stacks.css.wysiwyg')
@endpush
@push('pagescript')
@include('stacks.js.wysiwyg')
@endpush
@endsection