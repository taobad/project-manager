{!! Form::open(['route' => 'comments.create', 'novalidate' => '', 'id' => 'sendComment', 'files' => true]) !!}
<input type="hidden" name="commentable_id" value="{{ $commentable_id }}">
<input type="hidden" name="commentable_type" value="{{ $commentable_type }}">
<input type="hidden" name="user_id" value="{{ Auth::id() }}">

<x-inputs.wysiwyg name="message" class="{{ get_option('htmleditor') }}" id="{{ get_option('htmleditor') }}" data-id="{{ $commentable_id }}">
</x-inputs.wysiwyg>

@if($cannedResponse)
<div class="m-xs">
    @if(count(Auth::user()->cannedResponses) > 0)
    <select name="selectCanned" class="form-control m-b" id="insertCannedResponse" onChange="insertCannedMessage(this.value);">
        <option value="0">--- @langapp('canned_responses') ---</option>
        @foreach (Auth::user()->cannedResponses as $template)
        <option value="{{ $template->id }}">{{ $template->subject }}</option>
        @endforeach
    </select>
    @endif
</div>
@endif
@if ($hasFiles)
<input type="file" class="form-control no-border" name="uploads[]" multiple="" id="file-upload">
@endif

@if($commentable_type === 'tickets')
<div class="form-group">
    <div class="checkbox">
        <label>
            <input type="checkbox" name="reply_close" value="1">
            <span class="label-text">@langapp('reply_close')</span>
        </label>
    </div>
</div>
@endif
<footer class="border-0 panel-footer bg-light lter">
    {!! renderAjaxButton() !!}
    <ul class="nav nav-pills nav-sm"></ul>
</footer>
{!! Form::close() !!}