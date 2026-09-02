<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnalysisOfRate;
use Illuminate\Http\Request;

class AnalysisOfRateController extends Controller
{
    public function index(Request $request)
    {
        $items = class_exists(AnalysisOfRate::class) && \Illuminate\Support\Facades\Schema::hasTable('analysis_of_rates')
            ? AnalysisOfRate::latest()->paginate(15)
            : collect([]);

        return view('admin.analysis_of_rates.index', compact('items'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'item_code'                   => 'nullable|string|max:50',
            'description'                 => 'required|string',
            'unit'                        => 'nullable|string|max:20',
            'material_cost'               => 'nullable|numeric|min:0',
            'labour_cost'                 => 'nullable|numeric|min:0',
            'carriage_cost'               => 'nullable|numeric|min:0',
            'machinery_cost'              => 'nullable|numeric|min:0',
            'water_charges_percent'       => 'nullable|numeric|min:0',
            'contractor_profit_percent'   => 'nullable|numeric|min:0',
            'gst_percent'                 => 'nullable|numeric|min:0',
            'remarks'                     => 'nullable|string',
        ]);

        $data['user_id'] = auth()->id();
        $base = ($data['material_cost'] ?? 0) + ($data['labour_cost'] ?? 0) + ($data['carriage_cost'] ?? 0) + ($data['machinery_cost'] ?? 0);
        $water = $base * (($data['water_charges_percent'] ?? 1) / 100);
        $withWater = $base + $water;
        $profit = $withWater * (($data['contractor_profit_percent'] ?? 15) / 100);
        $withProfit = $withWater + $profit;
        $gst = $withProfit * (($data['gst_percent'] ?? 18) / 100);
        $data['total_rate'] = $withProfit + $gst;

        AnalysisOfRate::create($data);

        return redirect()->back()->with('success', 'Analysis of Rate item added successfully.');
    }

    public function destroy($id)
    {
        $item = AnalysisOfRate::findOrFail($id);
        $item->delete();
        return redirect()->back()->with('success', 'Record deleted successfully.');
    }
}
