@component('mail::message')
# Your elevated access rights have been revoked

Your {{ config('app.name') }} account had elevated access rights, however you did not log in for a long time.

For security purposes, we revoke elevated access rights from accounts after one year of inactivity.

Your elevated access rights have now been revoked.

Your account remains open, and you can continue to use the system as an unelevated user.

You do not need to take any action.

If you require elevated access rights again, you can contact support.

@component('mail::button', ['url' => route('support-page.show')])
Contact support
@endcomponent

@component('mail::subcopy')
This is an automated message from the {{ config('app.name') }} system.

You are receiving this e-mail because you had elevated rights in the system but had not logged in for a long time.
@endcomponent
@endcomponent
