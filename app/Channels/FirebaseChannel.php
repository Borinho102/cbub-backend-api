<?php

namespace App\Channels;

use App\Models\User;
use App\Services\Firebase\FCMService;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;

class FirebaseChannel
{
    /**
     * Send the given notification.
     */
    public function send(object $notifiable, Notification $notification): void
    {
        $notification = $notification->toFirebase($notifiable);

        $this->getDeviceTokens($notifiable)
            ->chunk(1000, function ($tokens) use ($notification) {
                (new FCMService)->sendToMultiple($tokens->all(), null, $notification);
            });
    }

    private function getDeviceTokens($notifiable): Collection
    {
        if ($notifiable instanceof User) {
            return $notifiable->pluck('device_token');
        }

        return collect();
    }
}
