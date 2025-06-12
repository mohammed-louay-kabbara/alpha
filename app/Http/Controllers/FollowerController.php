<?php

namespace App\Http\Controllers;

use App\Models\follower;
use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(follower $follower)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(follower $follower)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, follower $follower)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(follower $follower)
    {
        //
    }
}
