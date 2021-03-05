@extends('layouts.app')
@section('content')
<section id="content">
    <section class="hbox stretch">
        <aside>
            <section class="vbox">
                <header class="clearfix bg-white header b-b">

                    <div class="flex justify-between mt-2 text-gray-500">
                        <div class="text-2xl font-semibold text-gray-600">
                            {{ $project->name }}
                        </div>
                        <div class="text-gray-600">
                            <a href="{{  route('projects.view', ['project' => $project->id])  }}" class="btn {{themeButton()}} pull-right" data-rel="tooltip"
                                title="Back to Project" data-placement="bottom">
                                @icon('solid/chevron-left') @langapp('preview')
                            </a>
                        </div>

                    </div>
                </header>
                <section class="scrollable wrapper bg">
                    <div class="row">
                        {!! Form::open(['route' => ['projects.api.update', $project->id], 'data-toggle' => 'validator', 'class' => 'ajaxifyForm', 'method' => 'PUT']) !!}
                        <div class="col-md-7">
                            <section class="panel panel-default">
                                <header class="panel-heading">
                                    @icon('regular/clock') @langapp('information') </header>
                                <div class="panel-body">
                                    <input type="hidden" name="id" value="{{  $project->id  }}">

                                    <input type="hidden" name="auto_progress" value="1">
                                    <div class="form-group">
                                        <label>@langapp('status') </label>
                                        <select class="form-control" name="status">
                                            <option value="Active" {{ $project->status == 'Active' ? ' selected="selected"' : ''  }}>@langapp('active') </option>
                                            <option value="On Hold" {{ $project->status == 'On Hold' ? ' selected="selected"' : ''  }}>@langapp('on_hold') </option>
                                            <option value="Done" {{  $project->status == 'Done' ? ' selected="selected"' : ''  }}>@langapp('done') </option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>@langapp('name') @required</label>
                                        <input type="text" class="form-control" value="{{ $project->name }}" name="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label>@langapp('client') @required</label>
                                        <select class="select2-option form-control" name="client_id" required>

                                            @if(isAdmin() || can('menu_clients'))
                                            @foreach (Modules\Clients\Entities\Client::select('id', 'name')->get() as $key => $client)
                                            <option value="{{ $client->id }}" {{ $client->id == $project->client_id ? 'selected' : '' }}>
                                                {{  $client->name }}
                                            </option>
                                            @endforeach
                                            @else
                                            <option value="{{ $project->client_id }}">--- @langapp('current') ----</option>
                                            @endif
                                            <option value="0" {{ $project->client_id == 0 ? 'selected="selected"' : 'disabled' }}>----None----</option>
                                        </select>

                                    </div>

                                    @if(isAdmin() || $project->manager == Auth::id())
                                    <div class="form-group">
                                        <label>@langapp('contract')</label>
                                        <select class="select2-option form-control" name="contract_id">
                                            <option value="">None</option>
                                            @foreach (Modules\Contracts\Entities\Contract::select('id', 'contract_title')->done()->get() as $key => $contract)
                                            <option value="{{ $contract->id }}" {{ $contract->id === $project->contract_id ? 'selected' : '' }}>
                                                {{ $contract->contract_title }}
                                            </option>
                                            @endforeach
                                        </select>

                                    </div>
                                    @endif

                                    <div class="form-group">
                                        <label>@langapp('progress')</label>
                                        <div id="progress-slider" class="width100-important"></div>
                                        <input id="progress" type="hidden" value="{{ $project->progress }}" name="progress" />
                                    </div>

                                    @can('users_assign')
                                    @php $team = $project->assignees->toArray(); @endphp
                                    <div class="form-group">
                                        <label>@langapp('team_members') </label>
                                        <select name="team[]" class="select2-option form-control" multiple="multiple">
                                            @foreach (app('user')->select('id', 'username', 'name')->offHoliday()->get() as $user)
                                            <option value="{{  $user->id  }}" {{ in_array($user->id, array_pluck($team, 'user_id')) ? 'selected="selected"' : '' }}>
                                                {{  $user->name  }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endcan
                                    <div class="form-group">
                                        <label>@langapp('start_date') @required</label>
                                        <div class="input-group">
                                            <input class="datepicker-input form-control" size="16" type="text" value="{{  datePickerFormat($project->start_date)  }}"
                                                name="start_date" data-date-format="{{  get_option('date_picker_format') }}" required>
                                            <label class="input-group-addon btn" for="date">
                                                @icon('solid/calendar-alt', 'text-muted')
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>@langapp('due_date') </label>
                                        <div class="input-group">
                                            <input class="datepicker-input form-control" size="16" type="text" value="{{  datePickerFormat($project->due_date)  }}" name="due_date"
                                                data-date-format="{{  get_option('date_picker_format') }}" data-date-start-date="moment()" required>
                                            <label class="input-group-addon btn" for="date">
                                                @icon('solid/calendar-alt', 'text-muted')
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>@langapp('currency') @required</label>
                                        <select name="currency" class="select2-option form-control" required>
                                            @foreach (currencies() as $cur)
                                            <option value="{{  $cur['code']  }}" {{ get_option('default_currency') == $cur['code'] ? ' selected' : '' }}>{{ $cur['native'] }} -
                                                {{ $cur['title'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>
                                            <input type="checkbox" name="auto_progress" checked value="1">
                                            <span class="label-text text-muted"> Calculate progress through tasks</span>
                                        </label>
                                    </div>

                                    <div class="form-group">
                                        <div class="checkbox-primary">
                                            <label>
                                                <input type="checkbox" name="is_template" {{ $project->is_template ? 'checked' : '' }} value="1">
                                                <span class="label-text">@langapp('this_is_a_project_template')</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{  langapp('billing_method')  }} @required</label>
                                        <select name="billing_method" class="form-control" id="project_rate" required>
                                            @foreach (config('projects.billing_methods') as $method)
                                            <option value="{{ $method }}" {!! $method==$project->billing_method ? 'selected' : '' !!}>{{ humanize($method) }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div id="hourly_rate" class="{{ $project->billing_method == 'hourly_project_rate' ? '' : 'display-none' }}">
                                        <div class="form-group">
                                            <label>@langapp('hourly_rate') (Ex. 50.00)</label>
                                            <input type="text" class="form-control money" name="hourly_rate" value="{{ $project->hourly_rate }}">
                                        </div>
                                    </div>
                                    <div id="fixed_price" class="{{ $project->billing_method == 'fixed_rate' ? '' : 'display-none' }}">
                                        <div class="form-group">
                                            <label>@langapp('fixed_price') (Ex. 300.00 )</label>
                                            <input type="text" class="form-control money" name="fixed_price" value="{{  $project->fixed_price  }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>@langapp('estimated_hours') </label>
                                        <input type="text" class="form-control money" value="{{ $project->estimate_hours }}" name="estimate_hours">
                                    </div>
                                    <div class="form-group">
                                        <label>@langapp('description') @required</label>
                                        <x-inputs.wysiwyg name="description" class="{{ get_option('htmleditor') }}" id="project_description">
                                            {!!$project->description!!}
                                        </x-inputs.wysiwyg>
                                    </div>

                                </div>
                            </section>
                        </div>
                        <div class="col-md-5">
                            <section class="panel panel-default">
                                <header class="panel-heading">@icon('solid/cogs') @langapp('settings') </header>
                                <div class="panel-body text-muted">
                                    @can('projects_update')

                                    @foreach (Modules\Projects\Entities\ProjectSetting::all() as $val)
                                    @php
                                    $active_settings = [];
                                    $default_settings = $project->settings;
                                    foreach ($default_settings as $key => &$value) {
                                    if (strtolower($value) == 'on') {
                                    $active_settings[] = $key;
                                    }
                                    }
                                    @endphp

                                    <label class="py-2">
                                        <input type="checkbox" name="settings[{{ $val->setting }}]" {{ in_array($val->setting, $active_settings) ? 'checked' : '' }}>
                                        <span class="label-text text-muted">{{ $val->description }}</span>
                                    </label>
                                    <hr class="no-margin">
                                    @endforeach


                                    <div class="mt-2 form-group">
                                        <label class="control-label">@langapp('tags') </label>
                                        <select class="select2-tags form-control" name="tags[]" multiple>
                                            @foreach (App\Entities\Tag::all() as $tag)
                                            <option value="{{ $tag->name  }}" {{ in_array($tag->id, array_pluck($project->tags->toArray(), 'id')) ? ' selected="selected"' : '' }}>
                                                {{ $tag->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label>
                                                <input type="hidden" name="feedback_disabled" value="0">
                                                <input type="checkbox" name="feedback_disabled" {{ $project->feedback_disabled ? 'checked' :'' }} value="1">
                                                <span class="label-text" data-rel="tooltip"
                                                    title="Client will not be asked to give feedback when this project is complete">@langapp('disable_feedback')</span>
                                            </label>
                                        </div>
                                    </div>

                                    @php
                                    $data['fields'] = App\Entities\CustomField::whereModule('projects')->orderBy('order', 'desc')->get();
                                    @endphp
                                    @include('projects::includes.updateCustom', $data)


                                    @endcan

                                    <div class="pull-right">
                                        {!! renderAjaxButton() !!}
                                    </div>

                                </div>
                            </section>
                        </div>

                        {!! Form::close() !!}
                    </div>
                </section>
            </section>
        </aside>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
</section>
@push('pagestyle')
@include('stacks.css.datepicker')
@include('stacks.css.form')
@include('stacks.css.nouislider')
@include('stacks.css.wysiwyg')
@endpush
@push('pagescript')
@include('stacks.js.form')
@include('stacks.js.datepicker')
@include('stacks.js.nouislider')
@include('stacks.js.wysiwyg')
<script type="text/javascript">
    $(document).ready(function () {
$("#project_rate").change(function () {
var selected_option = $('#project_rate').val();
if (selected_option === 'hourly_project_rate') {
$("#hourly_rate").show("fast");
$("#fixed_price").hide("fast");
}
if (selected_option === 'fixed_rate') {
$("#fixed_price").show("fast");
$("#hourly_rate").hide("fast");
}
if (selected_option === 'hourly_staff_rate' || selected_option === 'hourly_task_rate') {
$("#fixed_price").hide("fast");
$("#hourly_rate").hide("fast");
}
});

});
</script>
@endpush
@endsection