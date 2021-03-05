@extends('layouts.app')
@section('content')
<section id="content">
  <section class="hbox stretch">
    <aside class="lter b-l">
      <section class="vbox">
        <header class="clearfix bg-white header b-b">
          <div class="row m-t-sm">
            <div class="col-sm-12 m-b-xs">
              <p class="h3">@langapp('send') SMS</p>
            </div>
          </div>
        </header>
        <section class="scrollable wrapper bg">
          <div class="panel panel-body">


            <section class="panel panel-default">


              <header class="panel-heading"><span class="text-dracula">{{ $contacts->count() }} @langapp('contacts')</span></header>
              {!! Form::open(['route' => 'contacts.bulk.send.sms', 'class' => 'bs-example ajaxifyForm', 'data-toggle' => 'validator']) !!}

              <div class="panel-body">

                <div class="form-group">
                  <label class="control-label">@langapp('contacts') @required</label>
                  <select class="select2-option width100" multiple="multiple" name="contacts[]">
                    @foreach ($contacts as $contact)
                    <option value="{{ $contact->id }}" selected>{{ $contact->name }} &laquo;{{ $contact->profile->mobile }}&raquo;</option>
                    @endforeach
                  </select>
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
                  <label class="control-label">@langapp('message') @required <em>(A text message can hold up to 160 characters.)</em> </label>
                  <x-inputs.textarea name="message" class="ta" id="sms">
                  </x-inputs.textarea>
                </div>

              </div>
              <div class="panel-footer">
                {!! renderAjaxButton('send') !!}
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
@endpush
@push('pagescript')
@include('stacks.js.form')
@include('stacks.js.wysiwyg')
@include('stacks.js.datepicker')
<script type="text/javascript">
  $('.datetimepicker-input').datetimepicker({showClose: true, showClear: true, minDate: moment() });
</script>
@endpush
@endsection