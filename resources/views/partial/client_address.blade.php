<address>
    <strong class="text-indigo-600 uppercase">{{ $company->name }}</strong><br>
    @if(!empty($company->address1))
    {!! nl2br($company->address1) !!}, <br>
    @endif
    @if(!empty($company->address2))
    {!! nl2br($company->address2) !!}<br>
    @endif
    {{ $company->city }} {{ ($company->state != '') ? ', '.$company->state : '' }}
    {{ ($company->zip_code != '') ? $company->zip_code : '' }}<br>
    @if (!empty($company->country))
    {{  $company->country  }}<br>
    @endif
    @if (!empty($company->phone))
    <abbr title="Phone">P:</abbr> <a href="">{{ $company->phone }}</a>
    <br>
    @endif
    @if (!empty($company->fax))
    @langapp('fax') : <a href="tel:{{  $company->fax }}">{{  $company->fax  }}</a><br>
    @endif
    @if (!empty($company->tax_number))
    @langapp('tax_number') : {{  $company->tax_number  }}<br>
    @endif
</address>
@if($company->primary_contact)
<address>
    <strong>@langapp('contact_person') </strong><br>
    <a class="text-indigo-600" href="mailto:{{ $company->contact->email }}">{{ $company->contact->name }}</a>
</address>
@endif