<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>@langapp('contract') {{ $contract->contract_title }}</title>
@php
ini_set('memory_limit', '-1');
$color = config('system.contract_color');
@endphp

<head>
  <link rel="stylesheet" href="{{ getAsset('css/contract-pdf.css') }}">
  <style>
    body,
    h2,
    h3,
    h4 {
      font-family: '{{ config('system.pdf_font') }}';
    }

    .color {
      color: {{ $color }};
    }

    .bg-color {
      background-color: {{ $color }} !important;
      color: #ffffff;
    }

    footer {
      border-top: 1px solid {{ $color }};
    }

    .contract-title {
      border-bottom: 0.2mm solid {{ $color }};
    }

    .attachment {
      border-bottom: 0.2mm solid {{ $color }};
    }

    .width200 {
      width: 200px;
    }
  </style>
</head>

<body>

  <div class="contract-page">

    <h1 class="text-center">@langapp('service_contract')</h1>
    <h2 class="contract-title text-uc text-bold">{{ $contract->contract_title }}</h2>

    <div class="m-20"></div>

    @php
      $data['company'] = $contract->company;
    @endphp
    <div class="row">
      <div class="col-md-6 width40" style="float:left">
        <div class="h4 text-bold text-uc">@langapp('client')</div>
        <div class="m-md">
          {!! formatClientAddress($contract, 'invoice', 'billing', false) !!}
            @if($contract->company->primary_contact)
                <address class="mt-3">
                    <strong>@langapp('contact_person') </strong><br>
                    <a class="text-indigo-600" href="mailto:{{ $contract->company->contact->email }}">
                      {{ $contract->company->contact->name }}
                    </a>
                </address>
            @endif
        </div>

      </div>
      <div class="col-md-6 width40" style="float: right">
        <div class="h4 text-bold text-uc">@langapp('contractor')</div>
        <div class="m-md">
          {!! formatCompanyAddress($data) !!}
          @if(get_option('contact_person'))
              <address class="mt-3">
                  <strong>@langapp('contact_person') </strong><br>
                  <a class="text-indigo-600" href="mailto:{{ get_option('company_email') }}">
                    {{ get_option('contact_person') }}
                  </a>
              </address>
          @endif
        </div>
      </div>
    </div>


  </div>

  <div class="clear" style="clear: both"></div>

  <div class="contract-page">
    <h3>Attachment A:</h3>
    <h2 class="h3">Services</h2>
    <div class="">
      <p class="m-t-sm">Contractor agrees to perform services as described in Attachment A (the “Services”)
        and Client agrees to pay Contractor as described in Attachment A.</p>
      <div class="">Term</div>
      <div class="m-b-20">@langapp('start_date'):
        <strong>{{  dateFormatted($contract->start_date)  }}</strong> - @langapp('end_date'):
        <strong>{{  dateFormatted($contract->end_date)  }}</strong>
      </div>
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
      <div class="h3 pb15">@langapp('description')</div>
      <div class="m-b-20">
        {!! $contract->description !!}
      </div>
    </div>





  </div>

  <div class="page-break" style="page-break-after: always;"></div>

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

  <div class="clear"></div>

  <div class="row">
    <div class="col-md-6 width40" style="float: left">
      @langapp('client') ({{ $contract->company->contact_person }})<br>
      @if ($contract->client_sign_id > 0)
      Signature - {{ dateTimeFormatted($contract->clientSign->created_at) }}
      @endif
      <div class="signatureSec">
        <div class="col-md-8">
          @if ($contract->client_sign_id > 0)
          <div class="signature">
            @if($contract->clientSign->image)
            <img src="{{ $clientSignature }}" class="width200" alt="">
            @else
            <div class="m-t-40">{{  $contract->clientSign->signature  }}</div>
            @endif
          </div>
          @else
          <div class="line line-dashed line-lg pull-in m-t-40"></div>
          @endif

        </div>

      </div>
    </div>
    <div class="col-md-6 width40" style="float: left">
      @langapp('contractor') ({{ get_option('contact_person') }})<br>
      @if ($contract->contractor_sign_id > 0)
      Signature - {{ dateTimeFormatted($contract->contractorSign->created_at) }}
      @endif
      <div class="signatureSec">
        <div class="col-md-8">
          @if ($contract->contractor_sign_id > 0)
          <div class="signature">
            @if($contract->contractorSign->image)
            <img src="{{ $contractorSignature }}" class="width200" alt="">
            @else
            <div class="m-t-45">{{ $contract->contractorSign->signature }}</div>
            @endif
          </div>


          @else
          <div class="line line-dashed line-lg pull-in m-t-40"></div>
          @endif
        </div>
      </div>
    </div>
  </div>


</body>

</html>