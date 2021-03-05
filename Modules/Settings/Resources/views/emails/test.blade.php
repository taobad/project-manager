@component('mail::message')
# Test Email

{{ $message }}

If this was you, this email means that your configuration works!

If this was not you, please ignore this email.

😁👍💚 Emails working correctly,<br>
{{ get_option('company_name') }}
@endcomponent