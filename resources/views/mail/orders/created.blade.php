<x-mail::message>
# New Order Created

Hello,

You have a new order. Click the button below to see all the details on your dashboard.

<x-mail::button :url="route('business.orders.index')">
View Order
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
