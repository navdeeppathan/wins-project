<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ScheduleWork;
use Illuminate\Http\Request;

class ScheduleWorkController extends Controller
{
    public function index()
    {
        $projects = Project::with(['departments','state','emds'])->where('user_id', auth()->user()->id)
            ->latest()
            ->paginate(20);

        return view('admin.schedule_work.index', compact('projects'));
    }

    public function index2(Project $project)
    {
        $works = ScheduleWork::where('project_id', $project->id)
            ->orderBy('section_name')
            ->get()
            ->groupBy('section_name');

        // SECTION SUBTOTALS
        $subtotals = [];
        foreach ($works as $section => $items) {
            $subtotals[$section] = $items->sum('amount');
        }

        // GRAND TOTAL
        $grandTotal = array_sum($subtotals);

        return view('admin.schedule_work.index2', compact(
            'project',
            'works',
            'subtotals',
            'grandTotal'
        ));
    }

    // ✅ STORE (AJAX SAFE)
    public function store(Request $request)
    {
        $request->validate([
            'project_id'   => 'required|exists:projects,id',
            'section_name' => 'nullable|string|max:100',
            'description'  => 'required|string',
            'quantity'     => 'required|numeric|min:0',
            'unit'         => 'required|numeric|min:0.01',
            'rate'         => 'required|numeric|min:0',
        ]);

        $amount = $request->quantity * $request->rate * $request->unit;

        $work = ScheduleWork::create([
            'project_id'   => $request->project_id,
            'section_name' => $request->section_name ?? 'GENERAL',
            'description'  => $request->description,
            'quantity'     => $request->quantity,
            'unit'         => $request->unit,
            'rate'         => $request->rate,
            'amount'       => $amount,
        ]);

        return response()->json([
            'success' => true,
            'data'    => $work
        ]);
    }

    // ✅ UPDATE (AJAX SAFE)
    public function update(Request $request, ScheduleWork $scheduleWork)
    {
        $request->validate([
            'section_name' => 'nullable|string|max:100',
            'description'  => 'required|string',
            'quantity'     => 'required|numeric|min:0',
            'unit'         => 'required|numeric|min:0.01',
            'rate'         => 'required|numeric|min:0',
        ]);

        $amount = $request->quantity * $request->rate * $request->unit;

        $scheduleWork->update([
            'section_name' => $request->section_name ?? $scheduleWork->section_name,
            'description'  => $request->description,
            'quantity'     => $request->quantity,
            'unit'         => $request->unit,
            'rate'         => $request->rate,
            'amount'       => $amount,
        ]);

        return response()->json([
            'success' => true
        ]);
    }

    public function destroy(ScheduleWork $scheduleWork)
    {
        $scheduleWork->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
