<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

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


    public function store(Request $request)
    {  

        $request->validate([
            'name' => 'required', 
            'price' => 'required',
            'category_id' => 'required',
            'price' => 'required',
        ]);

        $product=product::create([
            'user_id' => Auth::id(),
            'name'=> $request->name, 
            'price' => $request->price,
            'category_id' => $request->category_id,
            'description' => $request->description
        ]);
        
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('product_files', 'public');
                $type = strpos($file->getMimeType(), 'video') !== false ? 'video' : 'image';

                ProductFile::create([
                    'product_id' => $product->id,
                    'file_path' => $path,
                    'file_type' => $type,
                ]);
            }
        }
        
     return response()->json(['product_id' => $product->id], 200);

    }


    public function show(product $product)
    {
        //
    }


    public function edit(product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(product $product)
    {
        //
    }
}
