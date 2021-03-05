<article id="message-{{$message->id}}" class="chat-item left">
  <a href="#" class="pull-left thumb-sm avatar">
    <img src="{{ $message->sender->profile->photo }}" class="img-circle"></a>

  <section class="chat-body">
    <div class="mb-1 text-sm bg-white shadow-md panel">
      <div class="panel-body">
        <span class="arrow left"></span>
        <div class="mb-3 message other-message">
          @parsedown($message->message)
        </div>

        <div class="flex justify-between text-gray-500">
          {{ $message->sender->name }}
          <a class="message-data-name" href="#" class="talkDeleteMessage" data-message-id="{{$message->id}}" data-toggle="tooltip" title="Delete Message">
            @icon('solid/trash-alt')
          </a>

        </div>
        @include('partial._show_files', ['files' => $message->files, 'limit' => true])
      </div>
    </div>
    <small class="text-gray-600 message-data-time">
      @icon('solid/calendar-alt') {{ $message->created_at->diffForHumans() }}
    </small>

  </section>
</article>