<ul class="list-feed text-xs">
    @foreach ($activities as $key => $activity)
    <li class="border-{{ get_option('theme_color') }}">
        <div class="text-gray-600">
            <strong>{{ optional($activity->user)->name }}</strong>
            <a href="{{ $activity->url }}"
                class="pull-right text-indigo-600">{{ dateElapsed($activity->created_at) }}</a>

        </div>
        <span class="text-gray-700">@langactivity($activity->action, ['value1' => '<span
                class="font-thin text-gray-600">'.$activity->value1.'</span>', 'value2' => '<span
                class="font-thin text-gray-600">'.$activity->value2.'</span>'])
        </span>
    </li>
    @endforeach

</ul>