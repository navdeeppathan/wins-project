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

        $quantity = $request->filled('qty') 
            ? (float) $request->qty 
            : ($request->sr_no * $request->no_of_items * $request->length * $request->height * $request->width * $request->factor);

        ScheduleWorkItem::create(array_merge($request->all(), ['qty' => $quantity]));

        $this->syncParentScheduleWork($request->schedule_work_id);

        return redirect()->back()->with('success', 'Item added successfully');
    }

    /**
     * Update item
     */
    public function update(Request $request, $id)
    {
        $item = ScheduleWorkItem::findOrFail($id);

        $quantity = $request->filled('qty') 
            ? (float) $request->qty 
            : ($request->sr_no * $request->no_of_items * $request->length * $request->height * $request->width * $request->factor);

        $request->merge(['qty' => $quantity]);
        $item->update($request->all());

        $this->syncParentScheduleWork($item->schedule_work_id);

        return redirect()->back()->with('success', 'Item updated successfully');
    }

    /**
     * Delete item
     */
    public function destroy($id)
    {
        $item = ScheduleWorkItem::findOrFail($id);
        $scheduleWorkId = $item->schedule_work_id;
        $item->delete();

        $this->syncParentScheduleWork($scheduleWorkId);

        return redirect()->back()->with('success', 'Item deleted successfully');
    }

    /**
     * Sync parent ScheduleWork quantity, amount and abatement with sum of items
     */
    private function syncParentScheduleWork($scheduleWorkId)
    {
        $scheduleWork = ScheduleWork::with('project')->find($scheduleWorkId);
        if (!$scheduleWork) {
            return;
        }

        $totalQty = (float) ScheduleWorkItem::where('schedule_work_id', $scheduleWorkId)->sum('qty');
        $rate = (float) $scheduleWork->rate;
        $gst  = (float) $scheduleWork->gst;

        $baseAmount = $totalQty * $rate;
        if ($gst == 1 || $gst == 0) {
            $amount = $baseAmount;
        } else {
            $amount = $baseAmount + (($baseAmount * $gst) / 100);
        }

        $abateAmount = $amount;
        if ($scheduleWork->project) {
            $estimated = (float) $scheduleWork->project->estimated_amount;
            $tendered  = (float) $scheduleWork->project->tendered_amount;
            if ($estimated > 0 && $tendered > 0) {
                $abatementPercentage = (($estimated - $tendered) / $estimated) * -100;
                if ($abatementPercentage < 0) {
                    $abateAmount -= ($abateAmount * abs($abatementPercentage)) / 100;
                } else {
                    $abateAmount += ($abateAmount * $abatementPercentage) / 100;
                }
            }
        }

        $scheduleWork->update([
            'quantity'  => $totalQty,
            'amount'    => $amount,
            'abatement' => $abateAmount,
        ]);
    }
}
