<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">@icon('solid/plus') @langapp('create')  </h4>
        </div>

        {!! Form::open(['route' => 'tasks.savetemplate', 'class' => 'bs-example form-horizontal ajaxifyForm']) !!}

        
        <input name="visible" type="hidden" value="0">
        <input name="user_id" type="hidden" value="{{ Auth::id() }}">
        <div class="modal-body">
            <div class="form-group">
                <label class="col-lg-4 control-label">@langapp('task_name')   @required</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" placeholder="@langapp('task_name') " name="name"
                           required>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-4 control-label">@langapp('hourly_rate')  </label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" placeholder="50" name="hourly_rate">
                           <span class="help-block">Hourly rate e.g 50</span>
                </div>
            </div>



            <div class="form-group">
                <label class="col-lg-4 control-label">@langapp('estimated_hours')   </label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" placeholder="50" name="estimated_hours">
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-4 control-label">@langapp('description')   @required</label>
                <div class="col-lg-8">
                    <textarea name="description" class="form-control ta" placeholder="@langapp('description')  "
                              required></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-4 control-label">  </label>
                <div class="col-lg-8">
                        <label class="">
                        <input name="visible" value="1"  type="checkbox" checked>
                        <span class="label-text">@langapp('visible_to_client')</span> 
                        </label>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            {!! closeModalButton() !!}
            {!! renderAjaxButton() !!}
        </div>
        {!! Form::close() !!}
    </div>
</div>
@include('partial.ajaxify')