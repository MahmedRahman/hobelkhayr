<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class FCMNotificationController
{
    protected $fcmNotificationService;

    public function __construct(FCMNotificationService $fcmNotificationService)
    {
        $this->fcmNotificationService = $fcmNotificationService;
    }

    /**
     * Send notification to a user using FCM.
     */
    public function sendNotification(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'device_token' => 'required|string',
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:255',
        ]);

        // Send the notification
        $response = $this->fcmNotificationService->sendNotification(
            $validatedData['device_token'],
            $validatedData['title'],
            $validatedData['body']
        );

        return response()->json($response);
    }
}

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