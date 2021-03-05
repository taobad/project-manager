@extends('layouts.app')
@section('content')
<section id="content">
  <section class="hbox stretch">
    <section class="vbox">
      <header class="clearfix bg-white header b-b">
        <div class="row m-t-sm">
          <div class="col-sm-8 m-xs">
            <strong>@langapp('contract') @langapp('templates')</strong>
          </div>
          <div class="col-sm-4 m-b-xs">
          </div>
        </div>
      </header>
      <section class="scrollable wrapper bg" id="messages">
        {!! Form::open(['route' => 'contracts.saveTemplate', 'novalidate' => '', 'id' => 'save-template']) !!}
        <div class="form-group">
          <label class="control-label">@langapp('name') @required</label>
          <input type="text" class="form-control" name="name" placeholder="Web Design Contract" required>
        </div>
        <div class="form-group">
          <label class="control-label">@langapp('contract') @langapp('message') @required</label>
          <x-inputs.wysiwyg name="body" class="{{ get_option('htmleditor') }}" id="{{ get_option('htmleditor') }}">

          </x-inputs.wysiwyg>
        </div>
        <div class="text-muted m-xs">
          Available tags: <br>
          {EXPIRY_DATE}, {TERM_DAYS},{CANCEL_FEE},{PAYMENT_DAYS},{LATE_FEE},{DEPOSIT_FEE},{FEEDBACKS},
          {CLIENT_RIGHTS},{CONTACT_PERSON},{TITLE},{START_DATE},{END_DATE},{DESCRIPTION},{CURRENCY},
          {SERVICES}
        </div>

        <footer class="panel-footer bg-light lter m-b-sm">
          {!! renderAjaxButton() !!}
          <ul class="nav nav-pills nav-sm"></ul>
        </footer>
        {!! Form::close() !!}
        <div class="panel-group m-b" id="accordion2">
          <div class="input-group m-b-sm">
            <input type="text" class="form-control search" placeholder="Search by Name or Text">
            <span class="input-group-btn">
              <button type="submit" class="btn {{themeButton()}} btn-icon">@icon('solid/search')</button>
            </span>
          </div>
          <ul class="list no-style" id="template-list">
            @foreach (Modules\Contracts\Entities\ContractTemplate::get() as $text)
            <li class="panel panel-default" id="template-{{ $text->id }}">
              <div class="panel-heading">
                <a class="accordion-toggle subject" data-toggle="collapse" data-parent="#accordion2" href="#{{ slugify($text->name) }}">
                  @icon('solid/pen-alt') {{ $text->name }}
                </a>
                <a href="#" class="delete-template pull-right text-muted" data-template-id="{{$text->id}}">@icon('solid/trash-alt')</a>
                <a href="{{ route('contracts.editTemplate', $text->id) }}" class="pull-right text-muted m-l-xs">@icon('solid/pencil-alt')</a>
              </div>
              <div id="{{ slugify($text->name) }}" class="panel-collapse collapse">
                <div class="panel-body message">
                  {!! $text->body !!}
                </div>

              </div>
            </li>
            @endforeach
          </ul>
        </div>
      </section>
    </section>
  </section>
  <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
</section>
@push('pagestyle')
@include('stacks.css.wysiwyg')
@endpush
@push('pagescript')
@include('stacks.js.wysiwyg')
<script src='{{ getAsset('plugins/apps/list.min.js') }}'></script>
<script>
  var options = {
valueNames: [ 'subject', 'message' ]
};
var ResponseList = new List('messages', options);
</script>
@include('contracts::_ajax.saveTemplate')
@endpush
@endsection