<aside class="bg-light lter b-l aside-md hide animated fadeInRight scrollable notifier" id="topAlerts">
    <header class="bg-white border-b header">
        <a class="pull-right btn {{themeButton()}}" id="clear-alerts" data-placement="left" data-toggle="tooltip" title="Clear All">
            @icon('solid/backspace')
        </a>
        <p>@langapp('notifications')</p>
    </header>
    <div class="slim-scroll" data-disable-fade-out="true" data-distance="0" data-height="500" data-size="5px">
        @if ($notifications->count())
        <div class="m-1">
            <div class="list-group list-group-alt animated fadeInRight notifier-list">
                @foreach ($notifications as $notification)
                <div class="list-group-item">
                    <span class="text-sm font-thin" data-toggle="tooltip" title="{{ $notification->created_at->diffForHumans() }}" data-placement="bottom">
                        <i class="fas fa-{{ $notification->data['icon'] }} text-indigo-500" wire:click="markAsRead('{{ $notification->id }}')"></i>
                        {{ $notification->data['subject'] }}
                    </span>
                    <span class="text-xs text-gray-600 media-body">
                        @parsedown($notification->data['activity'])
                    </span>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="p-2">
            <p class="text-sm text-gray-600">
                You have no unread notifications
            </p>
        </div>
        @endif
    </div>
</aside>