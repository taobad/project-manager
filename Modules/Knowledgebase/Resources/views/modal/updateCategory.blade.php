<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">@langapp('make_changes') - {{ $category->name }}</h4>
        </div>

        {!! Form::open(['route' => ['kb.category.update', 'id' => $category->id], 'method' =>'PUT', 'class' => 'bs-example form-horizontal ajaxifyForm', 'id' => 'editCategory'])
        !!}
        <input type="hidden" name="id" value="{{ $category->id }}">
        <input type="hidden" name="module" value="{{ $category->module }}">
        <input type="hidden" name="active" value="1">

        <div class="modal-body">
            <div class="form-group">
                <label class="col-lg-3 control-label">@langapp('name') @required</label>
                <div class="col-lg-9">
                    <input type="text" class="form-control" value="{{ $category->name }}" name="name">
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-3 control-label">@langapp('description') @required</label>
                <div class="col-lg-9">
                    <textarea name="description" class="form-control ta">{{$category->description}}</textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-3 control-label">@langapp('icon')</label>
                <div class="col-lg-9">
                    <div class="input-group iconpicker-container">
                        <span class="input-group-addon"><i class="fas fa-{{$category->icon}}"></i></span>
                        <input id="icon" name="icon" type="text" value="fas fa-{{$category->icon}}" class="form-control iconpicker-input" data-placement="bottomRight">
                    </div>
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

@push('pagescript')
@include('stacks.js.iconpicker')
@endpush

@stack('pagescript')