<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\notification;
use App\Services\FirebaseService;
use App\Models\user;

class NotificationController extends Controller
{
    protected FirebaseService $firebase;

    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
    }

    public function read(){
        Notification::where('user_id', Auth::id())->whereNull('read_at')->update(['read_at' => now()]);
        return response()->json(['لقد أصبح كل المنشورات مقروءة'], 200 );
    }

    public function index()
    {
        $notifications=notification::with('sender')->where('user_id',Auth::id())->get();
        return response()->json($notifications, 200);
    }

    public function admin()
    {
        $users=User::get();
        return view('notification',compact('users'));
    }
    public function sendTest(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $result = $this->firebase->sendNotification(
            $request->input('token'),
            'تهنئة',
            'كل عام وأنتم بألف خير'
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

    public function delete(Request $request)
    {
        notification::where('id',$request->notify_id)->delete();
        return response()->json(['تم حذف الإشعار بنجاح'], 200);
    }
}
