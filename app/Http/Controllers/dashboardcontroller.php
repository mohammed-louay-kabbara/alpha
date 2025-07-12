<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use App\Models\User;
use App\Models\UserSession;
use App\Models\advertisement;
use App\Models\category;
    use Illuminate\Support\Facades\DB;

class dashboardcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $topAddresses = User::select('address', DB::raw('COUNT(*) as user_countad'))
            ->groupBy('address')
            ->orderByDesc('user_countad')
            ->get();
        $mostFollowedUsers = User::withCount('followers')
            ->orderByDesc('followers_count')
            ->take(10)
            ->get();
        $topCategories = category::withCount('product')
                ->orderByDesc('product_count')
                ->take(3)
                ->get();
        $user_count=User::where('role',2)->count();
        $products_count=product::where('is_approved',1)->count();
        $UserSession=floor(UserSession::avg('duration') / 60);
        $advertisements=advertisement::get();
        $products_Notallowed_count=product::where('is_approved',0)->count();
        return view('dashboard',compact('user_count',
        'products_count',
        'UserSession',
        'mostFollowedUsers',
        'products_Notallowed_count',
        'topCategories',
        'topAddresses',
        'advertisements'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
