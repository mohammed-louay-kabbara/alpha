<?php

namespace App\Http\Controllers;

use App\Models\favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $favorites = $user->favorites()->with('favoritable')->get();
        $favorites->each(function ($favorite) {
            if ($favorite->favoritable_type === 'product' && $favorite->favoritable) {
                $favorite->favoritable->load('files');
            }
        });
        return response()->json($favorites, 200);
    //   $user = Auth::user();
    //   $favorites = $user->favorites()->with('favoritable')->get();
    //   return response()->json($favorites, 200);
    }


    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Favorite::create([
        'user_id' => Auth::id(),
        'favoritable_type' => $request->type,
        'favoritable_id' => $request->id ]);
        return response()->json([
            'status' => true,
            'message' => 'تم الإضافة إلى السلة',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(favorite $favorite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(favorite $favorite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, favorite $favorite)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(favorite $favorite)
    {
        
    }
}
