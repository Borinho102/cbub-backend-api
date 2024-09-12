<?php

namespace App\Channels;

use App\Models\User;
use App\Services\Firebase\FCMService;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;
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

            $this->getDeviceTokens($notifiable)
                ->chunk(1000, function ($tokens) use ($data) {
                    (new FCMService)->sendToMultiple($tokens->all(), $data['notification'], $data['data']);
                });
        } else {
            Log::warning('FIREBASE CHANNEL NOT FOUND');
        }
    }

    private function getDeviceTokens($notifiable): Collection
    {
        if ($notifiable instanceof User) {
            return $notifiable->pluck('device_token');
        }

        return collect();
    }
}
