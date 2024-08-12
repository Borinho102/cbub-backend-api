<?php

namespace App\Listeners;

use App\Events\NewOrderCreated;
use App\Mail\OrderCreated;
use App\Models\BusinessUser;
use App\Models\Customer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class NewOrderCreatedListener implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(NewOrderCreated $event): void
    {
        $order = $event->order;

        Customer::updateOrCreate([
            'business_id' => $order->business_id,
            'user_id' => $order->customer_id
        ], []);

        $owner = BusinessUser::where('business_id', $order->business_id)->whereHasRole('business_owner')->first();

        Mail::to($owner)
            ->bcc(BusinessUser::where('business_id', $order->business_id)->get())
            ->send(new OrderCreated($order));
    }
}
