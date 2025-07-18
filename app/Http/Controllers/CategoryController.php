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

    public function edit($id)
    {
        
    }

    public function update(Request $request, $id)
    {
        category::where('id',$id)->update(['name' => $request->name]);
        return back();
    }
        public function destroy($id)
        {
            $category = category::findOrFail($id);
            // حذف الصورة من storage/public
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }
            // حذف الصنف من قاعدة البيانات
            $category->delete();
            return back()->with('success', 'تم حذف الصنف بنجاح');
        }

}
