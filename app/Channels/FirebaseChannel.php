<?php

namespace App\Channels;

use App\Models\User;
use App\Services\Firebase\FCMService;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class FirebaseChannel
{
    /**
     * Send the given notification.
     */
    public function send(object $notifiable, Notification $notification): void
    {
        if (method_exists($notification, 'toFirebase')) {
            $data = $notification->toFirebase($notifiable);

            (new FCMService)->sendToMultiple(
                $this->getDeviceTokens($notifiable),
                $data['notification'],
                $data['data']
            );
        }
    }

    private function getDeviceTokens($notifiable): array
    {
        if ($notifiable instanceof User) {
            return [$notifiable->device_token];
        } else if (is_array($notifiable)) {
            return collect($notifiable)->pluck('device_token')->all();
        }

        return $notifiable->pluck('device_token')->all();
    }
}
