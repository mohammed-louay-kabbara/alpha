<?php

namespace App\Http\Controllers;

use App\Models\product_like;
use Illuminate\Http\Request;

class ProductLikeController extends Controller
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
           $request->validate([
            'type' => 'required|in:like,dislike', 
            'product_id' => 'required|exists:reels,id',
        ]);

        // تحقق إذا كان المستخدم سجل إعجابًا أو عدم إعجاب مسبقًا
        $existing = product_like::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
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
            'product_id' => $request->product_id,
        ]);

        // تحديث العدادات
        $reel = reels::find($request->product_id);

        if ($request->type == 'like') {
            $reel->increment('likes_count');
        } else {
            $reel->increment('dislikes_count');
        }
        return response()->json([
            'status' => true,
            'message' => 'تم التقييم بنجاح.',
        ], 201);
  
    }

    /**
     * Display the specified resource.
     */
    public function show(product_like $product_like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(product_like $product_like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, product_like $product_like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(product_like $product_like)
    {
        //
    }
}
