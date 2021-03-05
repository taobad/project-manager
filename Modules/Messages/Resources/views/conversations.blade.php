@extends('layouts.app')
@section('content')
<section id="content">
  <section class="hbox stretch">
    <aside class="aside-lg" id="subNav">
      <header class="dk header b-b">
        <div class="padder-v">@langapp('messages') <a href="{{ route('messages.new') }}" class="btn {{themeButton()}} pull-right">
            @icon('solid/paper-plane') @langapp('send') </a>
        </div>


      </header>
      <section class="scrollable">
        <section class="slim-scroll msg-thread" data-height="500px">

          @include('messages::threads')

        </section>
      </section>
    </aside>
    <aside class="lter b-l" id="email-list">
      <section class="vbox">
        <header class="clearfix bg-white header b-b">
          <div class="row m-t-sm">
            <div class="col-sm-4 col-sm-offset-8 m-b-xs">


            </div>
          </div>
        </header>
        <section class="scrollable wrapper bg">

          <div class="chat-history conversations">

            <section class="chat-list panel-body" id="msg-list">


              @include('messages::partials.search')


              <ul id="talkMessages" class="list">
                @foreach($messages as $message)

                @if($message->sender->id == Auth::id())
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
                          <a class="message-data-name talkDeleteMessage" href="#" data-message-id="{{$message->id}}" data-toggle="tooltip" title="Delete Message">
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

                @else
                <article id="message-{{$message->id}}" class="chat-item right">
                  <div class="message-data">
                    <a href="#" class="pull-right thumb-sm avatar">
                      <img src="{{ $message->sender->profile->photo }}" class="img-circle"></a>

                    <section class="chat-body">
                      <div class="mb-1 text-sm text-gray-100 bg-gray-600 shadow-md panel">
                        <div class="panel-body">
                          <span class="arrow right"></span>
                          <div class="mb-3 leading-5 message my-message">
                            @parsedown($message->message)
                          </div>
                          <div class="flex justify-between text-gray-400">
                            {{ $message->sender->name }}
                            <a class="message-data-name hover:text-indigo-100 talkDeleteMessage" href="#" data-message-id="{{$message->id}}" data-toggle="tooltip"
                              title="Delete Message">
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
                  </div>
                </article>

                @endif
                {{ $message->user_id != Auth::id() ? Modules\Messages\Facades\Talk::makeSeen($message->id) : '' }}

                @endforeach
              </ul>
            </section>



            <article class="clearfix chat-item chat-message" id="chat-form">
              <a class="pull-left thumb-sm avatar">
                <img src="{{ avatar() }}" class="img-circle"></a>
              <section class="chat-body">
                <form class="m-b-none" method="post" id="talkSendMessage">
                  {{ csrf_field() }}
                  <input type="hidden" name="_id" value="{{@request()->route('id')}}">

                  <input type="hidden" name="to[]" value="{{@request()->route('id')}}">

                  <x-inputs.wysiwyg name="message-data" class="{{ get_option('htmleditor') }}" id="message-data">
                  </x-inputs.wysiwyg>

                  <div class="line"></div>
                  {!! renderAjaxButton('send') !!}
                </form>
              </section>
            </article>
          </div>

        </section>
      </section>
    </aside>
  </section>

  <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>

</section>

@push('pagestyle')
@include('stacks.css.wysiwyg')
@endpush

@push('pagescript')

@include('stacks.js.wysiwyg')

@include('stacks.js.list')
@include('stacks.js.talk')

<script>
  var options = {
            valueNames: [ 'message' ]
        };

        var msgList = new List('msg-list', options);
      
      function pusherCallback(data) {
        var from = data.sender.id;
        $.ajax({
            type: 'POST',
            url: '/messages/pusher-message/' +data.id,
            data: {
              id: data.id,
              _token: '{{ csrf_token() }}'
            },
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json', 
            success: function(data){
                  toastr.info( data.sender +' has sent you a message' , 'Message Received');
                   $('#talkMessages').append(data.html);
            },

      
      });
      };
</script>
@endpush

@endsection