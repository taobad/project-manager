<div class="flex flex-col">
    @if ($notifications->count())

    <div class="py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8" x-data="{ modal: false }">
        <div class="inline-block min-w-full overflow-hidden align-middle border-b border-gray-200 shadow sm:rounded-lg">
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                            @langapp('notifications')
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notifications as $notification)

                    <tr class="bg-white">
                        <td class="px-6 py-4 text-sm font-medium leading-5 text-gray-900 border-b border-gray-200">

                            <div class="flex">
                                <div class="mr-2">
                                    <button wire:click="markAsRead('{{ $notification->id }}')" class="focus:outline-none">
                                        @icon('regular/bell', $notification->read() ? 'w-6 h-6 text-indigo-300' : 'w-6 h-6 text-green-500')
                                    </button>
                                </div>

                                <div class="flex flex-col flex-1 min-w-0">
                                    <p class="flex text-sm">
                                        <span class="text-gray-500 truncate">
                                            <span class="font-bold text-gray-{{$notification->read() ? '600' : '900'}}">{{$notification->data['subject']}}</span>
                                            <span class="pl-1 text-xs text-indigo-500">{{ $notification->created_at->toFormattedDateString() }}</span>
                                        </span>
                                        <span class="flex-shrink-0">
                                            <span class="px-1 text-gray-500">
                                                <i class="text-xs far fa-dot-circle"></i>
                                            </span>
                                            <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                                        </span>
                                    </p>

                                    <span class="text-sm leading-tight tracking-wide text-gray-600 hover:text-gray-800">
                                        @parsedown($notification->data['activity'])
                                    </span>
                                </div>
                            </div>

                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="px-4 py-2 text-gray-600">
                {{ $notifications->links() }}
            </div>
        </div>

    </div>

    @else

    <div>
        <p class="text-base text-gray-600">
            You have no unread notifications
        </p>
    </div>
    @endif

</div>