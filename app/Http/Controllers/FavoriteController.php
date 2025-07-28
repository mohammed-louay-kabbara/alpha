<?php

namespace App\Http\Controllers;

use App\Models\favorite;
use App\Models\product_like;
use App\Models\Reels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{

    public function index()
    {
        $user = Auth::user();   
        $favorites = $user->favorites()->with('favoritable')->get();
        $favorites->each(function ($favorite) use ($user) {
            if ($favorite->favoritable_type === 'product' && $favorite->favoritable) {
                $favorite->favoritable->load('files','user');
            }
            else{
                  $favorite->favoritable->load('user');
            }
        });
        return response()->json($favorites, 200);
    }


    public function create()
    {

    }

    public function deleteall()
    {
        favorite::where('user_id',Auth::id())->delete();
        return response()->json(['تم الحذف بنجاح '], 200);
    }

    public function details($id)
    {
        $fav = favorite::where('id',$id)->first();
        if (!$fav) {
            return response()->json(['error' => 'Favorite not found'], 404);
        }
        $favoritable = $fav->favoritable;
        if ($favoritable instanceof \App\Models\product) {
            $favoritable->load(['files','user']);
            $has_product_like =product_like::where('product_id', $fav->favoritable_id)
            ->where('user_id',Auth::id())->exists();
        } elseif ($favoritable instanceof \App\Models\reels) {
            $favoritable->load('user');
        }
        return response()->json(['favoritable' => $favoritable, 'has_product_like'=> $has_product_like]);
    }

    public function store(Request $request)
    {
        $Favorite=Favorite::where('user_id',Auth::id())
        ->where('favoritable_type',$request->type)->where('favoritable_id' , $request->id)->first();
        if ($Favorite == null) {
        Favorite::create([
        'user_id' => Auth::id(),
        'favoritable_type' => $request->type,
        'favoritable_id' => $request->id ]);
        return response()->json([
            'status' => true,
            'message' => 'تم الإضافة إلى السلة',
        ], 201);
        } 
        else {
            $Favorite->delete();
            return response()->json([
                'status' => true,
                'message' => 'تم حذفه من سلة',
            ], 201);
        }
    }


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


    public function destroy(Request $request)
    {
        if ($request->favorite_id) {
            favorite::where('id',$request->favorite_id)->delete();
            return response()->json(['تم حذف العنصر من السلة من السلة'], 200);
        }
        return response()->json(['العنصر غير موجود'], 404,);       
    }
}
