<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">@langapp('make_changes')</h4>
        </div>
        {!! Form::open(['route' => ['tasks.api.update', $task->id], 'class' => 'ajaxifyForm bs-example form-horizontal', 'method' => 'PUT']) !!}
        <div class="modal-body">
            <input type="hidden" name="id" value="{{  $task->id  }}">
            <input type="hidden" name="project_id" value="{{  $task->project_id  }}">
            <div class="form-group">
                <label class="col-lg-4 control-label">@langapp('task_name') @required</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" value="{{  $task->name  }}" name="name">
                </div>
            </div>

            <div class="form-group">
                <span class="col-md-4 control-label">@langapp('type')  @required</span>
                <div class="col-md-8">
                    <select name="type" class="form-control" id="task_type">
                            <option value="1" {{ $task->type == '1' ? 'selected' : '' }}>@langapp('task') </option>
                            <option value="2" {{ $task->type == '2' ? 'selected' : '' }}>@langapp('sub_task') </option>
                    </select>
                </div>
            </div>

            <div class="form-group" id="parent_task_block">
                    <label class="col-lg-4 control-label">@langapp('parent_task') @required</label>
                    <div class="col-lg-8">
                        <select  id="parent_task_id" name="parent_task_id" class="form-control">
                            @foreach (Modules\Tasks\Entities\Task::select('id', 'name')->where('type', '1')->get() as $t)
                                <option value="{{  $t->id  }}" {{ $t->id == $task->parent_task_id ? 'selected' : '' }}>
                                    {{  $t->name  }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @if ($task->AsProject->isTeam() || can('milestones_create'))
            <div class="form-group">
                <label class="col-lg-4 control-label">@langapp('milestone')</label>
                <div class="col-lg-8">
                    <select name="milestone_id" class="form-control">
                        <option value="0">@langapp('none') </option>
                        @foreach ($task->AsProject->milestones as $m)
                        <option value="{{  $m->id  }}" {{  $task->milestone_id === $m->id ? ' selected="selected"' : ''  }}>{{  $m->milestone_name  }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-4 control-label">@langapp('stage')</label>
                <div class="col-lg-8">
                    <select name="stage_id" class="form-control">
                        <option value="">---None---</option>
                        @foreach (App\Entities\Category::select('id', 'name')->tasks()->get() as $key => $stage)
                        <option value="{{ $stage->id }}" {{ $stage->id == $task->stage_id ? 'selected' : '' }}>{{ $stage->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            @endif

            @can('users_assign')

            <div class="form-group">
                <label class="col-md-4 control-label">Member category</label>
                <div class="col-md-8">
                    <select name="membercategory" class="form-control" id="membercategory">
                        <option value="none" selected>@langapp('none')  </option>
                        <option value="4">Consultant</option>
                        <option value="91">Professional</option>
                        <option value="51">Supplier</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Member Type</label>
                <div class="col-md-8" id="membertypediv">
                    <select name="membertype" class="form-control" id="membertype">
                        <option value="none" selected>@langapp('none')  </option>
                    </select>
                </div>
            </div>


                <div class="form-group">
                    <label class="col-lg-4 control-label">@langapp('team_members') @required</label>
                    
                    <div class="col-lg-8">
                        <select class="select2-option form-control" multiple="multiple" name="team[]" required>
                            @foreach ($task->AsProject->assignees as $member)
                            <option value="{{  $member->user_id  }}" {{ $task->isTeam($member->user_id) ? 'selected' : '' }}>
                                {{  $member->user->name  }}
                            </option>
                            @endforeach
                            @if (optional($task->AsProject->company)->primary_contact > 0)
                            <option value="{{ $task->AsProject->company->primary_contact }}" {{ $task->isTeam($task->AsProject->company->primary_contact) ? 'selected' : ''}}>
                                {{ $task->AsProject->company->contact->name }}
                            </option>
                            @endif
                        </select>
                    </div>
                </div>

            @endcan
            
            <div class="form-group">
                <label class="col-lg-4 control-label">@langapp('description') @required</label>
                <div class="col-lg-8">
                    <textarea name="description" class="form-control ta">{{  $task->description  }}</textarea>
                </div>
            </div>
            @if ($task->AsProject->isTeam() || can('tasks_update'))
            <div class="form-group">
                <label class="col-lg-4 control-label">@langapp('progress') @required</label>
                <div class="col-lg-8">
                    <div id="progress-slider"></div>
                    <input id="progress" type="hidden" value="{{  $task->progress  }}" name="progress" />
                </div>
            </div>
            @endif
            <div class="form-group">
                <label class="col-lg-4 control-label">@langapp('start_date')</label>
                <div class="col-lg-8">
                    <div class="input-group">
                        <input class="datepicker-input form-control" size="16" type="text" value="{{  datePickerFormat($task->start_date)  }}" name="start_date"
                            data-date-format="{{ get_option('date_picker_format')  }}" required>
                        <label class="input-group-addon btn" for="date">
                            @icon('solid/calendar-alt', 'text-muted')
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 control-label">@langapp('due_date')</label>
                <div class="col-lg-8">
                    <div class="input-group">
                        <input class="datepicker-input form-control" size="16" type="text" value="{{ datePickerFormat($task->due_date) }}" name="due_date"
                            data-date-format="{{ get_option('date_picker_format') }}" data-date-start-date="moment()" required>
                        <label class="input-group-addon btn" for="date">
                            @icon('solid/calendar-alt', 'text-muted')
                        </label>
                    </div>
                </div>
            </div>
            @if (isAdmin() || $task->AsProject->isTeam())
            <div class="form-group">
                <label class="col-lg-4 control-label">@langapp('hourly_rate')</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control money" value="{{ $task->hourly_rate }}" name="hourly_rate">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 control-label">@langapp('estimated_hours')</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control money" value="{{ $task->estimated_hours }}" name="estimated_hours">
                </div>
            </div>
            @endif


            <div class="form-group">
                <label class="col-md-4 control-label">@langapp('recur_frequency')</label>
                <div class="col-md-8">
                    <select name="recurring[frequency]" class="form-control" id="frequency">
                        <option value="none" {{ $task->is_recurring ? 'selected' : '' }}>@langapp('none') </option>
                        <option value="1" {{ $task->is_recurring && $task->recurring->frequency == '1' ? ' selected' : ''  }}>@langapp('daily')</option>
                        <option value="7" {{ $task->is_recurring && $task->recurring->frequency == '7' ? ' selected' : ''  }}>@langapp('week')</option>
                        <option value="30" {{ $task->is_recurring && $task->recurring->frequency == '30' ? ' selected' : ''  }}>@langapp('month')</option>
                        <option value="90" {{ $task->is_recurring && $task->recurring->frequency == '90' ? ' selected' : ''  }}>@langapp('quarter')</option>
                        <option value="180" {{ $task->is_recurring && $task->recurring->frequency == '180' ? ' selected' : ''  }}>@langapp('six_months')</option>
                        <option value="365" {{ $task->is_recurring && $task->recurring->frequency == '365' ? ' selected' : ''  }}>@langapp('year')</option>
                    </select>
                </div>
            </div>
            <div id="recurring" class="{{ !$task->is_recurring ? 'display-none' : '' }}">
                @php
                $recurStarts = $task->is_recurring ? $task->recurring->recur_starts : today()->toDateString();
                $recurEnds = $task->is_recurring ? $task->recurring->recur_ends : today()->addYears(1)->toDateString();
                @endphp
                <div class="form-group">
                    <label class="col-md-4 control-label">@langapp('start_date')</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input class="datepicker-input form-control" size="16" type="text" value="{{  datePickerFormat($recurStarts) }}" name="recurring[recur_starts]"
                                data-date-format="{{ get_option('date_picker_format')  }}" required>
                            <label class="input-group-addon btn" for="date">
                                @icon('solid/calendar-alt', 'text-muted')
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">@langapp('end_date')</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input class="datepicker-input form-control" size="16" type="text" value="{{  datePickerFormat($recurEnds) }}" name="recurring[recur_ends]"
                                data-date-format="{{ get_option('date_picker_format')  }}" required>
                            <label class="input-group-addon btn" for="date">
                                @icon('solid/calendar-alt', 'text-muted')
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            @if ($task->AsProject->isTeam() || can('tasks_update'))
            <div class="form-group">
                <label class="col-lg-4 control-label">@langapp('visible_to_client') </label>
                <div class="col-lg-8">
                    <select name="visible" class="form-control">
                        <option value="1" {{ $task->visible === 1 ? ' selected' : '' }}>@langapp('yes')</option>
                        <option value="0" {{ $task->visible === 0 ? ' selected' : '' }}>@langapp('no')</option>
                    </select>
                </div>
            </div>
            @endif
            @can('tasks_update')
            <div class="form-group">

                <label class="col-lg-4 control-label">@langapp('tags') </label>
                <div class="col-lg-8">
                    <select class="select2-tags form-control" name="tags[]" multiple>
                        @foreach (App\Entities\Tag::all() as $tag)
                        <option value="{{ $tag->name  }}" {{ in_array($tag->id, array_pluck($task->tags->toArray(), 'id')) ? ' selected="selected"' : '' }}>
                            {{ $tag->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            @endcan
        </div>
        <div class="modal-footer">
            {!! closeModalButton() !!}
            {!! renderAjaxButton('edit') !!}
        </div>
        {!! Form::close() !!}
    </div>
</div>
@push('pagestyle')
@include('stacks.css.nouislider')
@include('stacks.css.datepicker')
@include('stacks.css.form')
@endpush
@push('pagescript')
@include('stacks.js.nouislider')
@include('stacks.js.datepicker')
@include('stacks.js.form')
@include('partial.ajaxify')
<script>
    $('.money').maskMoney({allowZero: true, thousands: '', allowNegative: true});
    $('#frequency').change(function () {
        if ($("#frequency").val() === "none") {
            $("#recurring").hide();
        } else {
            $("#recurring").show();
        }
    });
</script>


<script type="text/javascript">
        $(document).ready(function () {
            $("#membercategory").change(function () {
                var id = $(this).val();
                $('#membertype').find('option').not(':first').remove();
                $.ajax({
                    url: '/category-profession/'+id,
                    type: 'get',
                    contentType: 'application/json;charset=utf-8',
                    dataType: 'json',
                    success: function (response) {
                        var len = 0;
                        if (response['data'] != null) {
                            len = response['data'].length;
                        }
                        for(var i = 0; i < len; i++){
                            var id = response['data'][i]['id'];
                            var name = response['data'][i]['profession'];
                            var option = "<option value='" + name + "'>" + name + "</option>";
                            $("#membertype").append(option);
                        }
                    },
                    error: function(request, status, error){
                        console.log(request.responseText);
                    }
                });
            });

            $("#membertype").change(function () {
                var id = $(this).val();
                $('#team').find('option').remove();
                $.ajax({
                    url: '/team-member/'+id,
                    type: 'get',
                    contentType: 'application/json;charset=utf-8',
                    dataType: 'json',
                    success: function (response) {
                        var len = 0;
                        if (response['data'] != null) {
                            len = response['data'].length;
                        }
                        for(var i = 0; i < len; i++){
                            var id = response['data'][i]['id'];
                            var name = response['data'][i]['name'];
                            var option = "<option value='" + name + "'>" + name + "</option>";
                            $("#team").append(option);
                        }
                    },
                    error: function(request, status, error){
                        console.log(request.responseText);
                    }
                });
            });
        });
     </script>


<script type="text/javascript">
    $(document).ready(function () {
        $('#task_type').change(function () {
        if ($("#task_type").val() == "2") {
            $("#parent_task_block").show();
        } else {
            $("#parent_task_block").hide();
            $("#parent_task_id").val('');
        }
        }).change();
    });
    </script>
@endpush
@stack('pagestyle')
@stack('pagescript')