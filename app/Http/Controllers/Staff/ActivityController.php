<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Project;
use Illuminate\Http\Request;

class ActivityController extends Controller
{

    
    public function index()
    {
        $projects = Project::with(['departments', 'state','emds'])->where('user_id', auth()->id())->latest()->paginate(20);
        
        return view('staff.activities.index', compact('projects'));
    }

     public function index2(Project $project)
    {
        $activities = $project->activities;
       $chartData = $activities->map(function ($a) {
            return [
                'name' => \Illuminate\Support\Str::limit($a->activity_name, 30),
                'progress' => (int) $a->progress,
                'weightage' => (int) $a->weightage,
                'remaining' => 100
            ];
        });


        return view('staff.activities.index2', compact('project','activities','chartData'));

        // return view('staff.activities.index2', compact('activities', 'project'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_id'    => 'required|exists:projects,id',
            'activity_name' => 'required|string|max:255',
            'from_date'     => 'required|date',
            'to_date'       => 'required|date|after_or_equal:from_date',
            'weightage'     => 'nullable|integer|min:0|max:100',
            'progress'      => 'nullable|integer|min:0|max:100',
        ]);

        $request['user_id'] = auth()->id();

        Activity::create($request->all());

        return redirect()->back()->with('success', 'Activity added successfully');
    }

    public function edit(Activity $activity)
    {
        return view('staff.activities.edit', compact('activity'));
    }

    public function update(Request $request, Activity $activity)
    {
        $request->validate([

            'activity_name' => 'required|string|max:255',
            'from_date'     => 'required|date',
            'to_date'       => 'required|date|after_or_equal:from_date',
            'weightage'     => 'nullable|integer|min:0|max:100',
            'progress'      => 'nullable|integer|min:0|max:100',
        ]);

        $activity->update($request->all());

        return redirect()->route('staff.activities.index')
            ->with('success', 'Activity updated successfully');
    }
}
