<div class="row">
    <div class="col-lg-12">
        @if(Session::has('success'))
        <x-alert type="success" icon="solid/check-circle" class="text-sm leading-5">
            {{Session::get('success')}}
        </x-alert>
        @endif
        <livewire:settings.integration-setup />
    </div>
</div>