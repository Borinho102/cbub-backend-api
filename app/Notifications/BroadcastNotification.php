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
        return isset($notifiable->device_token) ?
            ['firebase', 'database'] : ['database'];
    }

    /**
     * Get the firebase representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toFirebase(object $notifiable): array
    {
        $image = $this->notification->getTranslation('image', $notifiable->language, true);

        $data = [
            'notification' => [
                'title' => $this->notification->getTranslation('title', $notifiable->language, true),
                'body' => $this->notification->getTranslation('body', $notifiable->language, true),
            ],
            'data' => [
                'broadcast_notification_id' => $this->notification->id,
                'notification_type' => $this->notification->type
            ]
        ];

        if (!empty($image)) {
            $data['notification']['image'] = asset('storage/'. $image);
            $data['data']['image'] = asset('storage/'. $image);
        }

        if (isset($this->notification->shop_id)) {
            $data['data']['shop_id'] = $this->notification->shop_id;
        }

        if (isset($this->notification->business_id)) {
            $data['data']['business_id'] = $this->notification->business_id;
        }

        return $data;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $image = $this->notification->getTranslation('image', $notifiable->language, true);

        $data = [
            'broadcast_notification_id' => $this->notification->id,
            'title' => $this->notification->getTranslation('title', $notifiable->language, true),
            'body' => $this->notification->getTranslation('body', $notifiable->language, true),
            'notification_type' => $this->notification->type
        ];

        if (!empty($image)) {
            $data['image'] = $image;
        }

        if (isset($this->notification->shop_id)) {
            $data['shop_id'] = $this->notification->shop_id;
        }

        if (isset($this->notification->business_id)) {
            $data['business_id'] = $this->notification->business_id;
        }

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
