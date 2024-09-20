<?php


namespace App\Services\Firebase;

use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\InvalidArgumentException;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Messaging;
use Kreait\Firebase\Messaging\AndroidConfig;
use Kreait\Firebase\Messaging\ApnsConfig;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\SendReport;
use Kreait\Firebase\Messaging\WebPushConfig;

class FCMService
{
    protected Messaging $messaging;

    public function __construct()
    {
        $this->messaging = app('firebase.messaging');
    }

    public function sendNotification(
        string $deviceToken, $notificationConfig = null, array $notification = null, array $data =  null
    ) {
        try {
            $message = CloudMessage::withTarget('token', $deviceToken);

            if ($notificationConfig instanceof AndroidConfig) {
                $message = $message->withAndroidConfig($notificationConfig);
            } else if ($notificationConfig instanceof ApnsConfig) {
                $message = $message->withApnsConfig($notificationConfig);
            } else if ($notificationConfig instanceof WebPushConfig) {
                $message = $message->withWebPushConfig($notificationConfig);
            } else {
                $message = $message->withNotification($notification)
                    ->withData($data);
            }

            Log::info('MESSAGING PAYLOAD: ' . json_encode($message->jsonSerialize(), true));

            $response = $this->messaging->send($message);
            Log::info('RESPONSE: ' . json_encode($response, true));
        } catch (MessagingException $e) {
            Log::error('MESSAGING EXCEPTION (MESSAGE): ' . $e->getMessage());
            Log::error('MESSAGING EXCEPTION (ERRORS): ' . $e->errors());
        } catch (FirebaseException $e) {
            Log::error('FIREBASE EXCEPTION MESSAGE: ' . $e->getMessage());
        } catch (InvalidArgumentException $e) {
            Log::error('FIREBASE EXCEPTION MESSAGE: ' . $e->getMessage());
        }
    }

    public function sendToMultiple(
        array $deviceTokens, array $notification,
        array $data, $notificationConfig = null
    ) {
        try {
            $message = CloudMessage::fromArray([
                'data' => $data,
                'notification' => $notification
            ]);

            if ($notificationConfig instanceof AndroidConfig) {
                $message = $message->withAndroidConfig($notificationConfig);
            } else if ($notificationConfig instanceof ApnsConfig) {
                $message = $message->withApnsConfig($notificationConfig);
            } else if ($notificationConfig instanceof WebPushConfig) {
                $message = $message->withWebPushConfig($notificationConfig);
            }

            Log::info('MESSAGING PAYLOAD: ' . json_encode($message->jsonSerialize(), true));

            $report = $this->messaging->sendMulticast($message, $deviceTokens);

            Log::debug('Successful sends: '. $report->successes()->count());
            Log::debug('Failed sends: '. $report->failures()->count());
            Log::debug('Unknown tokens: '. count($report->unknownTokens()));
            Log::debug('Invalid tokens: '. count($report->invalidTokens()));
            Log::debug('Report Errors: ', $report->failures()->map(function (SendReport $item) {
                return $item->error()->getMessage() . ':' . $item->error()->getLine();
            }));
        } catch (MessagingException $e) {
            Log::error('MESSAGING EXCEPTION (MESSAGE): ' . $e->getMessage());
            Log::error('MESSAGING EXCEPTION (ERRORS): ' . $e->errors());
        } catch (FirebaseException $e) {
            Log::error('FIREBASE EXCEPTION MESSAGE: ' . $e->getMessage());
        } catch (InvalidArgumentException $e) {
            Log::error('FIREBASE EXCEPTION MESSAGE: ' . $e->getMessage());
        }
    }
}
