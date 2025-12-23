<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Project;
use App\Models\Vendor;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
public function index(Request $request)
{
    $projectId = $request->query('project_id'); // get ?project_id=10

    $items = \App\Models\Inventory::query()
        ->when($projectId, function($q, $projectId) {
            $q->where('project_id', $projectId);
        })
        ->with(['project', 'vendor'])
        ->get(); // or ->paginate(10);

    $projects = \App\Models\Project::where('user_id', auth()->user()->id)->get();
    $vendors = \App\Models\Vendor::where('user_id', auth()->user()->id)->get();

    return view('admin.inventory.index', compact('items', 'projects', 'vendors'));
}


    public function store(Request $request)
    {
        $request->validate([
            'item_name'=>'required',
            'quantity'=>'required|numeric'
        ]);

        Inventory::create($request->all());
        return back()->with('success','Item added.');
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return back()->with('success','Inventory item removed.');
    }
}
