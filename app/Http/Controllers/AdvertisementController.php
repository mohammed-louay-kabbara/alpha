<?php

namespace App\Http\Controllers;

use App\Models\advertisement;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{

    public function index()
    {
        $advertisement= advertisement::get();
        return view('advertisements',compact('advertisement'));
    }

    public function create()
    {

    }


    public function store(Request $request)
    {
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('advertisement_images', 'public');
        }

        advertisement::create([
            'image' => $imagePath,
            'description' => $request->description,
            'publishing_end' => $request->publishing_end
        ]);
        return back();
    }


    public function show(advertisement $advertisement)
    {
        //
    }


    public function edit(advertisement $advertisement)
    {
        //
    }


    public function update(Request $request, advertisement $advertisement)
    {
        //
    }


    public function destroy($id)
    {
        
    }
}
