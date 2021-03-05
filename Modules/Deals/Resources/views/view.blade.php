@extends('layouts.app')

@section('content')

<section id="content" class="bg">

    <section class="vbox">
        <header class="px-2 pb-2 bg-white border-b border-gray-400 panel-heading">
            <div class="flex justify-between text-gray-500">
                <div>
                    <span class="text-xl font-semibold text-gray-600">{{$deal->title}}</span>
                </div>
                <div>
                    @can('deals_update')

                    @if ($deal->status != 'open')
                    <a href="{{ route('deals.open', ['deal' => $deal->id]) }}" class="btn {{themeButton()}} pull-right">
                        @icon('solid/level-down-alt') @langapp('reopen')
                    </a>
                    @endif

                    @if ($deal->status == 'open')
                    <a href="{{route('deals.lost', ['deal' => $deal->id])}}" class="btn {{themeButton()}}" data-toggle="ajaxModal">
                        @icon('solid/times') @langapp('lost')
                    </a>
                    <a href="{{ route('deals.win', $deal->id) }}" class="btn {{themeButton()}}" data-toggle="ajaxModal">
                        @icon('solid/check-circle') @langapp('won')
                    </a>
                    @endif
                    @endcan

                    @can('reminders_create')
                    <a class="btn {{themeButton()}} pull-right" data-toggle="ajaxModal" data-rel="tooltip" data-placement="bottom"
                        href="{{route('calendar.reminder', ['module' => 'deals', 'id' => $deal->id])}}" title="@langapp('set_reminder')">
                        @icon('solid/clock')
                    </a>
                    @endcan

                    @can('deals_update')
                    <a href="{{route('deals.edit', ['deal' => $deal->id])}}" class="btn {{themeButton()}}" data-toggle="ajaxModal">
                        @icon('solid/pencil-alt') @langapp('edit')
                    </a>
                    @endcan
                    @can('deals_delete')
                    <a href="{{route('deals.delete', ['deal' => $deal->id])}}" class="btn {{themeButton()}}" data-toggle="ajaxModal">
                        @icon('solid/trash-alt')
                    </a>
                    @endcan
                </div>
            </div>
        </header>

        <section class="scrollable wrapper">
            <div class="sub-tab m-b-10">
                <ul class="nav pro-nav-tabs nav-tabs-dashed">
                    <li class="{{($tab == 'overview') ? themeText('font-semibold border-b-2 border-indigo-500') : '' }}">
                        <a href="{{route('deals.view', ['deal' => $deal->id, 'tab' => 'overview'])}}">@icon('solid/home')
                            @langapp('overview') </a>
                    </li>

                    <li class="{{($tab == 'calls') ? themeText('font-semibold border-b-2 border-indigo-500') : ''}}">
                        <a href="{{route('deals.view', ['deal' => $deal->id, 'tab' => 'calls'])}}">@icon('solid/phone')
                            @langapp('calls')
                        </a>
                    </li>

                    <li class="{{($tab == 'emails') ? themeText('font-semibold border-b-2 border-indigo-500') : ''}}">
                        <a href="{{route('deals.view', ['deal' => $deal->id, 'tab' => 'emails'])}}">@icon('solid/envelope-open')
                            @langapp('emails')
                            <span class="label bg-danger">{{ $deal->unreadMessages() ? $deal->unreadMessages() : '' }}</span>
                        </a>
                    </li>

                    <li class="{{($tab == 'activity') ? themeText('font-semibold border-b-2 border-indigo-500') : ''}}">
                        <a href="{{route('deals.view', ['deal' => $deal->id, 'tab' => 'activity'])}}">
                            @icon('solid/tasks') @langapp('checklist')
                            {!! $deal->has_activity ? '<i class="fas fa-bell text-danger"></i>' : '' !!}
                        </a>
                    </li>

                    <li class="{{($tab == 'products') ? themeText('font-semibold border-b-2 border-indigo-500') : ''}}">
                        <a href="{{route('deals.view', ['deal' => $deal->id, 'tab' => 'products'])}}">@icon('solid/shopping-cart')
                            @langapp('products')</a>
                    </li>


                    <li class="{{($tab == 'files') ? themeText('font-semibold border-b-2 border-indigo-500') : ''}}">
                        <a href="{{route('deals.view', ['deal' => $deal->id, 'tab' => 'files'])}}">@icon('solid/cloud-upload-alt')
                            @langapp('files') </a>
                    </li>
                    <li class="{{($tab == 'comments') ? themeText('font-semibold border-b-2 border-indigo-500') : ''}}">
                        @php $count = $deal->comments()->where('unread', 1)->count(); @endphp
                        <a href="{{route('deals.view', ['deal' => $deal->id, 'tab' => 'comments'])}}">
                            @icon('solid/comments') @langapp('comments')
                            {!! ($count > 0) ? '<label class="label bg-success">'.$count.'</label>' : '' !!}
                        </a>
                    </li>

                    <li class="{{($tab == 'calendar') ? themeText('font-semibold border-b-2 border-indigo-500') : ''}}">
                        <a href="{{route('deals.view', ['deal' => $deal->id, 'tab' => 'calendar'])}}">@icon('solid/calendar-alt')
                            @langapp('calendar') </a>
                    </li>

                </ul>
            </div>


            @include('deals::tab._'.$tab)




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