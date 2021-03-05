@if($count)
<li class="hidden-xs notif">
    <a href="#topAlerts" class="dropdown-toggle" data-toggle="class:show animated fadeInRight" wire:click="clearNotifications()">
        @icon('solid/bell')
        <span class="bg-indigo-500 badge badge-sm up m-l-n-sm display-inline" data-count="0">
            <span class="notif-count">{{$count}}</span>
        </span>
    </a>
</li>
@endif