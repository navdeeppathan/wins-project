<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleMakerController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        if ($user->role === 'admin') {
            $userIds = \App\Models\User::where('parent_id', $user->id)
                        ->pluck('id')
                        ->toArray();
            $userIds[] = $user->id;
        } else {
            $userIds = [$user->id];
        }

        $projects = Project::with(['departments', 'state', 'emds'])
            ->whereIn('user_id', $userIds)
            ->when($request->filled('fy'), function ($query) use ($request) {
                $start = Carbon::create($request->fy, 4, 1)->startOfDay();
                $end   = Carbon::create($request->fy + 1, 3, 31)->endOfDay();
                $query->whereBetween('date_of_start', [$start, $end]);
            })
            ->latest()
            ->get();

        return view('admin.schedule_maker.index', compact('projects'));
    }
}
