<?php

namespace App\Http\Controllers;

use App\Models\report;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        report::create([
            'user_id' => Auth::id(),
            'report_typeable_type' => $request->report_typeable_type,
            'report_typeable_id' => $request->report_typeable_id
        ]);
        return response()->json(['تمت إرسال بلاغك إلى الادمن'], 200);
    }

    public function show(report $report)
    {
        
    }


    public function edit(report $report)
    {
        
    }


    public function update(Request $request, report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(report $report)
    {
        //
    }
}
