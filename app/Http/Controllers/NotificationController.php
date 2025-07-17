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
}
