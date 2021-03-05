 <span class="inv-text text-uc">{{ $company->name }}</span><br>
    @if(!empty($company->address1))
    {{ $company->address1 }}, <br>
    @endif
    @if(!empty($company->address2))
    {{ $company->address2 }}<br>
    @endif
    {{ $company->city }} {{ ($company->state != '') ? ', '.$company->state : '' }} {{ ($company->zip_code != '') ? $company->zip_code : '' }}<br>
    @if (!empty($company->country))
    {{  $company->country  }}<br>
    @endif
    @if (!empty($company->phone))
    <abbr title="Phone">@langapp('phone_short')</abbr> <a href="">{{ $company->phone }}</a>
    <br>
    @endif
    @if (!empty($company->fax))
    @langapp('fax')  : <a href="tel:{{  $company->fax }}">{{  $company->fax  }}</a><br>
    @endif
    @if (!empty($company->tax_number))
    @langapp('tax_number') : {{  $company->tax_number  }}<br>
    @endif
