<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyNote;
use App\Models\Inventory;
use App\Models\Project;
use App\Models\ScheduleWork;
use App\Models\User;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $projectId = $request->query('project_id');

        $items = Inventory::query()
            ->when($projectId, fn($q) => $q->where('project_id', $projectId))
            ->with(['project'])
            ->where('user_id', auth()->id())
            ->get();

        $projects = Project::where('user_id', auth()->id())->get();
        $project= Project::where('id', $projectId)->first();
        $vendors  = Vendor::where('user_id', auth()->id())->get();
        $notes = DailyNote::orderBy('note_date', 'desc')->get();
        $staffs =User::where('parent_id', auth()->id())->where('role', 'staff')->get();

        return view('admin.inventory.index', compact('items', 'projects', 'vendors', 'notes', 'project', 'staffs'));
    }


     public function materialTabs()
    {


        $items = Inventory::query()
            ->where('user_id', auth()->id())
            ->where('category', 'Material')
            ->with(['project','scheduleOfWorks'])
            ->get();

        $schedules = Inventory::query()
            ->where('user_id', auth()->id())
            ->where('category', 'T&P')
            ->with(['project','scheduleOfWorks'])
            ->get();


        return view('admin.material.index', compact('items', 'schedules'));
    }


    public function tabindex(Request $request)
    {
        $projectId = $request->query('project_id');

        $items = Inventory::query()
            ->when($projectId, fn($q) => $q->where('project_id', $projectId))
            ->with(['project'])
            ->where('user_id', auth()->id())
            ->OrderBy('id', 'desc')
             ->when($request->filled('fy'), function ($query) use ($request) {

                    // Financial year: April 1 to March 31
                    $start = Carbon::create($request->fy, 4, 1)->startOfDay();
                    $end   = Carbon::create($request->fy + 1, 3, 31)->endOfDay();

                    // ✅ Filter by created_at
                    $query->whereBetween('created_at', [$start, $end]);
                })
            ->get();
        
         

        $projects = Project::where('user_id', auth()->id())->get();
        $project= Project::where('id', $projectId)->first();
        $vendors  = Vendor::where('user_id', auth()->id())->get();
        $notes = DailyNote::orderBy('note_date', 'desc')->get();
        $staffs =User::where('parent_id', auth()->id())->where('role', 'staff')->get();

        return view('admin.inventory.tabindex', compact('items', 'projects', 'vendors', 'notes', 'project', 'staffs'));
    }
    // ✅ STORE (Create new row)


    public function store(Request $request)
    {
        $data = $request->validate([
            'project_id'  => 'nullable|exists:projects,id',
            'vendor_id'   => 'nullable|exists:vendors,id',
            'date'        => 'nullable|date',
            'category'    => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'paid_to'     => 'nullable|string|max:255',
            'voucher'     => 'nullable|string|max:100',
            'quantity'    => 'nullable|numeric|min:0',
            'amount'      => 'nullable|numeric|min:0',
            'deduction'   => 'nullable|numeric|min:0',
            'upload'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'schedule_work_id' => 'nullable',
            'staff_id' => 'nullable',

        ]);

        if($data['staff_id'] == null)
        {
            $data['staff_id'] = auth()->id();
        }
        
        // 🧮 Net Payable
        $data['net_payable'] = ($data['quantity'] ?? 0) * ($data['amount'] ?? 0) - ($data['deduction'] ?? 0);
        $data['user_id'] = auth()->id();

        // 📎 Save directly to public folder
        if ($request->hasFile('upload')) {

            $file = $request->file('upload');
            $fileName = 'inv_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('inventory_uploads'), $fileName);

            $data['upload'] = 'inventory_uploads/' . $fileName;
        }

        

        Inventory::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Inventory item added'
        ]);
    }


    // ✅ UPDATE (Inline save)


    public function update(Request $request, Inventory $inventory)
    {
       
        $data = $request->validate([
            'project_id'  => 'nullable|exists:projects,id',
            'vendor_id'   => 'nullable|exists:vendors,id',
            'date'        => 'nullable|date',
            'category'    => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'paid_to'     => 'nullable|string|max:255',
            'voucher'     => 'nullable|string|max:100',
            'quantity'    => 'nullable|numeric|min:0',
            'amount'      => 'nullable|numeric|min:0',
            'deduction'   => 'nullable|numeric|min:0',
            'upload'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'schedule_work_id' => 'nullable',
            'staff_id' => 'nullable',

        ]);

        // 🧮 Net Payable
        $data['net_payable'] = ($data['amount'] ?? 0) - ($data['deduction'] ?? 0);

        // 📎 Replace file
        if ($request->hasFile('upload')) {

            // ❌ delete old file
            if ($inventory->upload && file_exists(public_path($inventory->upload))) {
                unlink(public_path($inventory->upload));
            }

            $file = $request->file('upload');
            $fileName = 'inv_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('inventory_uploads'), $fileName);

            $data['upload'] = 'inventory_uploads/' . $fileName;
        }

        $inventory->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Inventory item updated'
        ]);
    }

    public function isApproved(Request $request, Inventory $inventory)
    {
        $data = $request->validate([
            'isApproved' => 'required'
        ]);

        $inventory->update([
            'isApproved' => $data['isApproved']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Inventory status updated successfully',
            'status'  => $inventory->isApproved
        ]);
    }


    // ❌ DELETE
    public function destroy(Inventory $inventory)
    {
        $inventory->delete();

        return response()->json([
            'success' => true,
            'message' => 'Inventory item removed'
        ]);
    }


     public function updateInventoryDismantal(Request $request, Inventory $inventory)
    {
        $request->validate([
            'dismantals'       => 'nullable|numeric',
            'dismantal_rate'   => 'nullable|numeric',
            'dismantal_amount' => 'nullable|numeric',
        ]);

        $inventory->dismantals = $request->dismantals;
        $inventory->dismantal_rate = $request->dismantal_rate;
        $inventory->dismantal_amount = $request->dismantal_amount;
        $inventory->save();

        return response()->json([
            'success' => true,
            'message' => 'Inventory details updated successfully.'
        ]);
    }
}
