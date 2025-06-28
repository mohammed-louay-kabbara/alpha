<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\product_file;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
    $product = product::with('files','user')->withCount([
        'likes' => function ($query) {}
    ])
    ->where('is_approved', 1)
    ->orderBy('created_at', 'desc')
    ->get();
    return response()->json($product);
    }

    public function create()
    {
        $products=product::with(['user','category'])->get();
        return view('product',compact('products'));
    }
    
     public function searchProducts(Request $request)
    {
        $query = $request->input('query'); // ← هنا نستخدم input() للـ POST
        if (!$query || trim($query) === '') {
            return response()->json(['products' => []]);
        }
        $products = Product::where('name', 'like', '%' . $query . '%')->get();
        return response()->json(['products' => $products]);
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
                product_file::create([
                    'product_id' => $product->id,
                    'file_path' => $path,
                    'file_type' => $type,
                ]);
            }
        }
     return response()->json(['يرجى الانتظار لبعض الوقت من أجل معاينة الإعلان من قبل مسؤول التطبيق'], 200);
    }


    public function show($id)
    {
        $products = product::with('files')->where('user_id',$id)->get();   
        return response()->json($products, 200);
    }


    public function edit($id)
    {
        product::where('id',$id)->update(['is_approved'=> 1]);
        return back();
    }


    public function update(Request $request, product $product)
    {
        //
    }


    public function destroy($id)
    {
        $product=product::with('files')->where('id',$id)->first();
        // حذف كل الصور والفيديوهات المرتبطة بالمنتج
        foreach ($product->files as $file) {
            // حذف الملف من storage
            if (Storage::disk('public')->exists($file->file_path)) {
                Storage::disk('public')->delete($file->file_path);
            }

            // حذف السطر من جدول product_files
            $file->delete();
        }

        // حذف المنتج نفسه
        $product->delete();

        return response()->json(['message' => 'تم حذف المنتج مع صوره بنجاح'], 200);
    }
}
