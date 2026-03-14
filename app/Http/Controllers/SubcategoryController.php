<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    // Store subcategory
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required'
        ]);

        Subcategory::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => 1
        ]);

        return redirect()->back()->with('success', 'Subcategory created successfully');
    }

    // Update subcategory
    public function update(Request $request, $id)
    {
        $subcategory = Subcategory::findOrFail($id);

        $subcategory->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return redirect()->back()->with('success', 'Subcategory updated successfully');
    }

    // Delete subcategory
    public function destroy($id)
    {
        Subcategory::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Subcategory deleted successfully');
    }

    public function status($id)
    {
        $subcategory = Subcategory::findOrFail($id);

        $subcategory->status = !$subcategory->status;

        $subcategory->save();

        return back();
    }
}