<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if(config('system.logo_on_emails'))
<img src="{{ getStorageUrl(config('system.media_dir').'/'.get_option('company_logo')) }}" class="logo" alt="{{ get_option('company_name') }}" width="150">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
