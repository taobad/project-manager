@foreach ($expenses->chunk(2) as $chunk)
<div class="row">
    @foreach ($chunk as $expense)
    <div class="col-md-6">
        <div class="panel invoice-grid widget-b">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <h6 class="">
                            <a class="{{themeLinks('font-semibold')}}" href="{{route('expenses.view', $expense->id)}}">
                                {{$expense->AsCategory->name}}
                            </a>
                            @if ($expense->is_recurring)
                            @icon('solid/sync-alt', 'text-red-600')
                            @endif
                        </h6>
                        <ul class="list list-unstyled">
                            <li>@langapp('currency') : &nbsp;{{$expense->currency}}</li>
                            <li>@langapp('user') : <span class="">
                                    {{$expense->user->name}}</span>
                            </li>
                        </ul>
                    </div>

                    <div class="col-sm-6">

                        <h6 class="font-semibold text-right text-gray-600 no-margin-top">
                            {{formatCurrency($expense->currency, $expense->amount)}}
                        </h6>
                        <ul class="text-right list list-unstyled">
                            <li>@langapp('billed') : <span class="text-success">
                                    {{$expense->invoiced === 1 ? langapp('yes') : langapp('no') }}</span>
                            </li>
                            <li>@langapp('billable') : <span class="label label-danger">
                                    {{$expense->billable === 1 ? langapp('yes') : langapp('no') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="px-2 py-3 bg-gray-200 border-t border-gray-200 rounded-b-sm">
                <a class="heading-elements-toggle"></a>
                <div class="m-1 heading-elements">
                    <span class="heading-text">
                        <span class="status-mark border-danger position-left"></span> @langapp('date') :
                        <span class="font-semibold text-gray-600">{{dateFormatted($expense->expense_date)}}</span>
                    </span>

                    <a href="{{ route('expenses.view', $expense->id) }}" class="btn {{themeButton()}} pull-right">@icon('solid/laptop') @langapp('preview') </a>


                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endforeach