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
        // $reports = \App\Models\Report::with('reportable')
        //     ->select('report_typeable_type', 'report_typeable_id', \DB::raw('count(*) as reports_count'))
        //     ->groupBy('report_typeable_type', 'report_typeable_id')
        //     ->get();
        //     dd($reports);
    $reports = \App\Models\Report::with('reportable')
        ->select('report_typeable_type', 'report_typeable_id', \DB::raw('count(*) as reports_count'))
        ->groupBy('report_typeable_type', 'report_typeable_id')
        ->get();
        return view('reports',compact('reports'));
    }


    public function create()
    {
        //
    }


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


    public function destroy(report $report)
    {
        //
    }
}
