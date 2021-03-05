<ul id="chatMessages" class="list chat-list conversations">
  @foreach($chats as $message)

  @if($message->inbound)
  <article id="message-{{$message->id}}" class="chat-item left">
    <a href="#" class="pull-left thumb-sm avatar">
      <img src="{{ $message->chatable->photo }}" class="img-circle"></a>

    <section class="chat-body">
      <div class="text-sm panel b-light m-b-none">
        <div class="panel-body">
          <span class="arrow left"></span>
          <div class="message other-message m-b-sm">
            @parsedown($message->message)
          </div>

          <span class="message-data-name">
            @if($message->user_id == Auth::id() || isAdmin())
            <a href="#" class="deleteChat" data-message-id="{{$message->id}}" title="Delete Message">
              @icon('solid/trash-alt', 'text-danger pull-right')
            </a>
            @endif
            @icon('solid/phone') From : {{ $message->from }}

            <small class="text-muted message-data-time m-l-lg">
              @icon('solid/calendar-alt') {{ $message->created_at->diffForHumans() }}
            </small>
            @if(!$message->read)
            <span class="badge bg-danger m-l-lg">@langapp('new')</span>
            @endif
          </span>

          @include('partial._show_files', ['files' => $message->files, 'limit' => true])
        </div>
      </div>


    </section>
  </article>

  @else
  <article id="message-{{$message->id}}" class="chat-item right">
    <div class="message-data">
      <a href="#" class="pull-right thumb-sm avatar">
        <img src="{{ $message->user->profile->photo }}" class="img-circle"></a>

      <section class="chat-body">
        <div class="text-sm panel bg m-b-none sms-bg1">
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
                <i class="fas fa-check-double" data-rel="tooltip" title="Delivered"></i>
                @else
                <i class="fas fa-exclamation-circle" data-rel="tooltip" title="Not Delivered"></i>
                @endif
              </span>


            </span>

            @include('partial._show_files', ['files' => $message->files, 'limit' => true])

          </div>

        </div>

      </section>
    </div>
  </article>

  @endif



  {{ $message->markRead() }}

  @endforeach
</ul>