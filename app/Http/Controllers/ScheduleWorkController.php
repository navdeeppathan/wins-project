<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ScheduleWork;
use Illuminate\Http\Request;

class ScheduleWorkController extends Controller
{
    public function index()
    {
        $projects = Project::with(['departments', 'state','emds'])->latest()->paginate(20);
        return view('admin.schedule_work.index', compact('projects'));
    }

     public function index2(Project $project)
    {
        $works = $project->scheduleWorks;
        
        return view('admin.schedule_work.index2', compact('works', 'project'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'project_id'  => 'required|exists:projects,id',
            'description' => 'required|string',
            'quantity'    => 'required|numeric|min:0',
            'unit'        => 'required|string|max:50',
            'rate'        => 'required|numeric|min:0',
        ]);

        $amount = $request->quantity * $request->rate;

        ScheduleWork::create([
            'project_id'  => $request->project_id,
            'description' => $request->description,
            'quantity'    => $request->quantity,
            'unit'        => $request->unit,
            'rate'        => $request->rate,
            'amount'      => $amount,
        ]);

        return redirect()->back()->with('success', 'Schedule Work added successfully');
    }

    public function edit(ScheduleWork $scheduleWork)
    {
        return view('admin.schedule_work.edit', compact('scheduleWork'));
    }

    public function update(Request $request, ScheduleWork $scheduleWork)
    {
        $request->validate([

            'description' => 'required|string',
            'quantity'    => 'required|numeric|min:0',
            'unit'        => 'required|string|max:50',
            'rate'        => 'required|numeric|min:0',
        ]);

        $amount = $request->quantity * $request->rate;

        $scheduleWork->update([
            'description' => $request->description,
            'quantity'    => $request->quantity,
            'unit'        => $request->unit,
            'rate'        => $request->rate,
            'amount'      => $amount,
        ]);

        return redirect()->route('admin.schedule-work.index')
            ->with('success', 'Schedule Work updated successfully');
    }
}
