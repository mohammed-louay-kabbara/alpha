<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\notification;
use App\Services\FirebaseService;
use App\Models\user;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

    public function admin_notification(){
            $users = User::with(['sessions' => function($query) {
                $query->latest('started_at')->limit(1);
            }])
            ->select('id', 'name', 'email', 'picture', 'phone', 'datebirthday', 'address', 'description', 'role', 'created_at')
            ->withCount('sessions')
            ->addSelect([
                'average_session_duration' => DB::table('user_sessions')
                    ->selectRaw('AVG(TIMESTAMPDIFF(SECOND, started_at, COALESCE(ended_at, NOW())))')
                    ->whereColumn('user_id', 'users.id')
                    ->whereNotNull('started_at')
            ])->paginate(20);
        return view('notification', compact('users'));
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

    public function khamenon(Request $request)
    {
        $inactiveUsers = User::with('DeviceToken')->whereDoesntHave('sessions', function ($query) {
        $query->where('started_at', '>=', now()->subMonth());
        })->get();

        foreach($inactiveUsers as $i)
        {
            if($i->DeviceToken?->token) {
            $result = $this->firebase->sendNotification(
            $i->DeviceToken->token,
            $request->title,
            $request->message);
            }
            notification::create([
                'user_id' => $i->id,
                'title' => $request->title,
                'body' => $request->message,
                'sender_id' =>4 ]);
        }
        return back();
    }
    public function think_you(Request $request)
    {
        $topUsers = User::with('DeviceToken')->withCount('product')
            ->orderByDesc('product_count')
            ->limit(5)
            ->get();
        foreach($topUsers as $i)
        {
            if($i->DeviceToken?->token) {
            $result = $this->firebase->sendNotification(
            $i->DeviceToken->token,
            $request->title,
            $request->message);
            }
            notification::create([
                'user_id' => $i->id,
                'title' => $request->title,
                'body' => $request->message,
                'sender_id' =>4 ]);
        }
        return back();
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'title' => 'required|string',
            'body' => 'required|string',
        ]);

        $users = User::whereIn('id', $request->user_ids)->with('DeviceToken')->get();

        foreach ($users as $user) {
            if ($user->DeviceToken && $user->DeviceToken->token) {
                $this->firebase->sendNotification(
                    $user->DeviceToken->token,
                    $request->title,
                    $request->body
                );
            }

            Notification::create([
                'user_id' => $user->id,
                'title' => $request->title,
                'body' => $request->body,
                'sender_id' => auth()->id()
            ]);
        }

        return back()->with('success', 'تم إرسال الرسالة بنجاح.');
    }

    public function delete(Request $request)
    {
        notification::where('id',$request->notify_id)->delete();
        return response()->json(['تم حذف الإشعار بنجاح'], 200);
    }
}
