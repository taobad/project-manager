@extends('layouts.app')
@section('content')
<section id="content" class="bg">
    <section class="vbox">
        <header class="px-2 pb-2 bg-white border-b border-gray-400 panel-heading">
            <div class="flex justify-between text-gray-500">
                <div>
                    <span class="text-xl text-gray-600">{{ $lead->name }}</span>
                    <span class="p-1 ml-3 rounded-md bg-dark">
                        @langapp($lead->rating_status) @icon('solid/fire','text-'.leadRatingClr($lead->rating_status))
                    </span>
                </div>
                <div>
                    @can('reminders_create')
                    <a class="btn {{themeButton()}}" data-toggle="ajaxModal" data-rel="tooltip" data-placement="bottom"
                        href="{{  route('calendar.reminder', ['module' => 'leads', 'id' => $lead->id])  }}" title="@langapp('set_reminder')">
                        @icon('solid/clock')
                    </a>
                    @endcan
                    @can('leads_update')
                    <a href="{{ route('leads.edit', ['lead' => $lead->id]) }}" class="btn {{themeButton()}}" data-toggle="ajaxModal">
                        @icon('solid/pencil-alt') @langapp('edit') </a>
                    @endcan
                    @can('deals_create')
                    <a href="{{ route('leads.convert', ['lead' => $lead->id]) }}" class="btn {{themeButton()}}" data-toggle="ajaxModal">
                        @icon('solid/check-circle') @langapp('convert')
                    </a>
                    @endcan
                    @can('leads_update')
                    <a href="{{ route('leads.nextstage', ['lead' => $lead->id]) }}" class="btn {{themeButton()}}" data-toggle="ajaxModal">
                        @icon('solid/arrow-alt-circle-right') @langapp('next_stage')
                    </a>
                    @endcan
                    @can('leads_delete')
                    <a href="{{ route('leads.delete', ['lead' => $lead->id]) }}" class="btn {{themeButton()}}" data-toggle="ajaxModal">
                        @icon('solid/trash-alt')
                    </a>
                    @endcan
                </div>
            </div>
        </header>

        <section class="scrollable wrapper">

            <div class="sub-tab m-b-10">
                <ul class="nav pro-nav-tabs nav-tabs-dashed">
                    <li class="{{  ($tab == 'overview') ? 'active' : '' }}">
                        <a href="{{  route('leads.view', ['lead' => $lead->id, 'tab' => 'overview'])  }}">@icon('solid/home') @langapp('overview') </a>
                    </li>

                    <li class="{{  ($tab == 'calls') ? 'active' : ''  }}">
                        <a href="{{  route('leads.view', ['lead' => $lead->id, 'tab' => 'calls'])  }}">@icon('solid/phone') @langapp('calls')
                        </a>
                    </li>

                    <li class="{{  ($tab == 'conversations') ? 'active' : ''  }}">
                        <a href="{{  route('leads.view', ['lead' => $lead->id, 'tab' => 'conversations'])  }}">
                            @icon('solid/envelope-open') @langapp('emails')
                            {!! $lead->has_email ? '<i class="fas fa-bell text-danger"></i>' : '' !!}
                        </a>
                    </li>
                    <li class="{{  ($tab == 'activity') ? 'active' : ''  }}">
                        <a href="{{  route('leads.view', ['lead' => $lead->id, 'tab' => 'activity'])  }}">
                            @icon('solid/tasks') @langapp('checklist')
                            {!! $lead->has_activity ? '<i class="fas fa-bell text-danger"></i>' : '' !!}
                        </a>
                    </li>
                    <li class="{{  ($tab == 'files') ? 'active' : ''  }}">
                        <a href="{{  route('leads.view', ['lead' => $lead->id, 'tab' => 'files'])  }}">
                            @icon('solid/file-alt') @langapp('files') </a>
                    </li>
                    <li class="{{  ($tab == 'comments') ? 'active' : ''  }}">
                        <a href="{{  route('leads.view', ['lead' => $lead->id, 'tab' => 'comments'])  }}">
                            @icon('solid/comments') @langapp('comments')
                        </a>
                    </li>
                    <li class="{{  ($tab == 'calendar') ? 'active' : ''  }}">
                        <a href="{{  route('leads.view', ['lead' => $lead->id, 'tab' => 'calendar'])  }}">
                            @icon('solid/calendar-alt') @langapp('calendar')
                        </a>
                    </li>
                    <li class="{{  ($tab == 'whatsapp') ? 'active' : ''  }}">
                        <a href="{{  route('leads.view', ['lead' => $lead->id, 'tab' => 'whatsapp'])  }}">
                            @icon('brands/whatsapp','text-success') Whatsapp
                        </a>
                    </li>
                    <li class="{{  ($tab == 'sms') ? 'active' : ''  }}">
                        <a href="{{  route('leads.view', ['lead' => $lead->id, 'tab' => 'sms'])  }}">
                            @icon('solid/sms') SMS
                        </a>
                    </li>
                </ul>
            </div>
            @include('leads::tab._'.$tab)

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