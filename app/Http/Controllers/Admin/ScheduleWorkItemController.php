<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ScheduleWork;
use App\Models\ScheduleWorkItem;
use Illuminate\Http\Request;

class ScheduleWorkItemController extends Controller
{
    /**
     * Show items list + create form
     */
    public function index(Project $project, ScheduleWork $scheduleWork)
    {
        
    
       $scheduleWorkItems = ScheduleWorkItem::where('schedule_work_id', $scheduleWork->id)->get();
// dd($scheduleWorks);

        return view('admin.schedule_work_items.index', compact('scheduleWork', 'scheduleWorkItems'));
    }

    /**
     * Store new item
     */
    public function store(Request $request)
    {
        $request->validate([
            'schedule_work_id' => 'required|integer',
            'description' => 'required|string',
            'no_of_items' => 'nullable|numeric',
            'length' => 'nullable|numeric',
            'height' => 'nullable|numeric',
        ]);

        $quantity = $request->no_of_items * $request->length * $request->height * $request->width * $request->factor;

        ScheduleWorkItem::create(array_merge($request->all(), ['qty' => $quantity]));

        return redirect()->back()->with('success', 'Item added successfully');
    }

    /**
     * Update item
     */
    public function update(Request $request, $id)
    {
        $item = ScheduleWorkItem::findOrFail($id);

        $quantity = $request->no_of_items * $request->length * $request->height * $request->width * $request->factor;

        $request->merge(['qty' => $quantity]);
        $item->update($request->all());

        return redirect()->back()->with('success', 'Item updated successfully');
    }

    /**
     * Delete item
     */
    public function destroy($id)
    {
        ScheduleWorkItem::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Item deleted successfully');
    }
}
