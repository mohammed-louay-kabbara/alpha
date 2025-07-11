<?php

namespace App\Http\Controllers;

use App\Models\report;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    public function index()
    {
        // $reports = \App\Models\Report::with('reportable')
        //     ->select('report_typeable_type', 'report_typeable_id', \DB::raw('count(*) as reports_count'))
        //     ->groupBy('report_typeable_type', 'report_typeable_id')
        //     ->get();
        //     dd($reports);
    $reports = Report::query()
        ->select('report_typeable_type', 'report_typeable_id', \DB::raw('count(*) as report_count'))
        ->with('report_typeable')
        ->groupBy('report_typeable_type', 'report_typeable_id')
        ->orderByDesc('report_count')
        ->paginate(10); // التقسيم للعرض في صفحات
    return view('reports', compact('reports'));
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
