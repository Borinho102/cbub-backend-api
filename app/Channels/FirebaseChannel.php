<?php

namespace App\Channels;

use App\Models\User;
use App\Services\Firebase\FCMService;
use Illuminate\Notifications\Notification;

class FirebaseChannel
{
    /**
     * Send the given notification.
     */
    public function send(object $notifiable, Notification $notification): void
    {
        if (method_exists($notification, 'toFirebase')) {
            $data = $notification->toFirebase($notifiable);
            $tokens = $this->getDeviceTokens($notifiable);

            if (count($tokens) === 1) {
                (new FCMService)->sendNotification(
                    $tokens[0],
                    null,
                    $data['notification'],
                    $data['data']
                );
            } else {
                (new FCMService)->sendToMultiple(
                    $this->getDeviceTokens($notifiable),
                    $data['notification'],
                    $data['data']
                );
            }
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
