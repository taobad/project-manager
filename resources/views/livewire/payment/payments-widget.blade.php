<div class="flex flex-col">
    @if ($payments->count())
    <div class="py-1 sm:-mx-6 sm:px-2 lg:-mx-8 lg:px-3">
        <div class="inline-block min-w-full overflow-hidden align-middle border-b border-gray-200 shadow sm:rounded-lg">
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-xs leading-4 tracking-wider text-left text-gray-600 uppercase bg-gray-200 border-b border-gray-200">
                            @langapp('payments')
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment)

                    <tr class="bg-white">
                        <td class="px-6 py-4 text-sm font-medium leading-5 text-gray-900 border-b border-gray-200">

                            <div class="flex">
                                <div class="mr-2">
                                    @icon('regular/check-circle','inline w-8 h-8 '.themeText('opacity-75'))
                                </div>

                                <div class="flex flex-col flex-1 min-w-0">
                                    <p class="flex text-sm">
                                        <span class="text-gray-500 truncate">
                                            <span class="">
                                                <a href="{{route('payments.view',$payment->id)}}" class="{{themeLinks('font-semibold')}}">{{$payment->code}}</a>
                                            </span>
                                            <span class="pl-1 text-xs text-gray-800">{{ $payment->payment_date->toFormattedDateString() }}</span>
                                        </span>
                                        <span class="flex-shrink-0">
                                            <span class="px-1 text-gray-500">
                                                <i class="text-xs far fa-dot-circle"></i>
                                            </span>
                                            <span class="text-xs text-gray-600">{{ $payment->payment_date->diffForHumans() }}</span>
                                        </span>
                                    </p>

                                    <div class="text-sm leading-tight tracking-wide text-gray-600 hover:text-gray-700">
                                        <strong>{{ $payment->company->name }}</strong> paid <strong>{{ formatCurrency($payment->currency, $payment->amount) }}</strong> on
                                        <strong>{{ $payment->payment_date->toFormattedDateString() }}</strong> via
                                        <strong>{{ $payment->paymentMethod->method_name }}</strong>
                                    </div>
                                    <a href="{{route('invoices.view',$invoice->id)}}" class="{{themeLinks('font-semibold')}}">@langapp('invoice') # {{$invoice->reference_no}}</a>
                                </div>
                            </div>

                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="px-4 py-2 text-gray-600">
                {{ $payments->links() }}
            </div>
        </div>

    </div>

    @else

    <div>
        <p class="text-base text-gray-600">
            No payments received yet
        </p>
    </div>
    @endif

</div>