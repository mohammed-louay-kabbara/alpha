<?php

namespace App\Http\Controllers;

use App\Models\reel_likes;
use App\Models\reels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        // تحقق إذا كان المستخدم سجل إعجابًا أو عدم إعجاب مسبقًا
        $existing = reel_likes::where('user_id', Auth::id())
            ->where('reels_id', $request->reels_id)
            ->first();

        if ($existing) {
            return response()->json([
                'status' => false,
                'message' => 'لقد قمت بتقييم هذا الريلز مسبقًا.',
            ], 409);
        }

        // إنشاء السجل الجديد
        reel_likes::create([
            'user_id' => Auth::id(),
            'type' => $request->type,
            'reels_id' => $request->reels_id,
        ]);

        // تحديث العدادات
        $reel = reels::find($request->reels_id);

        if ($request->type == 'like') {
            $reel->increment('likes_count');
        } else {
            $reel->increment('dislikes_count');
        }
        return response()->json([
            'status' => true,
            'message' => 'تم التقييم بنجاح.',
        ], 201);
    //     $reel_like = reel_likes::where('user_');
    //     $request->validate([
    //     'type' => 'required', 
    //     'reels_id' => 'required',]);

    // $reel = reel_likes::create([
    //     'user_id' => Auth::id(),
    //     'type' => $request->type,
    //     'reels_id' => $request->reels_id,
    // ]);
    //   $reel=reels::where('id',$request->reels_id)->first();
    //   if ($request->type == 'like') {
    //        reels::where('id',$request->reels_id)->update([
    //       'likes_count' => $reel->likes_count + 1 ]);
    //     }
    //   else {
    //     reels::where('id',$request->reels_id)->update([
    //     'dislikes_count' => $reel->dislikes_count + 1]);
    //   }

    // return response()->json([
    //     'status' => true,
    //     'message' => 'تمت الإضافة بنجاح',
    // ], 201);
        
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
