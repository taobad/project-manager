<section class="panel panel-default">
    <header class="panel-heading">@icon('solid/layer-group') @langapp('module_settings')</header>
    <div class="panel-body">

        <form wire:submit.prevent="install" x-on:submit.prevent>
            <p class="text-center">
                If you have a module in a .zip format, you may install it by uploading it here.
            </p>
            <div class="flex items-center justify-center my-2">
                <input wire:model="module" type='file' name="module" accept="zip,application/octet-stream,application/zip,application/x-zip,application/x-zip-compressed" />
                <div>
                    @error('module') <span class="text-sm italic text-red-500">{{ $message }}</span>@enderror
                </div>
                <div wire:loading wire:target="module" class="text-sm italic text-gray-500">Uploading...</div>
            </div>

            <div class="my-3 text-center">
                <span wire:loading wire:target="install" class="mt-2 mr-3 text-gray-700">
                    <i class="fas fa-sync fa-spin"></i>
                    Installing...
                </span>
                <input wire:loading.class.remove="bg-indigo-500" wire:loading.class="bg-indigo-300" wire:loading.attr="disabled" type="submit" value="{{langapp('install')}}"
                    class="p-3 py-2 mr-4 text-white bg-indigo-500 rounded-md shadow-sm">
            </div>
        </form>

        <div class="table-responsive">
            <table id="menu-main" class="table table-striped b-t b-light table-menu sorted_table">
                <thead>
                    <tr>
                        <th class="col-md-3">@langapp('name')</th>
                        <th class="col-md-9">@langapp('description')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (Module::toCollection() as $module)
                    <tr class="sortable" data-module="{{ $module->getName() }}" data-access="1">
                        @php
                        $color = $module->isEnabled() ? 'green' : 'red';
                        @endphp
                        <td>
                            <div class="m-1 text-sm font-semibold text-gray-800">
                                @if (strlen($module->get('icon')))
                                <span class="fa-stack fa-1x">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fas fa-{{$module->get('icon')}} fa-stack-1x fa-inverse"></i>
                                </span>
                                @endif
                                {{$module->getName()}}
                            </div>
                            <div class="m-1 text-sm text-gray-700">
                                <button wire:click="moduleStatus('{{ $module->getName() }}')"
                                    class="btn bg-transparent hover:bg-{{$color}}-500 text-{{$color}}-600 font-semibold hover:text-white py-1 px-2 border border-{{$color}}-500 hover:border-transparent rounded">
                                    {{ $module->isEnabled() ? langapp('deactivate') : langapp('activate')  }}
                                </button>
                                @if (!$module->get('core'))
                                <button onclick="confirm('Confirm deleting module?') || event.stopImmediatePropagation()" wire:click="deleteModule('{{ $module->getName() }}')"
                                    class="btn {{themeButton()}}">
                                    @icon('regular/trash-alt')
                                </button>
                                @endif

                            </div>
                        </td>
                        <td>
                            {{$module->getDescription()}}
                            <div class="flex justify-between text-gray-600">
                                <div>Version: {{$module->get('version')}} </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>


    </div>
</section>


@push('pagestyle')
<link rel="stylesheet" href="{{ getAsset('plugins/iconpicker/fontawesome-iconpicker.min.css') }}" type="text/css" />
@endpush

@push('pagescript')
@include('stacks.js.iconpicker')
@include('stacks.js.menu')
@include('stacks.js.sortable')
@endpush