@extends('layouts.public')
@section('content')
<section id="content" class="details-page bg">
    <div class="container clearfix details-container">
        <section class="vbox">
            <header class="header b-b b-light hidden-print">
                <a href="{{ URL::signedRoute('contracts.client.pdf', $contract->id) }}" class="btn {{themeButton()}}">
                    @icon('solid/file-pdf') PDF </a>
                @if ($contract->client_sign_id <= 0 && is_null($contract->rejected_at))
                    @if (!$contract->isExpired() && $contract->company->primary_contact > 0)
                    <a href="{{ URL::signedRoute('contracts.client.approve', $contract->id) }}" data-toggle="ajaxModal" class="btn {{themeButton()}}">@icon('solid/check-circle')
                        @langapp('approve_contract') </a>
                    <a href="{{ URL::signedRoute('contracts.client.dismiss', $contract->id) }}" data-toggle="ajaxModal" class="btn {{themeButton()}}">@icon('solid/times')
                        @langapp('dismiss') </a>
                    @endif
                    @endif
                    <a href="{{ route('contracts.view', $contract->id) }}" class="btn {{themeButton()}} pull-right">
                        @icon('solid/home') @langapp('dashboard')
                    </a>
            </header>
            <div class="wrapper m-t-10">
                <section class="panel panel-body">
                    @if ($contract->client_sign_id > 0)
                    <div class="alert alert-success">
                        <strong> Contract Approved!</strong> This contract was approved on {{ $contract->clientSign->updated_at->toDayDateTimeString() }}
                    </div>
                    @endif
                    @if ($contract->isExpired())
                    <div class="alert alert-danger"><strong> Contract Expired!</strong> This contract expired
                        on {{ dateTimeFormatted($contract->expiry_date) }}</div>
                    @endif
                    @if (!is_null($contract->rejected_at))
                    <div class="alert alert-danger font14"><strong> Contract Rejected!</strong> This contract was rejected
                        on {{ dateTimeFormatted($contract->rejected_at) }}
                        <blockquote class="text-sm">
                            @parsedown($contract->rejected_reason)
                        </blockquote>
                    </div>
                    @endif
                    <p class="h3 display-block">{{ isset($is_due_txt) ? $is_due_txt : '' }} </p>


                    <h1 class="service-contract">@langapp('service_contract')</h1>
                    <h3 class="service-contract m-b-lg">{{  $contract->contract_title  }}</h3>

                    <div class="line line-dashed line-lg pull-in m-t-40"></div>

                    <div class="row pb15">
                        <div class="col-md-6">
                            <div class="h4"><strong>@langapp('client')</strong> (the "Client")</div>
                            <div class="m-md">
                                @php
                                $data['company'] = $contract->company;
                                @endphp
                                @include('partial.client_address', $data)
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="h4"><strong>@langapp('contractor')</strong> (the "Contractor")</div>
                            <div class="m-md">
                                @include('partial.company_address', $data)
                            </div>
                        </div>
                    </div>

                    <h3>Attachment A:</h3>
                    <h2 class="h3">Services</h2>
                    <div class="">
                        <p class="m-t-sm">Contractor agrees to perform services as described in Attachment A (the “Services”)
                            and Client agrees to pay Contractor as described in Attachment A.</p>
                        <div class="">Term</div>
                        <div class="m-b-20">Start date:
                            <strong>{{  dateFormatted($contract->start_date)  }}</strong> - End date:
                            <strong>{{  dateFormatted($contract->end_date)  }}</strong></div>
                        <div class="">Rate</div>
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
                        <div class="h3 pb15">Project details</div>
                        <div class="m-b-20">
                            {!! $contract->description !!}
                        </div>
                    </div>
                    @php
                    $late_fee = ($contract->late_payment_percent == 0) ? formatCurrency($contract->currency, $contract->late_payment_fee) : $contract->late_payment_fee;
                    $texts = [
                    "{EXPIRY_DATE}","{TERM_DAYS}","{CANCEL_FEE}","{PAYMENT_DAYS}","{LATE_FEE}","{DEPOSIT_FEE}","{FEEDBACKS}",
                    "{CLIENT_RIGHTS}","{CONTACT_PERSON}","{TITLE}","{START_DATE}","{END_DATE}","{DESCRIPTION}",
                    "{CURRENCY}","{SERVICES}"
                    ];
                    $data = [
                    dateFormatted($contract->expiry_date), $contract->termination_notice,
                    formatCurrency($contract->currency, $contract->cancelation_fee),
                    $contract->payment_terms, $late_fee, formatCurrency($contract->currency, $contract->deposit_required),
                    $contract->feedbacks, $contract->client_rights,$contract->company->contact_person,
                    $contract->contract_title, dateFormatted($contract->start_date), dateFormatted($contract->end_date),
                    $contract->description, $contract->currency, $contract->services
                    ];
                    @endphp
                    <h3>Attachment B:</h3>
                    {!! str_replace($texts, $data , $contract->template->body) !!}

                    <div class="row pb15">
                        <div class="col-md-6 m-t-lg">
                            <strong>Client</strong> ({{  $contract->company->contact_person }})
                            @if ($contract->client_sign_id > 0)
                            <span class="m-l-sm text-muted small">
                                Signed - <strong>{{  dateTimeFormatted($contract->clientSign->created_at)  }}</strong>
                            </span>
                            @endif
                            <div class="signatureSec">
                                <div class="col-md-8">
                                    @if ($contract->client_sign_id > 0)
                                    <span class="signature">
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
                                Signed - <strong>{{  dateTimeFormatted($contract->contractorSign->created_at)  }}</strong>
                            </span>
                            @endif
                            <div class="signatureSec">
                                <div class="col-md-8">
                                    @if ($contract->contractor_sign_id > 0)

                                    <span class="signature">
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


                    <div class="p-4">
                        @if ($contract->client_sign_id <= 0 && is_null($contract->rejected_at))
                            @if (!$contract->isExpired() && $contract->company->primary_contact > 0)
                            <a href="{{ URL::signedRoute('contracts.client.approve', $contract->id) }}" data-toggle="ajaxModal"
                                class="btn {{themeButton()}}">@icon('solid/check-circle')
                                @langapp('approve_contract') </a>
                            <a href="{{ URL::signedRoute('contracts.client.dismiss', $contract->id) }}" data-toggle="ajaxModal" class="btn {{themeButton()}}">@icon('solid/times')
                                @langapp('dismiss') </a>
                            @endif
                            @endif
                    </div>


                </section>
            </div>
        </section>
    </div>

    {{-- END CONTRACT --}}
    {{ $contract->clientViewed() }}
</section>

@push('pagescript')
@include('stacks.js.signature')
@endpush
@endsection