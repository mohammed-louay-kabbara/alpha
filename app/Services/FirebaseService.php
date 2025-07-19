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
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . base_path(env('FIREBASE_CREDENTIALS')));

        $scopes = ['https://www.googleapis.com/auth/firebase.messaging'];
        $httpHandler = HttpHandlerFactory::build();
        $middleware = ApplicationDefaultCredentials::getMiddleware($scopes, $httpHandler);

        $stack = HandlerStack::create();
        $stack->push($middleware);

        $this->http = new Client([
            'handler' => $stack,
            'auth'    => 'google_auth',
        ]);

        $this->projectId = env('FIREBASE_PROJECT_ID');
    }

    public function sendNotification(string $deviceToken, string $title, string $body, array $dataPayload = []): array
    {
        $url = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";

        $message = [
            'message' => [
                'token' => $deviceToken,
                'notification' => [
                    'title' => $title,
                    'body'  => $body,
                ],
                'data' => [
                    'type' => 'demo',
                    'id'   => '123',
                ],
            ], ];
        

        $response = $this->http->post($url, [
            'headers' => ['Content-Type' => 'application/json'],
            'json'    => $message,
        ]);

        return json_decode((string) $response->getBody(), true);
    }
}
