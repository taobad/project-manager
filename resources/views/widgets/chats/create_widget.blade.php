{!! Form::open(['route' => 'extras.chats.create', 'novalidate' => '', 'id' => 'sendChat', 'files' => true]) !!}
<input type="hidden" name="chatable_id" value="{{ $chatable_id }}">
<input type="hidden" name="chatable_type" value="{{ $chatable_type }}">
<input type="hidden" name="user_id" value="{{ Auth::id() }}">
<div class="m-1">
    <textarea class="form-control ta" name="message" rows="6" id="sms" data-id="{{ $chatable_id }}" required placeholder="Type your message"></textarea>
</div>

@if($cannedResponse)

@if(count(Auth::user()->cannedResponses) > 0)
<div class="m-xs">
    <select name="selectCanned" class="form-control m-b" id="insertCannedResponse" onChange="insertCannedMessage(this.value);">
        <option value="0">--- @langapp('canned_responses') ---</option>
        @foreach (Auth::user()->cannedResponses as $template)
        <option value="{{ $template->id }}">{{ $template->subject }}</option>
        @endforeach
    </select>
</div>
@endif
@endif



<footer class="panel-footer bg-light lter">

    {!! renderAjaxButton('send', 'fab fa-whatsapp') !!}

    <ul class="nav nav-pills nav-sm"></ul>
</footer>
{!! Form::close() !!}