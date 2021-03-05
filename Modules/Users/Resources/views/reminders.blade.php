@extends('layouts.app')
@section('content')
<section id="content">
    <section class="hbox stretch">
        <aside>
            <section class="vbox">
                <header class="px-2 pb-2 bg-white border-b border-gray-400 panel-heading">
                    <div class="flex justify-between text-gray-500">
                        <div>
                            <span class="text-xl font-semibold text-gray-600">@langapp('reminders')</span>
                        </div>
                        <div>
                            @admin
                            <a href="{{ route('notifications.preferences') }}" class="btn {{themeButton()}}">
                                @icon('solid/cogs') @langapp('notifications')
                            </a>
                            @endadmin
                        </div>
                    </div>
                </header>


                <section class="scrollable wrapper bg">

                    @foreach (Auth::user()->reminders as $reminder)
                    <article class="media">
                        <span class="pull-left thumb-sm">
                            <img src="{{ $reminder->recipient->profile->photo }}" data-rel="tooltip" title="{{ $reminder->recipient->name }}" data-placement="right"
                                class="img-circle"></span>
                        <div class="media-body">
                            <div class="text-center pull-right media-xs text-muted">
                                <strong class="h4">{{ dateTimeFormatted($reminder->reminder_date) }}</strong><br>
                                <span class="label bg-light">{{ dateElapsed($reminder->reminder_date) }}</span>
                            </div>
                            <a href="#" class="h4">{{ $reminder->remindable->name }}</a>
                            <span class="block"><a href="#" class="">{{ $reminder->user->name }}</a></span>
                            <span class="block mt-1 text-gray-600">
                                @parsedown($reminder->description)
                            </span>
                        </div>
                    </article>
                    <div class="line pull-in"></div>
                    @endforeach




                </section>
            </section>
        </aside>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
</section>
@endsection