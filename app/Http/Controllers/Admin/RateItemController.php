<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RateItem;
use Illuminate\Http\Request;

class RateItemController extends Controller
{
    public function index(Request $request)
    {
        $query = RateItem::query();

        if ($request->filled('rate_types')) {
            $query->where('rate_types', $request->rate_types);
        }

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        if ($request->filled('category_name')) {
            $query->where('category_name', $request->category_name);
        }

        if ($request->filled('code_no')) {
            $query->where('code_no', $request->code_no);
        }

        $rateItems = $query->latest()->get();

        return view('admin.rate-items.index', compact('rateItems'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'rate_types' => 'required',
            'department' => 'required',
            'category_name' => 'required',
            'code_no' => 'required',
            'description' => 'required',
            'unit' => 'required',
            'basic_rate' => 'required'
        ]);

        RateItem::create($request->all());

        return back()->with('success', 'Rate item created successfully.');
    }

    public function update(Request $request, RateItem $rateItem)
    {
        $rateItem->update([
            'basic_rate' => $request->basic_rate
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Basic rate updated successfully.'
        ]);
    }
}