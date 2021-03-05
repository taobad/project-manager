@extends('layouts.app')
@section('content')
<section id="content">
  <section class="hbox stretch">
    <aside class="lter b-l">
      <section class="vbox">
        <header class="px-2 pb-2 bg-white border-b border-gray-400 panel-heading">
          <div class="flex justify-between text-gray-500">
            <div>
              <span class="text-xl">Bulk Send Emails</span>
            </div>
          </div>
        </header>
        <section class="scrollable wrapper bg">
          <div class="panel panel-body">


            <section class="panel panel-default">


              <header class="panel-heading"><span class="text-dracula">{{ $contacts->count() }} @langapp('contacts')</span></header>
              {!! Form::open(['route' => 'contacts.bulk.send', 'class' => 'bs-example ajaxifyForm', 'data-toggle' => 'validator']) !!}

              <div class="panel-body">

                <div class="form-group">
                  <label class="control-label">@langapp('contacts') @required</label>
                  <select class="select2-option width100" multiple="multiple" name="contacts[]">
                    @foreach ($contacts as $contact)
                    <option value="{{ $contact->id }}" selected>{{ $contact->name }} &laquo;{{ $contact->email }}&raquo;</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label class="control-label">@langapp('subject') @required</label>
                  <input type="text" name="subject" class="form-control">
                </div>
                <div class="form-group">
                  <label class="control-label">BCC</label>
                  <input type="text" name="bcc" placeholder="you@domain.com" class="form-control">
                </div>
                @if(count(Auth::user()->cannedResponses) > 0)
                <select name="selectCanned" class="form-control m-b" id="insertCannedResponse" onChange="insertCannedMessage(this.value);">
                  <option value="0">--- @langapp('canned_responses') ---</option>
                  @foreach (Auth::user()->cannedResponses as $template)
                  <option value="{{ $template->id }}">{{ $template->subject }}</option>
                  @endforeach
                </select>
                @endif
                <div class="form-group">
                  <label class="control-label">@langapp('message') @required</label>
                  <x-inputs.wysiwyg name="message" class="{{ get_option('htmleditor') }}" id="{{get_option('htmleditor')}}">
                  </x-inputs.wysiwyg>
                </div>

                <div class="form-group display-none" id="queueLater">
                  <label>{{ langapp('schedule') }}</label>
                  <div class="input-group date">
                    <input type="text" class="form-control datetimepicker-input" value="{{ timePickerFormat(now()) }}" name="later_date"
                      data-date-format="{{ strtoupper(get_option('date_picker_format')) }} hh:mm A" data-date-start-date="0d">
                    <div class="input-group-addon">
                      @icon('solid/calendar-alt', 'text-muted')
                    </div>
                  </div>
                </div>



              </div>
              <div class="panel-footer">
                {!! renderAjaxButton('send') !!}
                <a href="#" id="sendLater" class="btn {{themeButton()}} pull-right">@icon('solid/clock') @langapp('send_later')</a>
              </div>
              {!! Form::close() !!}
            </section>


          </div>
        </section>
      </section>
    </aside>
  </section>
</section>
@push('pagestyle')
@include('stacks.css.form')
@include('stacks.css.datepicker')
@include('stacks.css.wysiwyg')
@endpush
@push('pagescript')
@include('stacks.js.form')
@include('stacks.js.wysiwyg')
@include('stacks.js.datepicker')
<script type="text/javascript">
  $('.datetimepicker-input').datetimepicker({showClose: true, showClear: true, minDate: moment() });
  $( "#sendLater" ).click(function() {
  $("#queueLater").show("fast");
    $( ".datetimepicker-input" ).focus();
  });
</script>
@endpush
@endsection