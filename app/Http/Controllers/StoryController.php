<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class StoryController extends Controller
{

    public function index()
    {
        $usersWithStories = User::with(['stories' => function ($query) {
            $query->orderBy('created_at', 'desc');
            $query->withCount('views');
        }])->whereHas('stories')->get();
        return response()->json($usersWithStories);
    }


    public function create()
    { 
        $followingIds = auth()->user()->followings()->pluck('users.id')->toArray();
        $ids = array_unique(array_merge($followingIds, [auth()->id()]));
        $usersWithStories = User::whereIn('id', $ids)
            ->whereHas('stories')
            ->with(['stories' => function ($q) {
                $q->orderByDesc('created_at')->withCount('views');
            }])->get();
            return response()->json($usersWithStories);
    }
    public function addcount()
    {
        
    }


    public function store(Request $request)
    {
        if ($request->media) {
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
            $story = Story::create([
                'user_id' => Auth::id(),
                'caption' => $request->caption,
                'expires_at' => now()->addDay(), // 24 ساعة
            ]);

    }


    public function show(Story $story)
    {
        //
    }


    public function edit(Story $story)
    {
        //
    }


    public function update(Request $request, Story $story)
    {
        //
    }


    public function destroy($id)
    {
        Story::where('id',$id)->delete();
        return response()->json(['تم الحذف بنجاح'], 200);
    }
}
