@extends('layouts.app')
@section('content')
<section id="content">
  <section class="hbox stretch">
    <aside>
      <section class="vbox">
        <header class="px-2 pb-2 bg-white border-b border-gray-400 panel-heading">
          <div class="flex justify-between text-gray-500">
            <div>
              <span class="text-xl font-semibold text-gray-600">@langapp('settings')</span>
            </div>
          </div>
        </header>
        <section class="scrollable wrapper bg w-f">
          @php
          $supportedChannels = config('system.available_channels');
          @endphp

          {!! Form::open(['route' => 'notifications.preferences.save', 'class' => 'ajaxifyForm']) !!}

          <div class="row">
            @php $counter = 0; @endphp
            @foreach (config('notifications.alerts') as $notification)
            @if (!(($counter++) % 2))
          </div>
          <div class="row">
            @endif
            <div class="col-md-6">
              <div class="form-check m-t-xs">
                <label>
                  <input type="checkbox" name="{{ $notification['name'] }}[active]" {!! Auth::user()->notificationActive($notification['name']) ? 'checked' : '' !!} value="1">
                  <span class="label-text"><span class="text-bold">{{ humanize($notification['name']) }}</span> - <small
                      class="text-muted">{{ $notification['description'] }}</small></span>
                </label>
                <div class="row">
                  @php $c = 0; @endphp
                  @foreach ($supportedChannels as $channel)
                  @if (!(($c++) % 2))
                </div>
                <div class="row">
                  @endif
                  <div class="col-md-6">
                    <div class="form-check text-muted m-l-sm">
                      <label>
                        <input type="checkbox" name="{{ $notification['name'] }}[via][{{ $channel }}]" {!! Auth::user()->channelActive($channel, $notification['name']) ? 'checked'
                        : '' !!} value="1">
                        <span class="label-text">Via {{ $channel }}</span>
                      </label>
                    </div>
                  </div>
                  @endforeach
                </div>
                <div class="line"></div>

              </div>

            </div>
            @endforeach
          </div>


        </section>
        <footer class="footer b-t bg-white-only">
          {!! renderAjaxButton() !!}
        </footer>
        {!! Form::close() !!}
      </section>
    </aside>
  </section>
  <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
</section>
@endsection