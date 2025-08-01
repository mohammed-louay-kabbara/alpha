<?php

namespace App\Http\Controllers;

use App\Models\follower;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowerController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $followingIds = $user->following()->pluck('followed_id');
        $suggested = User::where('id', '!=', $user->id)
                        ->whereNotIn('id', $followingIds)
                        ->take(10)
                        ->get();
        return response()->json($suggested);
    }


    public function create()
    {
        //
    }
    public function getFollower()
    {
        $followers=follower::with('user')->where('followed_id',Auth::id())->get();
        return response()->json($followers, 200);
    }

    public function store(Request $request)
    {

        $userIdToFollow = $request->input('user_id');
        $followerId = auth()->id();
        if ($followerId == $userIdToFollow) {
            return response()->json(['message' => 'لا يمكنك متابعة نفسك'], 400);
        }

        $existing = follower::where('follower_id', $followerId)
                            ->where('followed_id', $userIdToFollow)
                            ->first();
        if ($existing) {
            $existing->delete();
            return response()->json(['status' => 'unfollowed']);
        } else {
            follower::create([
                'follower_id' => $followerId,
                'followed_id' => $userIdToFollow
            ]);

            return response()->json(['status' => 'followed']);
        }
    }

    public function suggestedFollows()
    {
        $currentUser = Auth::user();
        
        // 1. الحصول على قائمة متابعي المستخدم الحالي
        $followerIds = $currentUser->followers()->pluck('users.id');
        
        // 2. إذا لم يكن لديه متابعين، نرجع مستخدمين عشوائيين
        if($followerIds->isEmpty()) {
            $suggestedUsers = User::where('id', '!=', $currentUser->id)
                ->whereNotIn('id', $currentUser->following()->pluck('users.id'))
                ->inRandomOrder()->get();
                
             return response()->json($suggestedUsers, 200);
        }
        
        // 3. الحصول على المقترحات
        $suggestedUsers = User::whereHas('followers', function($query) use ($followerIds) {
                $query->whereIn('follower_id', $followerIds);
            })
            ->where('id', '!=', $currentUser->id)
            ->whereNotIn('id', $currentUser->following()->pluck('users.id'))
            ->withCount(['followers as common_followers' => function($query) use ($followerIds) {
                $query->whereIn('follower_id', $followerIds);
            }])
            ->orderByDesc('common_followers')
            ->get();
        
        return response()->json($suggestedUsers, 200);
    }


    public function show(follower $follower)
    {
        
    }


    public function edit(follower $follower)
    {
        //
    }


    public function update(Request $request, follower $follower)
    {
        
    }

    public function deleteFollower(Request $request)
    {
        $follower=follower::where('follower_id',$request->follower_id)
            ->where('followed_id',Auth::id())->first();
        if ($follower == null) {
            return response()->json(['لست صديقه'], 403);
        }
        else {
            $follower->delete();
            return response()->json(['تم إلغاء المتابعة'], 200);
        }
    }



    public function destroy(Request $request)
    {
    }
}
