<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\User;
use App\Models\product_file;
use App\Models\reels;
use App\Models\follower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $user=Auth::user();
        $products = Product::with(['files', 'user', 'likeTypes', 'likes']) 
            ->withCount('likes')
            ->where('is_approved', 1)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($product) use ($user) {
                $product->liked_by_user = $product->likes->contains('user_id', $user->id);
                unset($product->likes); 
                return $product;
            });
        return response()->json($products);
    }

    
    public function getUsersWithProducts()
    {
        $authUser = Auth::user();

        $users = User::has('product')
            ->with(['product.files'])
            ->get()
            ->map(function ($user) use ($authUser) {
            $user->is_following = follower::where('follower_id', $authUser->id)
                ->where('followed_id', $user->id)
                ->exists();
                return $user;
            });
        return response()->json($users);
    }

    public function create(Request $request)
    {
        $products = product::with(['user', 'category'])
                        ->withCount('likes') 
                        ->get();
        return view('product', compact('products'));
    }
    
    public function reports_d(Request $request)
    {
        if ($request->type == 'product') {
            $products = product::with(['user', 'category'])->where('id',$request->id)
                            ->withCount('likes') 
                            ->get();
            return view('product', compact('products'));
        }
        else {
            $reels = Reels::with('user')->where('id',$request->id)->get();
            return view('reels',compact('reels'));
        }

    }

    public function product()
    {
        
    }
    public function filterproduct(Request $request)
    {
        if ($request->filter === '0') {
            $products = Product::where('is_approved', 0)->get();
        } else {
            $products = product::with(['user','category'])->get();
        }
        return view('product', compact('products'));
    }
    
     public function searchProducts(Request $request)
    {
        $query = $request->input('query'); 
        if (!$query || trim($query) === '') {
            return response()->json(['products' => []]);
        }
        $products = Product::where('name', 'like', '%' . $query . '%')->get();
        return response()->json(['products' => $products]);
    }

    public function sold(Request $request)
    {
        $product=product::where('id',$request->product_id)->first();
        if($product->is_sold == 0)
        {
            $product->update(['is_sold'=> 1]);
        }

        else {
            $product->update(['is_sold'=> 0]);
        }
        return response()->json(['تم تعديل المنتج'], 200);
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
        
    }
    public function allAllow()
    {
        product::where('is_approved',0)->update(['is_approved'=> 1]);
        return back();
    }
    public function destroy($id)
    {
        $product=product::with('files')->where('id',$id)->first();
        foreach ($product->files as $file) {
            if (Storage::disk('public')->exists($file->file_path)) {
                Storage::disk('public')->delete($file->file_path);
            }
            $file->delete();
        }
        $product->delete();

        return back();
    }
    public function delete_product(Request $request)
    {
        $product = product::with('files')->where('id', $request->id)->first();
        if ($product) {
            if ($product->files && $product->files->count() > 0) {
                foreach ($product->files as $file) {
                    if (Storage::disk('public')->exists($file->file_path)) {
                        Storage::disk('public')->delete($file->file_path);
                    }
                    $file->delete();
                }
            }
            $product->delete();
        }
      return response()->json(['تم الحذف بنجاح'], 200);
    }
}
