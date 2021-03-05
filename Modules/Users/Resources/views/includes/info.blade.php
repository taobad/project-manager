<table class="table table-borderless table-xs content-group-sm">
    <tbody>
        @if ($user->profile->company > 0)
        <tr>
            <td class="text-muted">@langapp('company')</td>
            <td class="text-right">
                <span class="pull-right">
                    <a href="{{ route('clients.view', $user->profile->company) }}">{{  $user->profile->business->name  }}</a>
                </span>
            </td>
        </tr>
        @endif

        <tr>
            <td class="text-muted">@langapp('email')</td>
            <td class="text-right">{{  $user->email  }}</td>
        </tr>
        <tr>
            <td class="text-muted">@langapp('username')</td>
            <td class="text-right">{{  $user->username  }}</td>
        </tr>
        <tr>
            <td class="text-muted">@langapp('last_login')</td>
            <td class="text-right">{{ is_null($user->last_login) ? 'N/a' : dateTimeFormatted($user->last_login)  }}</td>
        </tr>
        <tr>
            <td class="text-muted">@langapp('role')</td>
            <td class="text-right">{{ $user->roles->pluck('name') }}</td>
        </tr>
        <tr>
            <td class="text-muted">@langapp('department')</td>
            <td class="text-right">{{ $user->departments->pluck('department.deptname') }}</td>
        </tr>
        @if (!empty($user->profile->mobile))
        <tr>
            <td class="text-muted">@langapp('mobile')</td>
            <td class="text-right">{{ $user->profile->mobile }} <a href="web+aircall:{{ $user->profile->mobile }}" data-rel="tooltip"
                    title="@langapp('call_via_aircall')">@icon('solid/phone','text-success')</a></td>
        </tr>
        @endif
        @if (!empty($user->profile->phone))
        <tr>
            <td class="text-muted">@langapp('phone') #</td>
            <td class="text-right">{{  $user->profile->phone  }}</td>
        </tr>
        @endif
        <tr>
            <td class="text-muted">@langapp('locale') </td>
            <td class="text-right">{{  ucfirst($user->locale)  }}</td>
        </tr>
        <tr>
            <td class="text-muted">@langapp('hourly_rate') </td>
            <td class="text-right">{{  $user->profile->hourly_rate  }}/hr</td>
        </tr>
        <tr>
            <td class="text-muted">@langapp('city')</td>
            <td class="text-right">{{  $user->profile->city  }}</td>
        </tr>
        <tr>
            <td class="text-muted">@langapp('country')</td>
            <td class="text-right"><a href="#">{{  $user->profile->country  }}</a></td>
        </tr>
        <tr>
            <td class="text-muted">@langapp('locale')</td>
            <td class="text-right"><a href="#">{{  $user->locale  }}</a></td>
        </tr>
        <tr>
            <td class="text-muted">@langapp('address')</td>
            <td class="text-right">{{  $user->profile->address  }}</td>
        </tr>
        <tr>
            <td class="text-muted">@langapp('verified_at') </td>
            <td class="text-right">{{ is_null($user->email_verified_at) ? 'N/a' : dateTimeFormatted($user->email_verified_at) }}</td>
        </tr>
        <tr>
            <td class="text-muted">@langapp('created_at') </td>
            <td class="text-right">{{  $user->created_at->toDayDateTimeString()  }}</td>
        </tr>
        <tr>
            <td class="text-muted">@langapp('updated')</td>
            <td class="text-right">{{  $user->updated_at->toDayDateTimeString()  }}</td>
        </tr>

    </tbody>
</table>