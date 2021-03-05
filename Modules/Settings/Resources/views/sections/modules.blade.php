<div class="row">
    <div class="col-lg-12">
        @if(Session::has('success'))
        <x-alert type="success" icon="solid/check-circle" class="text-sm leading-5">
            {{Session::get('success')}}
        </x-alert>
        @endif
        @if(Session::has('danger'))
        <x-alert type="danger" icon="solid/exclamation-circle" class="text-sm leading-5">
            {{Session::get('danger')}}
        </x-alert>
        @endif
        <livewire:settings.modules />
    </div>
</div>