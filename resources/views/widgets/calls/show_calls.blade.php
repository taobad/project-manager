@foreach ($calls as $call)
<li class="dd-item dd3-item" data-id="{{ $call->id }}" id="call-{{ $call->id }}">

  <span class="pull-right m-xs">
    @if ($call->user_id === Auth::id() || isAdmin())
    <a href="{{ route('extras.call.edit', $call->id) }}" data-toggle="ajaxModal" data-rel="tooltip" title="@langapp('make_changes')">
      @icon('solid/pencil-alt', 'text-gray-600 fa-fw m-r-xs')
    </a>
    @endif


    @if ($call->user_id === Auth::id() || isAdmin())
    <a href="#" class="deleteCall" data-call-id="{{$call->id}}" data-rel="tooltip" title="@langapp('delete')">
      @icon('solid/times', 'text-gray-600 fa-fw m-r-xs')
    </a>
    @endif
  </span>

  <div class="dd3-content">
    <label>
      <span class="label-text">
        <span id="call-id-{{ $call->id }}">
          <span class="" data-rel="tooltip" title="{{ ucfirst($call->type) }}">@icon('solid/signal', 'text-muted')</span> {{ $call->subject }}
          <small class="text-muted small m-l-sm">@icon('solid/phone-volume') {{ gmsec($call->duration) }} - {{ $call->agent->name }}</small>
          @if(!is_null($call->scheduled_date))
          @icon('solid/calendar-check', 'text-danger')
          @endif
        </span>
      </span>
    </label>
    @if(!empty($call->description))
    <p class="m-xs">@parsedown($call->description)</p>
    @endif
    @if(!empty($call->result))
    <blockquote>@parsedown($call->result)</blockquote>
    @endif

    @if(!is_null($call->started_at))
    <div class="m-xs">
      @icon('solid/phone-volume', 'text-success') Called {{ $call->started_at->toDateTimeLocalString() }} - {{ $call->ended_at->toDateTimeLocalString() }}
    </div>
    @endif

    <div class="m-xs">
      @php
      $data['tags'] = $call->tags;
      @endphp
      @include('partial.tags', $data)
    </div>

    <section class="block comment-list">

      @widget('Comments\ShowComments', ['comments' => $call->comments])

    </section>

  </div>

</li>
@endforeach