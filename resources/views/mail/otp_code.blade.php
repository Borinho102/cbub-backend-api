<x-mail::message>
# One-Time-Password (OTP)

Use the code below to verify your email address. If you didn't create an account with Cbub, you can safely delete this email.

<x-mail::button :url="''" :disabled="true">
{{ $code }}
</x-mail::button>

If that doesn't work, you can request another but take note that if you send multiple requests at a time you won't be able to receive any.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
