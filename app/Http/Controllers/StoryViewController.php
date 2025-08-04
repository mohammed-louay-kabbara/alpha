<?php

namespace App\Http\Controllers;

use App\Models\story_view;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class StoryViewController extends Controller
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
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $story_view = story_view::where('story_id',$request->id)->where('user_id',Auth::id())->first();
        if ($story_view) {
            return response()->json(['مضاف مسبقا'], 200);
        }
        story_view::create([
            'story_id' => $request->id,
            'user_id' => Auth::id()
        ]);
        return response()->json(['تم الإضافة بنجاح'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(story_view $story_view)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(story_view $story_view)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, story_view $story_view)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(story_view $story_view)
    {
        //
    }
}
