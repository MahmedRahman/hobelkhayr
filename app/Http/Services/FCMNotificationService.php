<?php

namespace App\Services;

use Kreait\Firebase\Factory;

class FCMNotificationService
{
    protected $messaging;

    public function __construct()
    {
        // Initialize Firebase Messaging
        $this->messaging = (new Factory)
            ->withServiceAccount(config('services.firebase.credentials_file'))
            ->createMessaging();
    }

    /**
     * Send a notification via FCM
     *
     * @param string $deviceToken The FCM token for the device to receive the notification
     * @param string $title Notification title
     * @param string $body Notification body
     * @param array $data Additional data payload
     * @return array
     */
    public function sendNotification(string $deviceToken, string $title, string $body, array $data = [])
    {
        $message = [
            'token' => $deviceToken,
            'notification' => [
                'title' => $title,
                'body' => $body,
            ],
            'data' => $data,
        ];

        try {
            $this->messaging->send($message);

            return [
                'success' => true,
                'message' => 'Notification sent successfully!',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to send notification: ' . $e->getMessage(),
            ];
        }
    }
}