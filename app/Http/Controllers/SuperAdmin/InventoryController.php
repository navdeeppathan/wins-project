<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Project;
use App\Models\Vendor;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $items = Inventory::latest()->paginate(20);
        $projects = Project::all();
        $vendors = Vendor::all();
        return view('admin.inventory.index',compact('items','projects','vendors'));
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
