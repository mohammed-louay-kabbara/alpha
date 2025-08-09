<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\product_like;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProductLikeController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
           $request->validate([
            'type' => 'required', 
            'product_id' => 'required',
        ]);

        $existing = product_like::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();
        if ($existing) {
            $existing->delete();
            return response()->json([
            'status' => true,
            'message' => 'تم إلغاء الإعجاب بنجاح',], 200);
        }

        // إنشاء السجل الجديد
        product_like::create([
            'user_id' => Auth::id(),
            'type' => $request->type,
            'product_id' => $request->product_id,
        ]);
        $product=product::where('id',$request->product_id)->first();
            notification::create([
                'user_id' => $product->user_id,
                'title' => 'تفاعل',
                'body' => 'تم تسجيل إعجاب على منشورك',
                'sender_id' => Auth::id()
            ]);

        return response()->json([
            'status' => true,
            'message' => 'تم تسجيل الإعجاب بنجاح',], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(product_like $product_like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(product_like $product_like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, product_like $product_like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(product_like $product_like)
    {
        //
    }
}
