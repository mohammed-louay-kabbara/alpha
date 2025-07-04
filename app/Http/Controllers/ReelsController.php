<?php

namespace App\Http\Controllers;

use App\Models\reels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReelsController extends Controller
{

    public function index()
    {
      $reels = Reels::with('user')->orderBy('created_at', 'desc')->get();
      return response()->json($reels);
    }


    public function create()
    {
        $reels = Reels::with('user')->orderBy('created_at', 'desc')->get();
        return view('reels',compact('reels'));
    }

    public function homereels(){
        $reels = Reels::with('user')
            ->orderBy('created_at', 'desc')
            ->take(2)
            ->get();
        return response()->json($reels);
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

    public function show($id)
    {
        $reels=reels::where('user_id',$id)->get();
        return response()->json($reels, 200);
    }


    public function edit(reels $reels)
    {
        //
    }


    public function update(Request $request, reels $reels)
    {
        //
    }


    public function destroy($id)
    {
        $reels = reels::findOrFail($id);
            // حذف الصورة من storage/public
        if ($reels->media_path && Storage::disk('public')->exists($reels->media_path)) {
            Storage::disk('public')->delete($reels->media_path);
        }
        
        $reels->delete();
        return back()->with('success', 'تم حذف الصنف بنجاح');
    }
}
