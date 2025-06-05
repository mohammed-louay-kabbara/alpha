<?php

namespace App\Http\Controllers;

use App\Models\reel_likes;
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

    /**
     * Store a newly created resource in storage.
     */

   
    public function store(Request $request)
    {
        $request->validate([
        'type' => 'required', // 10MB كحد أقصى
        'reels_id' => 'required',]);

    $reel = reel_likes::create([
        'user_id' => Auth::id(),
        'type' => $request->type,
        'reels_id' => $request->reels_id,
    ]);

    return response()->json([
        'status' => true,
        'message' => 'تمت الإضافة بنجاح',
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
