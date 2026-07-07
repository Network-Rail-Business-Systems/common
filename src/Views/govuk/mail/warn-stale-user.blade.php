@component('mail::message')
# Your elevated access rights will be revoked on {{ $cutoff->format('d/m/Y') }}

You have an account with elevated access rights in the {{ config('app.name') }} System, however you have not logged in for a long time.

For security purposes, we revoke elevated access rights from accounts after one year of inactivity.

If you want to keep your elevated access rights, log into the system before {{ $cutoff->format('d/m/Y') }}.

You do not need to take any action if you:

* no longer use this system
* do not need elevated access
* do not think you should have elevated access

Your account will still remain open, and you will be able to continue using the system as an unelevated user.

@component('mail::button', ['url' => config('app.url')])
Access system
@endcomponent

@component('mail::subcopy')
This is an automated message from the {{ config('app.name') }} system.

You are receiving this e-mail because you have elevated rights in the system but have not logged in for a long time.
@endcomponent
@endcomponent
