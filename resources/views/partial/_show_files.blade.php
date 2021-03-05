<div class="">
    @foreach ($files as $key => $file)
    <li class="mt-1 list-group-item">
        <i class="{{ getIcon($file->ext) }} fa-3x text-indigo-500 pull-left m-1"></i>
        <a class="{{themeLinks('font-semibold')}}" href="{{  route('files.download', $file->id) }}" data-toggle="tooltip" title="@langapp('download')">
            {{ $file->title }}
        </a>
        <span class="text-gray-600 pull-right">@icon('regular/clock') {{ dateElapsed($file->created_at) }}

        </span>
        <div class="ml-3 text-sm prose-lg text-gray-600">
            @parsedown($file->description)
        </div>

        <div class="flex justify-between mt-2 text-gray-500">
            <span class="text-sm {{themeText()}}">@langapp('size'): {{ $file->size }}KB</span>
            @if (Auth::id() == $file->user_id)
            <a href="{{  route('files.edit', $file->id)  }}" data-toggle="ajaxModal" class="p-px">
                @icon('regular/edit')
            </a>
            @endif
            @if(isAdmin() || can('files_delete') || Auth::id() == $file->user_id)
            <a href="{{  route('files.delete', $file->id)  }}" data-toggle="ajaxModal" class="p-px">
                @icon('solid/trash-alt')
            </a>
            @endif

        </div>



    </li>

    @endforeach

</div>