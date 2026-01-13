<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ActivityController extends Controller
{

    public function index()
    {
        $projects = Project::with(['departments', 'state','emds'])->where('user_id', auth()->id())->latest()->paginate(20);
        
        return view('admin.activities.index', compact('projects'));
    }

    //  public function index2(Project $project)
    // {
    //     $activities = $project->activities;
    //    $chartData = $activities->map(function ($a) {
    //         return [
    //             'name' => \Illuminate\Support\Str::limit($a->activity_name, 30),
    //             'progress' => (int) $a->progress,
    //             'weightage' => (int) $a->weightage,
    //             'remaining' => 100
    //         ];
    //     });


    //     return view('admin.activities.index2', compact('project','activities','chartData'));

     
    // }

   


   public function index2(Project $project)
{
    $today = Carbon::today();

    // Prepared data for UI
    $activities = $project->activities->map(function ($a) use ($today) {

        $progress = (int) $a->progress;
        $endDate  = Carbon::parse($a->to_date); // ✅ FIXED

        if ($progress >= 100) {
            $color  = 'green';
            $status = 'Completed';
        } elseif ($progress < 100 && $endDate->lt($today)) {
            $color  = 'red';
            $status = 'Delay';
        } else {
            $color  = 'yellow';
            $status = 'In Progress';
        }

        return [
            'name'     => $a->activity_name,
            'progress' => $progress,
            'weightage' => (int) $a->weightage,
            'color'    => $color,
            'status'   => $status,
            'from'     => $a->from_date?->format('d M Y'),
            'to'       => $a->to_date?->format('d M Y'),
        ];
    });
    $allactivities = $project->activities;

    return view('admin.activities.index2', compact('project', 'activities','allactivities'));
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
        return view('admin.activities.edit', compact('activity'));
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

        return redirect()->route('admin.activities.index')
            ->with('success', 'Activity updated successfully');
    }
}
