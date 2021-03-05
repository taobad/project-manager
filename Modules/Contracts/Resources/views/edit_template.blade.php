@extends('layouts.app')
@section('content')
<section id="content">
  <section class="hbox stretch">
    <section class="vbox">
      <header class="px-2 pb-2 bg-white border-b border-gray-400 panel-heading">
        <div class="flex justify-between text-gray-500">
          <div>
            <strong class="text-xl text-gray-600">{{ $template->name }}</strong>
          </div>
          <div>
            @can('contracts_create')
            <a href="{{route('contracts.templates')}}" class="btn {{themeButton()}}">
              @icon('solid/folder-open') @langapp('templates') </a>
            @endcan
          </div>
        </div>
      </header>
      <section class="scrollable wrapper bg">
        {!! Form::open(['route' => ['contracts.updateTemplate', $template->id], 'novalidate' => '', 'id' => 'update-template']) !!}
        <input type="hidden" name="template_id" value="{{ $template->id }}">
        <div class="form-group">
          <label class="control-label">@langapp('name') @required</label>
          <input type="text" class="form-control" name="name" value="{{ $template->name }}" required>
        </div>
        <div class="form-group">
          <label class="control-label">@langapp('contract') @langapp('message') @required</label>
          <x-inputs.wysiwyg name="body" class="{{ get_option('htmleditor') }}" id="{{ get_option('htmleditor') }}">
            {!! $template->body !!}
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
<script>
  $(document).ready(function () {

        $('#update-template').on('submit', function(e) {
            $(".formSaving").html('Processing..<i class="fas fa-spin fa-spinner"></i>');

            e.preventDefault();
            var tag, data;
            tag = $(this);
            data = tag.serialize();

             axios.post($(this).attr("action"), data)
            .then(function (response) {
                    toastr.success( response.data.message , '@langapp('response_status') ');
                    $(".formSaving").html('<i class="fas fa-paper-plane"></i> @langapp('save') </span>');
                    window.location.href = response.data.redirect;
            })
            .catch(function (error) {
                var errors = error.response.data.errors;
                var errorsHtml= '';
                $.each( errors, function( key, value ) {
                    errorsHtml += '<li>' + value[0] + '</li>'; 
                });
                toastr.error( errorsHtml , '@langapp('response_status') ');
                $(".formSaving").html('<i class="fas fa-sync"></i> Try Again</span>');
            });


        });
    });

</script>
@endpush
@endsection