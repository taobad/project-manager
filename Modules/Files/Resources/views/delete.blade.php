<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">@langapp('delete') </h4>
        </div>
        {!! Form::open(['route' => 'files.destroy', 'class' => 'ajaxifyForm', 'method' => 'DELETE']) !!}

        <div class="modal-body ">
            <div class="alert bg-red-100 border-red-600 mb-2">
                @langapp('delete_warning')
            </div>

            <div class="py-1">
                @langapp('title') : <span class="font-bold text-indigo-600">{{ $file->title }}</span>
            </div>
            <div class="py-1">
                @langapp('filename') :
                <span class="font-bold text-gray-600">
                    {{ $file->filename }}
                </span>
            </div>
            <div class="py-1">
                @langapp('size') :
                <span class="font-bold text-gray-600">
                    {{ $file->size  }}KB
                </span>
            </div>

            <div class="py-1">
                @langapp('user') :
                <span class="font-bold text-gray-600">
                    {{ $file->user->name  }}
                </span>
            </div>


            <h4 class="text-gray-600 my-3 text-sm uppercase">@langapp('description')</h4>
            <p class="prose-lg text-sm m-2">
                {{ $file->description }}
            </p>

            <input type="hidden" name="id" value="{{ $file->id }}">

        </div>
        <div class="modal-footer">
            {!! closeModalButton() !!}

            {!! renderAjaxButton('ok') !!}
        </div>
        {!! Form::close() !!}
    </div>
</div>

@include('partial.ajaxify')