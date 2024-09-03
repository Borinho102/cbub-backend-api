<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use App\Models\BroadcastNotification as ModelsNotification;

class BroadcastNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected ModelsNotification $notification)
    {
        if ($this->notification->broadcast_at) {
            $this->delay = now()->addHours(now()->diffInHours($this->notification->broadcast_at));
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return isset($notifiable->device_token) ?
            ['firebase', 'database'] : ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $data = [
            'broadcast_notification_id' => $this->notification->id,
            'title' => $this->notification->title,
            'body' => $this->notification->body,
            'shop_id' => $this->notification->shop_id,
            'business_id' => $this->notification->business_id,
            'notification_type' => $this->notification->type,
            'image' => $this->notification->image
        ];

        if ($this->notification->shop) {
            $data['shop'] = [
                'id' => $this->notification->shop->id,
                'name' => $this->notification->shop->name,
                'image' => $this->notification->shop->image
            ];
        }

        if (isset($this->notification['data'])) {
            foreach ($this->notification['data'] as $key => $value) {
                $data[$key] = $value;
            }
        }

        return $data;
    }
}
