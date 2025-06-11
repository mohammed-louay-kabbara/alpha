<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;

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
        ]);
        category::create([
            'name'=> $request->name, 
        ]);
        return response()->json(['تم إضافة صنف جديد'], 200);
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
