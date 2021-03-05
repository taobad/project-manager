<section class="block comment-list m-sm">
    <section class="scrollable">
        @foreach ($activities as $key => $activity)
        <article id="comment-id-{{ $activity->id }}" class="comment-item small">
            <div class="pull-left thumb-sm">
                <img src="{{ $activity->user->profile->photo }}" class="img-circle">
            </div>
            <section class="comment-body m-b-md">
                <header class="mt-1 border-b border-gray-200">
                    <strong class="text-sm text-gray-600">
                        {{ $activity->user->name }}</strong>
                    <span class="text-gray-500 pull-right">
                        {{ dateElapsed($activity->created_at) }}
                    </span>
                </header>
                <div class="mt-1 text-xs text-gray-600">
                    @langactivity($activity->action, ['value1' => '<span class="text-indigo-500">'.$activity->value1.'</span>', 'value2' => '<span
                        class="text-indigo-500">'.$activity->value2.'</span>'])
                </div>
            </section>
        </article>

        @endforeach
    </section>
</section>