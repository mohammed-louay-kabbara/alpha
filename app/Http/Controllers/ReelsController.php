<?php

namespace App\Http\Controllers;

use App\Models\reels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReelsController extends Controller
{

    public function index()
    {
      $reels = Reels::orderBy('created_at', 'desc')->get();
      return response()->json($reels);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
      
    $request->validate([
        'media_path' => 'required|mimes:mp4', // 10MB كحد أقصى
        'description' => 'nullable|string',
    ]);

    $path = $request->file('media_path')->store('reels', 'public');

    $reel = Reels::create([
        'user_id' => Auth::id(),
        'media_path' => $path,
        'description' => $request->description,
    ]);

    return response()->json([
        'status' => true,
        'message' => 'تمت الإضافة بنجاح',
    ], 201);
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
