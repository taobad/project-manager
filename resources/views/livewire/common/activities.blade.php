<ul class="list-unstyled">
    @foreach ($activities as $activity)
    <li class="py-1">
        <div class="clearfix">
            <div class="comment-section pull-left">
                <div class="media">
                    <p>
                        <div class="pull-left">
                            <div class="txn-comment-icon circle-box">
                                <i class="fas {{ $activity->icon }} {{ themeText() }}"></i>
                            </div>
                        </div>
                        <div class="media-body">

                            <div class="comment">
                                <span class="description small">
                                    @langactivity($activity->action,
                                    ['value1' => '<span class="text-bold">'.$activity->value1.'</span>',
                                    'value2' => '<span class="text-bold">'.$activity->value2.'</span>']
                                    )
                                    <br>
                                    <a class="text-gray-600" href="{{ $activity->url }}">
                                        @icon('regular/clock')
                                        {{ dateTimeFormatted($activity->created_at) }}
                                        -
                                        {{ $activity->user->name  }}</a>
                                </span>
                            </div>
                        </div>
                    </p>
                </div>
            </div>
        </div>
    </li>
    @endforeach
</ul>