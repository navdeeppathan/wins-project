<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ScheduleWork;
use Illuminate\Http\Request;

class ScheduleWorkController extends Controller
{
    public function index()
    {
        $projects = Project::with(['departments', 'state','emds'])->where('user_id', auth()->id())->latest()->paginate(20);
        
        return view('admin.schedule_work.index', compact('projects'));
    }

    public function index2(Project $project)
    {
        $works = $project->scheduleWorks; // relation
        $inventories = $project->inventory;
        return view('admin.schedule_work.index2', compact('project','works','inventories'));
    }

    // public function save(Request $request, Project $project)
    // {
    //     if (!$request->has('work')) return back();

    //     foreach ($request->work as $row) {

    //         $amount = ($row['quantity'] ?? 0)
    //                 * ($row['rate'] ?? 0);

    //         $data = [
    //             'project_id'   => $project->id,
    //             'section_name' => $row['section_name'] ?? 'GENERAL',
    //             'description'  => $row['description'] ?? null,
    //             'quantity'     => $row['quantity'] ?? 0,
    //             'unit'         => $row['unit'] ?? 1,
    //             'rate'         => $row['rate'] ?? 0,
    //             'amount'       => $amount ?? 0,
    //             'measured_quantity' => $row['measured_quantity'] ?? 0,
    //             'category' => $row['category'] ?? 0,

    //         ];

    //         // UPDATE
    //         if (!empty($row['id'])) {
    //             ScheduleWork::where('id',$row['id'])->update($data);
    //         }
    //         // CREATE
    //         else {
    //             ScheduleWork::create($data);
    //         }
    //     }

    //     return back()->with('success','Schedule of Work saved successfully');
    // }


    public function save(Request $request, Project $project)
    {
        if (!$request->has('work')) {
            return response()->json(['status' => false]);
        }

        $row = $request->work[0];

        $amount = ($row['quantity'] ?? 0) * ($row['rate'] ?? 0);

        $data = [
            'project_id'        => $project->id,
            'section_name'      => 'GENERAL',
            'description'       => $row['description'] ?? null,
            'quantity'          => $row['quantity'] ?? 0,
            'unit'              => $row['unit'] ?? 1,
            'rate'              => $row['rate'] ?? 0,
            'amount'            => $amount,
            'measured_quantity' => $row['measured_quantity'] ?? 0,
            'category'          => $row['category'] ?? null,
            'inventory_id'      => $row['inventory_id'] ?? null
        ];

        // UPDATE
        if (!empty($row['id'])) {
            ScheduleWork::where('id', $row['id'])->update($data);
            return response()->json(['status' => true]);
        }

        // CREATE
        $work = ScheduleWork::create($data);

        return response()->json([
            'status' => true,
            'id' => $work->id
        ]);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        ScheduleWork::where('id', $request->id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Row deleted successfully'
        ]);
    }


     public function updateScheduleDismantal(Request $request, ScheduleWork $schedule)
    {
        $request->validate([
            'dismantals'       => 'nullable|numeric', 
        ]);

        $schedule->dismantals = $request->dismantals;
        $schedule->save();

        return response()->json([
            'success' => true,
            'message' => 'Schedule work details updated successfully.'
        ]);
    }

    
}

