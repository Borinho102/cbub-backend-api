<?php

namespace App\Contracts;

use Kreait\Firebase\Messaging\Notification;

interface FirebaseMessagingContract
{
    public function toSingle(Notification $notification, string $deviceToken, array $data) : void;

    public function toMultiple(Notification $notification, array $deviceTokens, array $data): void;
}
