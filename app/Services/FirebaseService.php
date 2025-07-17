<?php

namespace App\Services;

use Google\Auth\Credentials\ServiceAccountCredentials;
use GuzzleHttp\Client;

class FirebaseService
{
    protected ServiceAccountCredentials $credentials;
    protected Client $http;
    protected string $projectId;

    public function __construct()
    {
        // مسار ملف JSON
        $keyFile = base_path(env('FIREBASE_CREDENTIALS'));

        // نطاق الأذونات لـ FCM
        $scopes = ['https://www.googleapis.com/auth/firebase.messaging'];

        $this->credentials = new ServiceAccountCredentials($scopes, $keyFile);
        $this->http = new Client();
        $this->projectId = env('FIREBASE_PROJECT_ID');
    }

    /**
     * جلب توكن الوصول (access token)
     */
    protected function getAccessToken(): string
    {
        $authToken = $this->credentials->fetchAuthToken($this->http);
        return $authToken['access_token'] ?? '';
    }

    /**
     * إرسال إشعار إلى جهاز محدد عبر FCM HTTP v1 API
     *
     * @param string $deviceToken
     * @param string $title
     * @param string $body
     * @param array  $dataPayload (اختياري)
     */
    public function sendNotification(
        string $deviceToken,
        string $title,
        string $body,
        array  $dataPayload = []
    ): array {
        $url = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";

        $message = [
            'message' => [
                'token'        => $deviceToken,
                'notification' => [
                    'title' => $title,
                    'body'  => $body,
                ],
                // بيانات إضافية يقرأها التطبيق
                'data' => $dataPayload,
            ],
        ];

        $response = $this->http->post($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getAccessToken(),
                'Content-Type'  => 'application/json',
            ],
            'json' => $message,
        ]);

        return json_decode((string) $response->getBody(), true);
    }
}
