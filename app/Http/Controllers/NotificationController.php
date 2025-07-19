<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FirebaseService;

class NotificationController extends Controller
{
    protected FirebaseService $firebase;

    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
    }
   

    public function sendTest(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $result = $this->firebase->sendNotification(
            $request->input('token'),
            'عنوان الاختبار',
            'هذه رسالة تجريبية من Laravel'
        );
        return response()->json($result);
    }

      public function send(Request $request, FirebaseService $firebaseService)
    {
        $request->validate([
            'device_token' => 'required|string',
            'title'        => 'required|string',
            'body'         => 'required|string',
        ]);

        try {
            $response = $firebaseService->sendNotification(
                $request->device_token,
                $request->title,
                $request->body,
                $request->data ?? []
            );

            return response()->json([
                'success' => true,
                'response' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
