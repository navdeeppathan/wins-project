<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $items = Inventory::latest()->paginate(20);
        return view('admin.inventory.index',compact('items'));
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
