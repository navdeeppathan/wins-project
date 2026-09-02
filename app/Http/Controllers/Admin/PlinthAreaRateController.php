<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlinthAreaRate;
use Illuminate\Http\Request;

class PlinthAreaRateController extends Controller
{
    public function index(Request $request)
    {
        $rates = class_exists(PlinthAreaRate::class) && \Illuminate\Support\Facades\Schema::hasTable('plinth_area_rates')
            ? PlinthAreaRate::latest()->paginate(15)
            : collect([]);

        return view('admin.plinth_area_rates.index', compact('rates'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category'       => 'nullable|string|max:100',
            'building_type'  => 'required|string|max:255',
            'no_of_storeys'  => 'nullable|string|max:50',
            'plinth_area'    => 'nullable|numeric|min:0',
            'unit'           => 'nullable|string|max:20',
            'basic_rate'     => 'required|numeric|min:0',
            'cost_index'     => 'nullable|numeric|min:0',
            'remarks'        => 'nullable|string',
        ]);

        $data['user_id'] = auth()->id();
        $costIndex = $data['cost_index'] ?? 100;
        $data['effective_rate'] = ($data['basic_rate'] * $costIndex) / 100;

        PlinthAreaRate::create($data);

        return redirect()->back()->with('success', 'Plinth Area Rate record added successfully.');
    }

    public function destroy($id)
    {
        $rate = PlinthAreaRate::findOrFail($id);
        $rate->delete();
        return redirect()->back()->with('success', 'Record deleted successfully.');
    }
}
