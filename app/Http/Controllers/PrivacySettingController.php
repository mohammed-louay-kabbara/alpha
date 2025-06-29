<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserPrivacySetting;

class PrivacySettingController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
        'followers_visibility' => 'in:everyone,only_me',
        ]);
        $found=UserPrivacySetting::where('user_id',Auth::id())->first();
        if ($found == null) {
                UserPrivacySetting::create([
                'followers_visibility' => $request->followers_visibility,
                'user_id' => Auth::id()
            ]);
            return response()->json(['تم حفظ الإعدادات'], 200);
        }
        else {
                $found->update(['followers_visibility' => $request->followers_visibility]);
                return response()->json(['تم حفظ الإعدادات'], 200);
        }
    }

    public function profilevisibility(Request $request)
    {
        $request->validate([
        'profile_visibility' => 'in:everyone,followers',
        ]);

        $found=UserPrivacySetting::where('user_id',Auth::id())->first();
        if ($found == null) {
                UserPrivacySetting::create([
                'profile_visibility' => $request->profile_visibility,
                'user_id' => Auth::id()
            ]);
            return response()->json(['تم حفظ الإعدادات'], 200);
        }

        else {
                $found->update(['profile_visibility' => $request->profile_visibility]);
                return response()->json(['تم حفظ الإعدادات'], 200);
        }
    }

        public function commentpermission(Request $request)
    {
        $request->validate([
        'comment_permission' => 'in:everyone,followers',
        ]);
        
        $found=UserPrivacySetting::where('user_id',Auth::id())->first();
        if ($found == null) {
                UserPrivacySetting::create([
                'comment_permission' => $request->comment_permission,
                'user_id' => Auth::id()
            ]);
            return response()->json(['تم حفظ الإعدادات'], 200);
        }

        else {
                $found->update(['comment_permission' => $request->comment_permission]);
                return response()->json(['تم حفظ الإعدادات'], 200);
        }
    }

    public function reactionvisibility(Request $request)
    {
        $request->validate([
        'reaction_visibility' => 'in:everyone,followers',
        ]);
        
        $found=UserPrivacySetting::where('user_id',Auth::id())->first();
        if ($found == null) {
                UserPrivacySetting::create([
                'reaction_visibility' => $request->reaction_visibility,
                'user_id' => Auth::id()
            ]);
            return response()->json(['تم حفظ الإعدادات'], 200);
        }

        else {
                $found->update(['reaction_visibility' => $request->reaction_visibility]);
                return response()->json(['تم حفظ الإعدادات'], 200);
        }
    }

    

    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
