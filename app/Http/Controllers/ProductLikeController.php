<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\notification;
use App\Models\product_like;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProductLikeController extends Controller
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

    public function show(product_like $product_like)
    {
        //
    }


    public function edit(product_like $product_like)
    {
        //
    }

    public function update(Request $request, product_like $product_like)
    {
        //
    }


    public function destroy(product_like $product_like)
    {
        //
    }
}
