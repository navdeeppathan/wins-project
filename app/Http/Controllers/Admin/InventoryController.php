<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Project;
use App\Models\Vendor;
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
            ->get();

        $projects = Project::where('user_id', auth()->id())->get();
        $vendors  = Vendor::where('user_id', auth()->id())->get();

        return view('admin.inventory.index', compact('items', 'projects', 'vendors'));
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
            'quantity'    => 'required|numeric|min:0',
            'amount'      => 'required|numeric|min:0',
            'deduction'   => 'nullable|numeric|min:0',
            'upload'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // 🧮 Net Payable
        $data['net_payable'] = ($data['amount'] ?? 0) - ($data['deduction'] ?? 0);

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
            'quantity'    => 'required|numeric|min:0',
            'amount'      => 'required|numeric|min:0',
            'deduction'   => 'nullable|numeric|min:0',
            'upload'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
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


    // ❌ DELETE
    public function destroy(Inventory $inventory)
    {
        $inventory->delete();

        return response()->json([
            'success' => true,
            'message' => 'Inventory item removed'
        ]);
    }
}
