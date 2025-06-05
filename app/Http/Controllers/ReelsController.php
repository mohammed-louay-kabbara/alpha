<?php

namespace App\Http\Controllers;

use App\Models\reels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReelsController extends Controller
{

    public function index()
    {
       $reels = reels::get()->orderBy('created_at', 'desc');
       return response()->json($reels);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $request->validate([
        'media' => 'required|mimes:mp4',
        'description' => 'nullable|string',
    ]);
        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'errors'  => $validator->errors(),
            ], 422);
        }
      $path = $request->file('media')->store('reels', 'public');
      $reel = reels::create([
        'user_id' => Auth::id(),
        'media_path' => $path,
        'description' => $request->description,
    ]);
    return response()->json($reel);
    }
    public function react(Request $request)
    {
        
    } 


    public function show(reels $reels)
    {
        
    }


    public function edit(reels $reels)
    {
        //
    }


    public function update(Request $request, reels $reels)
    {
        //
    }


    public function destroy(reels $reels)
    {
        //
    }
}
