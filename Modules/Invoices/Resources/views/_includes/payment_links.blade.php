@if ($invoice->getRawOriginal('status') != 'fully_paid')

<div class="btn-group">
    <button class="btn {{themeButton()}} dropdown-toggle" data-toggle="dropdown">@langapp('pay_invoice') <span class="caret"></span></button>
    <ul class="dropdown-menu">
        @foreach ($invoice->gateways as $key => $gateway)
        @if ($gateway == 'active')
        <li><a href="{{ route('payments.pay', ['invoice' => $invoice->id, 'gateway' => $key])  }}" data-toggle="ajaxModal"
                title="Pay using {{ ucfirst($key) }}">@icon('solid/angle-right', themeText()) {{ ucfirst($key) }}</a>
        </li>
        @endif
        @endforeach

    </ul>
</div>

@endif