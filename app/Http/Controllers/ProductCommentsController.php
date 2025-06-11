<?php

namespace App\Http\Controllers;

use App\Models\product_comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductCommentsController extends Controller
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
            'message' => 'required', 
            'product_id' => 'required',
        ]);

        product_comments::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
            'product_id' => $request->product_id,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'تم التقييم بنجاح.',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product_comments= product_comments::with('user')->where('product_id',$id)->get();
        return response()->json($product_comments, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(product_comments $product_comments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, product_comments $product_comments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(product_comments $product_comments)
    {
        //
    }
}
