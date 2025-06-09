<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usersWithStories = User::with(['stories' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->whereHas('stories')->get();
        return response()->json($usersWithStories);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $request->validate([
        'media' => 'required|file|mimes:jpg,jpeg,png,mp4',
        'type' => 'required|in:image,video',
        'caption' => 'nullable|string']);
        $path = $request->file('media')->store('stories', 'public');
        $story = Story::create([
            'user_id' => Auth::id(),
            'media' => $path,
            'type' => $request->type,
            'caption' => $request->caption,
            'expires_at' => now()->addDay(), // 24 ساعة
        ]);
        return response()->json(['status' => true, 'story' => $story]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Story $story)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Story $story)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Story $story)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Story $story)
    {
        //
    }
}
