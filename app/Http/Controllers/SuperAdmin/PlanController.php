<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class PlanController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = auth()->user();
            if (!$user || !in_array($user->role, ['super_admin', 'superadmin'])) {
                abort(403, 'Unauthorized access to Plan Management.');
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of all plans
     */
    public function index()
    {
        // If table exists and is empty, seed defaults
        if (Schema::hasTable('plans') && Plan::count() === 0) {
            foreach (Plan::defaultPlans() as $p) {
                Plan::create($p);
            }
        }

        $plans = Plan::orderBy('sort_order')->get();
        return view('superadmin.plans.index', compact('plans'));
    }

    /**
     * Store a newly created plan
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'            => 'required|string|max:100',
            'slug'            => 'nullable|string|max:50|unique:plans,slug',
            'badge'           => 'nullable|string|max:50',
            'duration_months' => 'required|integer|min:1|max:60',
            'original_price'  => 'nullable|numeric|min:0',
            'price'           => 'required|numeric|min:0',
            'gst_percent'     => 'nullable|numeric|min:0|max:100',
            'description'     => 'nullable|string',
            'features'        => 'nullable|string',
            'is_active'       => 'nullable|boolean',
            'sort_order'      => 'nullable|integer',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name'], '_');
        }

        $gst = $data['gst_percent'] ?? 18.00;
        $data['gst_percent'] = $gst;
        $data['total_price'] = $data['price'] + ($data['price'] * ($gst / 100));

        // Parse newline-separated features into array
        if (!empty($data['features'])) {
            $featuresArray = array_filter(array_map('trim', explode("\n", $data['features'])));
            $data['features'] = array_values($featuresArray);
        } else {
            $data['features'] = [];
        }

        $data['is_active'] = $request->has('is_active') ? true : false;
        $data['sort_order'] = $data['sort_order'] ?? (Plan::count() + 1);

        Plan::create($data);

        return redirect()->route('superadmin.plans.index')->with('success', 'Plan created successfully.');
    }

    /**
     * Update the specified plan
     */
    public function update(Request $request, $id)
    {
        $plan = Plan::findOrFail($id);

        $data = $request->validate([
            'name'            => 'required|string|max:100',
            'slug'            => 'required|string|max:50|unique:plans,slug,' . $id,
            'badge'           => 'nullable|string|max:50',
            'duration_months' => 'required|integer|min:1|max:60',
            'original_price'  => 'nullable|numeric|min:0',
            'price'           => 'required|numeric|min:0',
            'gst_percent'     => 'nullable|numeric|min:0|max:100',
            'description'     => 'nullable|string',
            'features'        => 'nullable|string',
            'sort_order'      => 'nullable|integer',
        ]);

        $gst = $data['gst_percent'] ?? 18.00;
        $data['gst_percent'] = $gst;
        $data['total_price'] = $data['price'] + ($data['price'] * ($gst / 100));

        // Parse features
        if (isset($data['features'])) {
            $featuresArray = array_filter(array_map('trim', explode("\n", $data['features'])));
            $data['features'] = array_values($featuresArray);
        }

        $data['is_active'] = $request->has('is_active') ? true : false;

        $plan->update($data);

        return redirect()->route('superadmin.plans.index')->with('success', "Plan '{$plan->name}' updated successfully.");
    }

    /**
     * Toggle active/inactive status
     */
    public function toggleStatus($id)
    {
        $plan = Plan::findOrFail($id);
        $plan->is_active = !$plan->is_active;
        $plan->save();

        $status = $plan->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "Plan '{$plan->name}' has been {$status}.");
    }

    /**
     * Remove the specified plan
     */
    public function destroy($id)
    {
        $plan = Plan::findOrFail($id);
        $plan->delete();

        return redirect()->route('superadmin.plans.index')->with('success', 'Plan deleted successfully.');
    }
}
