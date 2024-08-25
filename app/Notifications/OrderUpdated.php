<?php

namespace App\Notifications;

use App\Models\OrderStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class OrderUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected OrderStatus $orderStatus) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'firebase'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {

        return [
            'title' => sprintf('Order %s %s!', $this->orderStatus->order->order_id, $this->orderStatus->to_status),
            'body' => sprintf('Your order has been %s %s!', $this->orderStatus->order->order_id, $this->orderStatus->to_status),
            'order_id' => $this->orderStatus->order_id,
            'status' => $this->orderStatus->to_status,
            'redirect_to' => '/orders/' . $this->orderStatus->order_id
        ];
    }
}
