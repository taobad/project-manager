@extends('layouts.app')
@section('content')
<section id="content">
    <section class="hbox stretch">
        <aside>
            <section class="vbox">
                <header class="px-2 pb-2 bg-white border-b border-gray-400 panel-heading">
                    <div class="flex justify-between text-gray-500">
                        <div>
                            <span class="text-xl font-semibold text-gray-600">{{ $contract->contract_title }}</span>
                        </div>
                        <div>
                            @can('contracts_sign')
                            @if ($contract->signed == '0')
                            <a href="{{ route('contracts.send', ['contract' => $contract->id]) }}" class="btn {{ themeButton() }}" data-toggle="ajaxModal">
                                @icon('solid/file-signature') @langapp('sign_send')
                            </a>
                            @endif
                            @endcan
                            @if ($contract->client_id == Auth::user()->profile->company)
                            <a href="{{ URL::signedRoute('contracts.guest.show', $contract->id) }}" class="btn {{ themeButton() }}">
                                @icon('solid/file-signature') @langapp('preview')
                            </a>
                            @endif
                            <div class="btn-group">
                                <button class="{{themeButton()}} dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    @langapp('more_actions')
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    @can('contracts_update')
                                    @if ($contract->signed == 0)
                                    <li><a href="{{ route('contracts.edit', ['contract' => $contract->id]) }}">@icon('solid/pencil-alt')
                                            @langapp('edit')</a></li>
                                    @endif
                                    @endcan
                                    @admin
                                    <li><a href="{{ route('contracts.copy', $contract->id)  }}" data-toggle="ajaxModal">@icon('solid/copy') @langapp('copy')</a></li>
                                    <li><a href="{{ route('contracts.activity', ['contract' => $contract->id]) }}" data-toggle="ajaxModal">@icon('solid/history')
                                            @langapp('activities')</a></li>
                                    @can('reminders_create')
                                    <li><a data-toggle="ajaxModal" href="{{ route('calendar.reminder', ['module' => 'contracts', 'id' => $contract->id]) }}">
                                            @icon('solid/stopwatch') @langapp('set_reminder')
                                        </a>
                                    </li>
                                    @endcan
                                    @can('contracts_sign')
                                    <li><a href="{{ route('contracts.share', $contract->id) }}" data-toggle="ajaxModal">@icon('solid/link') @langapp('share')</a></li>
                                    @endcan

                                    @endadmin
                                    <li>
                                        <a href="{{ route('contracts.download', $contract->id) }}">
                                            @icon('solid/file-pdf') PDF
                                        </a>
                                    </li>

                                </ul>
                            </div>

                            <a href="#aside-files" data-toggle="class:show" class="btn {{themeButton()}}">
                                @icon('solid/folder-open')
                            </a>
                        </div>


                    </div>
                </header>

                <section class="bg-indigo-100 scrollable">
                    <div class="wrapper">
                        <section class="text-sm prose-lg rounded-sm panel panel-body">

                            @if ($contract->isExpired())
                            <x-alert type="danger" icon="solid/exclamation-triangle" class="text-sm leading-5">
                                @langapp('contract_expired', ['date' => $contract->expiry_date->toDayDateTimeString()])
                            </x-alert>
                            @endif

                            @if (!is_null($contract->rejected_at))
                            <x-alert type="danger" icon="solid/times" class="text-sm leading-5">
                                <strong> Contract Rejected!</strong>
                                This contract was rejected on {{ dateTimeFormatted($contract->rejected_at) }}
                                <blockquote class="text-sm">
                                    @parsedown($contract->rejected_reason)
                                </blockquote>
                            </x-alert>
                            @endif

                            @if ($contract->client_sign_id > 0)
                            <x-alert type="success" icon="solid/signature" class="text-sm leading-5">
                                <strong> Contract Approved!</strong> This contract was approved on {{ $contract->clientSign->updated_at->toDayDateTimeString() }}
                            </x-alert>
                            @endif



                            <h1 class="text-4xl font-semibold text-center text-gray-600">@langapp('service_contract')
                            </h1>
                            <h1 class="text-3xl text-center text-gray-600">{{  $contract->contract_title  }}</h1>

                            <div class="line line-dashed line-lg pull-in"></div>
                            @php
                            $data['company'] = $contract->company;
                            @endphp
                            <div class="pb-2">
                                <div class="col-md-6">
                                    <div class="h4"><strong>@langapp('client')</strong> (the "Client")</div>
                                    <div class="m-md">
                                        {!! formatClientAddress($contract, 'invoice', 'billing', false) !!}
                                        @if($contract->company->primary_contact)
                                        <address class="mt-3">
                                            <strong>@langapp('contact_person') </strong><br>
                                            <a class="text-indigo-600" href="mailto:{{ $contract->company->contact->email }}">{{ $contract->company->contact->name }}</a>
                                        </address>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="h4"><strong>@langapp('contractor')</strong> (the "Contractor")</div>
                                    <div class="m-md">
                                        {!! formatCompanyAddress($data) !!}
                                        @if(get_option('contact_person'))
                                        <address class="mt-3">
                                            <strong>@langapp('contact_person') </strong><br>
                                            <a class="text-indigo-600" href="mailto:{{ get_option('company_email') }}">{{ get_option('contact_person') }}</a>
                                        </address>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <h2 class="text-2xl text-gray-600">Attachment A:</h2>
                            <h3 class="text-xl text-gray-600">Services</h3>
                            <div class="">
                                <p class="m-t-sm">Contractor agrees to perform services as described in Attachment A
                                    (the “Services”)
                                    and Client agrees to pay Contractor as described in Attachment A.</p>
                                <div class="text-xl text-gray-600">Term</div>
                                <div class="m-b-20">@langapp('start_date'):
                                    <strong>{{  dateFormatted($contract->start_date)  }}</strong> -
                                    @langapp('end_date'):
                                    <strong>{{  dateFormatted($contract->end_date)  }}</strong></div>
                                <div class="text-xl text-gray-600">Rate</div>
                                <div class="m-b-20">
                                    <p class="">{{ $contract->services }}</p>
                                    <p class="">
                                        @if ($contract->rate_is_fixed == 0)
                                        {{ formatCurrency($contract->currency, $contract->hourly_rate)  }} Per hour
                                        @else
                                        {{ formatCurrency($contract->currency, $contract->fixed_rate)  }} Fixed Fee
                                        @endif
                                    </p>
                                </div>
                                <h3 class="text-xl text-gray-600">@langapp('description')</h3>
                                <div class="m-b-20">
                                    {!! $contract->description !!}
                                </div>
                            </div>
                            @php
                            $late_fee = ($contract->late_payment_percent == 0) ? formatCurrency($contract->currency,
                            $contract->late_payment_fee) : $contract->late_payment_fee;
                            $texts = [
                            "{EXPIRY_DATE}","{TERM_DAYS}","{CANCEL_FEE}","{PAYMENT_DAYS}","{LATE_FEE}","{DEPOSIT_FEE}","{FEEDBACKS}",
                            "{CLIENT_RIGHTS}","{CONTACT_PERSON}","{TITLE}","{START_DATE}","{END_DATE}","{DESCRIPTION}",
                            "{CURRENCY}","{SERVICES}"
                            ];
                            $data = [
                            dateFormatted($contract->expiry_date), $contract->termination_notice,
                            formatCurrency($contract->currency, $contract->cancelation_fee),
                            $contract->payment_terms, $late_fee, formatCurrency($contract->currency,
                            $contract->deposit_required),
                            $contract->feedbacks, $contract->client_rights,$contract->company->contact_person,
                            $contract->contract_title, dateFormatted($contract->start_date),
                            dateFormatted($contract->end_date),
                            $contract->description, $contract->currency, $contract->services
                            ];
                            @endphp
                            <h2 class="text-2xl text-gray-600">Attachment B:</h2>
                            {!! str_replace($texts, $data , $contract->template->body) !!}

                            <div class="row pb15">
                                <div class="col-md-6 m-t-lg">
                                    <strong>Client</strong> ({{  $contract->company->contact_person }})
                                    @if ($contract->client_sign_id > 0)
                                    <span class="m-l-sm text-muted small">
                                        Signed -
                                        <strong>{{  dateTimeFormatted($contract->clientSign->created_at)  }}</strong>
                                    </span>
                                    @endif
                                    <div class="signatureSec">
                                        <div class="col-md-8">
                                            @if ($contract->client_sign_id > 0)
                                            <span class="text-3xl signature">
                                                @if($contract->clientSign->image)
                                                <img src="{{ getStorageUrl(config('system.signature_dir').'/'.$contract->clientSign->image) }}" width="200" alt="">
                                                @else
                                                {{  $contract->clientSign->signature  }}
                                                @endif
                                            </span>

                                            @else
                                            <div class="line line-dashed line-lg pull-in m-t-40"></div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 m-t-lg">
                                    <strong>Contractor</strong> ({{  get_option('contact_person')  }})
                                    @if ($contract->contractor_sign_id > 0)
                                    <span class="m-l-sm text-muted small">
                                        Signed -
                                        <strong>{{ dateTimeFormatted($contract->contractorSign->created_at)  }}</strong>
                                    </span>
                                    @endif
                                    <div class="signatureSec">
                                        <div class="col-md-8">
                                            @if ($contract->contractor_sign_id > 0)

                                            <span class="text-3xl signature">
                                                @if($contract->contractorSign->image)
                                                <img src="{{ getStorageUrl(config('system.signature_dir').'/'.$contract->contractorSign->image) }}" width="200" alt="">
                                                @else
                                                {{  $contract->contractorSign->signature  }}
                                                @endif
                                            </span>


                                            @else
                                            <div class="line line-dashed line-lg pull-in m-t-40"></div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (!is_null($contract->annotations))
                            <p>{{  $contract->annotations  }}</p>
                            @else
                            <p class="text-info">Note: This section only shows if applicable</p>
                            @endif


                        </section>
                    </div>

                </section>
            </section>
        </aside>
        <aside class="bg-white aside-lg b-l hide" id="aside-files">
            <header class="bg-white header b-b b-light">
                @can('files_create')
                <a href="{{  route('files.upload', ['module' => 'contracts', 'id' => $contract->id])  }}" data-placement="left" data-rel="tooltip" title="@langapp('upload_file')"
                    data-toggle="ajaxModal" class="btn {{themeButton()}} pull-right">
                    @icon('solid/file-upload')
                </a>
                @endcan
                <p>@langapp('files')</p>
            </header>
            <div class="m-xs">
                @include('partial._show_files', ['files' => $contract->files, 'limit' => true])
            </div>

        </aside>

    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
</section>

@push('pagescript')
@include('stacks.js.signature')
@endpush
@endsection