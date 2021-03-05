<section class="bg chat-list panel-body">
    @widget('Calls\ShowCalls', ['calls' => $contact->calls])
    
</section>

@push('pagestyle')
<link rel=stylesheet href="{{ getAsset('plugins/nestable/nestable.css') }}">
@endpush
@push('pagescript')
@include('extras::_ajax.callsjs')
@endpush