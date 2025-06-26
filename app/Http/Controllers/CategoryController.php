<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = category::get();
        return response()->json([$categories], 200);
    }


    public function create()
    {
        $categories = category::get();
        return view('category',compact('categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // تحقق من الصورة
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('category_images', 'public');
        }
        category::create([
            'name'  => $request->name,
            'image' => $imagePath,
        ]);
        return back();
    }


    public function show(category $category)
    {
        //
    }


    public function edit(category $category)
    {
        //
    }


    public function update(Request $request, category $category)
    {
        $categor->update(['name'=> $request->name]);
        return back();
    }


    public function destroy($id)
    {
        $category=category::where('id',$id)->first();
        // حذف الصورة من storage
        if ($category->image && Storage::exists($category->image)) {
            Storage::delete($category->image);
        }
        // حذف الصنف من قاعدة البيانات
        $category->delete();
        return back();
    }
}
