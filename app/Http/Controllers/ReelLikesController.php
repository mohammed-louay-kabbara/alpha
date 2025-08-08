<?php

namespace App\Http\Controllers;

use App\Models\reel_likes;
use App\Models\reels;
use App\Models\notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewOrderNotification;

class ReelLikesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
   
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:like,dislike', 
            'reels_id' => 'required|exists:reels,id',
        ]);
        $existing = reel_likes::where('user_id', Auth::id())
            ->where('reels_id', $request->reels_id)
            ->first();
        if ($existing) {
            $existing->delete();
            return response()->json([
            'status' => true,
            'message' => 'تم إلغاء الإعجاب بنجاح',], 200);
        }
        // إنشاء السجل الجديد
        reel_likes::create([
            'user_id' => Auth::id(),
            'type' => $request->type,
            'reels_id' => $request->reels_id,
        ]);
        // تحديث العدادات
        $reel = reels::find($request->reels_id);
            $reel->increment('likes_count');
            notification::create([
                'user_id' => $reel->user_id,
                'title' => 'تفاعل',
                'body' => 'تم تسجيل إعجاب على الريلز خاصتك',
                'sender_id' => Auth::id()
            ]);
        return response()->json([
                'status' => true,
                'message' => 'تم التقييم بنجاح.',
            ], 201);
    }

    

    /**
     * Display the specified resource.
     */
    public function show(reel_likes $reel_likes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(reel_likes $reel_likes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, reel_likes $reel_likes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(reel_likes $reel_likes)
    {
        //
    }
}
