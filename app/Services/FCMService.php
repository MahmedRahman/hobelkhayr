<?php

namespace App\Services;

use Exception;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FCMService
{
    protected $messaging;

    public function __construct()
    {
        $factory = (new Factory)->withServiceAccount(config('services.firebase.credentials_file'));
        $this->messaging = $factory->createMessaging();
    }

    public function sendToDevice($deviceToken, $title, $body, $data = [])
    {
        try {
            $message = CloudMessage::withTarget('token', $deviceToken)
                ->withNotification(Notification::create($title, $body))
                ->withData($data);

            $this->messaging->send($message);
            return true;
        } catch (Exception $e) {
            \Log::error('FCM Error: ' . $e->getMessage());
            return false;
        }
    }

    public function sendToMultipleDevices($deviceTokens, $title, $body, $data = [])
    {
        try {
            $message = CloudMessage::new()
                ->withNotification(Notification::create($title, $body))
                ->withData($data);

            $this->messaging->sendMulticast($message, $deviceTokens);
            return true;
        } catch (Exception $e) {
            \Log::error('FCM Error: ' . $e->getMessage());
            return false;
        }
    }
}
