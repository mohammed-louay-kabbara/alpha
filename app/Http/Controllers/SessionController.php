<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserSession;
use Carbon\Carbon;

class SessionController extends Controller
{
    public function startSession(Request $request)
    {
        $session = UserSession::create([
            'user_id' => auth()->id(),
            'started_at' => now()
        ]);

        return response()->json([
            'session_id' => $session->id,
            'message' => 'Session started'
        ]);
    }

    public function endSession(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:user_sessions,id'
        ]);
        $session = UserSession::find($request->session_id);
        if ($session->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $startedAt = Carbon::parse($session->started_at);
        $duration = $startedAt->diffInSeconds(now());

        $session->update([
            'ended_at' => now(),
            'duration' => $duration
        ]);
        return response()->json(['message' => 'Session ended']);
    }
}
