<?php

namespace App\Http\Controllers;

use App\Models\reel_comments;
use Illuminate\Http\Request;

class ReelCommentsController extends Controller
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
            'message' => 'required', 
            'reels_id' => 'required|exists:reels,id',
        ]);

        // إنشاء السجل الجديد
        reel_comments::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
            'reels_id' => $request->reels_id,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'تم التقييم بنجاح.',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(reel_comments $reel_comments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(reel_comments $reel_comments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, reel_comments $reel_comments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(reel_comments $reel_comments)
    {
        //
    }
}
