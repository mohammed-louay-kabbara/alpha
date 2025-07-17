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

    public function index()
    {

        $mostFollowedUsers = User::withCount('followers')
            ->orderByDesc('followers_count')
            ->take(10)
            ->get();
        $topCategories = category::withCount('product')
                ->orderByDesc('product_count')
                ->take(3)
                ->get();
        $user_count=User::count();
        
        $topAddresses = User::select(
                'address',
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('address')
            ->orderByDesc('count')
            ->get()
            ->map(function ($item) use ($user_count) {
                $item->percentage = round(($item->count / $user_count) * 100, 2); // النسبة المئوية
                return $item;
            });

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

    public function create()
    {
        //
    }

    public function getMonthlyUserStats()
    {
        $users = User::select(
            DB::raw("MONTH(created_at) as month"),
            DB::raw("COUNT(*) as count")
        )
        ->whereYear('created_at', now()->year)
        ->groupBy(DB::raw("MONTH(created_at)"))
        ->orderBy(DB::raw("MONTH(created_at)"))
        ->get();
        return response()->json($users);
    }

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
