<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use App\Models\BroadcastNotification as ModelsNotification;
use Illuminate\Support\Facades\Log;

class BroadcastNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected ModelsNotification $notification)
    {
        if ($this->notification->broadcast_at) {
            $this->delay = now()->addMinutes(now()->diffInMinutes($this->notification->broadcast_at));
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        $viaRoutes = isset($notifiable->device_token) ?
            ['firebase', 'database'] : ['database'];
        Log::info('delivery channels => ', $viaRoutes);

        return $viaRoutes;
    }

    /**
     * Get the firebase representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toFirebase(object $notifiable): array
    {
        Log::info('Getting firebase reprentation of the notification channels');
        
        return [
            'notification' => [
                'title' => $this->notification->getTranslation('title', $notifiable->language, true),
                'body' => $this->notification->getTranslation('body', $notifiable->language, true),
                'image' => $this->notification->getTranslation('image', $notifiable->language, true),
            ],
            'data' => [
                'broadcast_notification_id' => $this->notification->id,
                'shop_id' => $this->notification->shop_id,
                'business_id' => $this->notification->business_id,
                'notification_type' => $this->notification->type,
                'image' => $this->notification->image
            ]
        ];
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
            'title' => $this->notification->getTranslation('title', $notifiable->language, true),
            'body' => $this->notification->getTranslation('body', $notifiable->language, true),
            'image' => $this->notification->getTranslation('image', $notifiable->language, true),
            'shop_id' => $this->notification->shop_id,
            'business_id' => $this->notification->business_id,
            'notification_type' => $this->notification->type
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
