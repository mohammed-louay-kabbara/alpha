<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = category::get();
        return response()->json([$categories], 200);
    }


    public function create()
    {
        
    }


    public function store(Request $request)
    {
    $request->validate([
        'name' => 'required',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // تحقق من الصورة
    ]);

    // حفظ الصورة إن وجدت
    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('category_images', 'public');
    }

    category::create([
        'name'  => $request->name,
        'image' => $imagePath,
    ]);

    return response()->json(['message' => 'تم إضافة صنف جديد'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(category $category)
    {
        //
    }
}
