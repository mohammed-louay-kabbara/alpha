<?php

namespace App\Http\Controllers;

use App\Models\advertisement;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{

    public function index()
    {
        
    }

    public function create()
    {
       $advertisement= advertisement::get();
        return view('advertisement',compact('advertisement'));
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


    public function destroy(advertisement $advertisement)
    {
        //
    }
}
