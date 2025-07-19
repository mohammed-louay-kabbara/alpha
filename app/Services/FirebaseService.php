<?php

namespace App\Services;

use Google\Auth\ApplicationDefaultCredentials;
use Google\Auth\HttpHandler\HttpHandlerFactory;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;

class FirebaseService
{
    protected Client $http;
    protected string $projectId;

    public function __construct()
    {
        // تعيين مسار ملف الخدمة
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . base_path(env('FIREBASE_CREDENTIALS')));

        // نطاق الأذونات المطلوبة لـ FCM
        $scopes = ['https://www.googleapis.com/auth/firebase.messaging'];

        // إنشاء handler للـ HTTP
        $httpHandler = HttpHandlerFactory::build();

        // إنشاء middleware للمصادقة
        $middleware = ApplicationDefaultCredentials::getMiddleware($scopes, $httpHandler);

        // تجهيز stack لـ Guzzle
        $stack = HandlerStack::create();
        $stack->push($middleware);

        // إنشاء العميل HTTP
        $this->http = new Client([
            'handler' => $stack,
            'auth'    => 'google_auth',
        ]);

        $this->projectId = env('FIREBASE_PROJECT_ID');
    }

    /**
     * إرسال إشعار إلى جهاز محدد عبر FCM HTTP v1 API
     *
     * @param string $deviceToken
     * @param string $title
     * @param string $body
     * @param array  $dataPayload (اختياري)
     * @return array
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
                'token' => $deviceToken,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'data' => $dataPayload,
            ],
        ];

        $response = $this->http->post($url, [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => $message,
        ]);

        return json_decode((string) $response->getBody(), true);
    }
}
