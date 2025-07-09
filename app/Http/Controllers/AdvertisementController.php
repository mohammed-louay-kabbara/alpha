<?php

namespace App\Http\Controllers;

use App\Models\advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'publishing_end' => $request->publishing_end,
            'type' => $request->type
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


    public function update(Request $request, $id)
    {
        advertisement::where('id',$id)->update([
            'description' => $request->description,
            'publishing_end' => $request->publishing_end
        ]);
        return back();
    }


    public function destroy($id)
    {
            $advertisement = advertisement::findOrFail($id);
            if ($advertisement->image && Storage::disk('public')->exists($advertisement->image)) {
                Storage::disk('public')->delete($advertisement->image);
            }
            $advertisement->delete();
            return back()->with('success', 'تم حذف الصنف بنجاح');
        
    }
}
