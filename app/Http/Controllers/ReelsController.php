<?php

namespace App\Http\Controllers;

use App\Models\reels;
use FFMpeg;
use FFMpeg\Coordinate\TimeCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReelsController extends Controller
{
    
    public function index()
    {
                   $userId = auth()->id();

    // 1️⃣ الأشخاص الذين أتابعهم
    $followingIds = \App\Models\Follower::where('follower_id', $userId)
        ->pluck('followed_id');

    // 2️⃣ الأشخاص الذين يتابعهم من أتابعهم
    $friendsOfFriendsIds = \App\Models\Follower::whereIn('follower_id', $followingIds)
        ->pluck('followed_id');

    // 3️⃣ دمج وإزالة التكرار
    $priorityUserIds = $followingIds
        ->merge($friendsOfFriendsIds)
        ->unique()
        ->filter() // إزالة أي null
        ->values();

    $reelsQuery = Reels::with('user', 'likes');

    if ($priorityUserIds->isNotEmpty()) {
        $idsString = $priorityUserIds->implode(',');
        $reelsQuery->orderByRaw("
            CASE 
                WHEN user_id IN ($idsString) THEN 1
                ELSE 2
            END
        ");
    }

    $reels = $reelsQuery
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function ($reel) use ($userId) {
            $reel->is_following = \App\Models\Follower::where('follower_id', $userId)
                ->where('followed_id', $reel->user_id)
                ->exists();
            $reel->liked_by_user = $reel->likes->contains('user_id', $userId);
            unset($reel->likes);
            return $reel;
        });

    return response()->json($reels);
    
        // $userId = auth()->id();
        // $reels = Reels::with('user')
        //     ->orderBy('created_at', 'desc')
        //     ->get()
        //     ->map(function ($reel) use ($userId) {
        //         $reel->is_following = \App\Models\Follower::where('follower_id', $userId)
        //             ->where('followed_id', $reel->user_id)
        //             ->exists();
        //         return $reel;
        //     })
        //     ->map(function ($reel) {
        //     $reel->liked_by_user = $reel->likes->contains('user_id', auth()->id());
        //     unset($reel->likes);
        //     return $reel;
        //     });
        // return response()->json($reels);
    }

    public function getReels()
    {

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
                'media_path' => 'required', 
                'description' => 'nullable|string',
            ]);
            $path = $request->file('media_path')->store('reels', 'public');
            $thumbnailPath = 'thumbnails/' . uniqid() . '.jpg';
            $this->generateVideoThumbnail(storage_path('app/public/' . $path), storage_path('app/public/' . $thumbnailPath));
            $reel = reels::create([
                'user_id' => Auth::id(),
                'media_path' => $path,
                'thumbnail_path' => $thumbnailPath,
                'description' => $request->description,
            ]);
            return response()->json([
                'status' => true,
                'message' => 'تمت الإضافة بنجاح',
            ], 201);
        }

    public function generateVideoThumbnail($videoPath, $thumbnailPath, $second = 1)
    {
        $ffmpeg = FFMpeg\FFMpeg::create([
            'ffmpeg.binaries'  => 'C:\ffmpeg\bin\ffmpeg.exe',     // غير هذا حسب بيئتك
            'ffprobe.binaries' => 'C:\ffmpeg\bin\ffprobe.exe',    // غير هذا حسب بيئتك
            'timeout'          => 3600,
            'ffmpeg.threads'   => 12,
        ]);
        $video = $ffmpeg->open($videoPath);
        $video->frame(TimeCode::fromSeconds($second))->save($thumbnailPath);
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
