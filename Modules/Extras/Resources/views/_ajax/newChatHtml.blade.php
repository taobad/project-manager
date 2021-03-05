<article id="message-{{$message->id}}" class="chat-item right">
  <div class="message-data">
    <a href="#" class="pull-right thumb-sm avatar">
      <img src="{{ $message->user->profile->photo }}" class="img-circle"></a>

    <section class="chat-body">
      <div class="text-sm panel bg m-b-none whatapp-chat-bg1">
        <div class="panel-body">
          <span class="arrow right"></span>
          <div class="message my-message m-b-sm">
            @parsedown($message->message)
          </div>
          <span class="message-data-name">
            @if($message->user_id == Auth::id() || isAdmin())
            <a href="#" class="deleteChat" data-message-id="{{$message->id}}" title="Delete Message">
              @icon('solid/trash-alt', 'text-danger pull-right')
            </a>
            @endif

            @icon('solid/mobile-alt') Sender: {{ $message->user->name }}
            <small class="message-data-time m-l-lg">
              @icon('solid/calendar-alt') {{ $message->created_at->diffForHumans() }}
            </small>
            <span class="m-l-lg">
              @if($message->delivered)
              <i class="fas fa-check-double text-info" data-rel="tooltip" title="Delivered"></i>
              @else
              <i class="fas fa-exclamation-circle" data-rel="tooltip" title="Pending Delivery"></i>
              @endif
            </span>

          </span>
          @include('partial._show_files', ['files' => $message->files, 'limit' => true])
        </div>
      </div>

    </section>
  </div>
</article>