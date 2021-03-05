@if($invoice->company->primary_contact)
<a class="btn {{themeButton()}} pull-right" data-placement="bottom" data-rel="tooltip" href="{{route('users.impersonate', $invoice->company->contact->id)}}" title="View as Client">
    @icon('solid/user-secret') @langapp('as_client')
</a>
@endif