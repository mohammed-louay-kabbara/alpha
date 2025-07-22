<?php

namespace App\Http\Controllers;

use App\Models\reel_comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReelCommentsController extends Controller
{

    public function index()
    {
        
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
            'reels_id' => 'required',
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
    public function show($id)
    {
        $reel_comments= reel_comments::with('user')->where('reels_id',$id)->get();
        return response()->json($reel_comments, 200);
    }

    public function edit(reel_comments $reel_comments)
    {
        //
    }

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
