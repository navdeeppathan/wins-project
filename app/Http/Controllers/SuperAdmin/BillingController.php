<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillingController extends Controller
{
    public function index(Project $project)
    {
        $billings = $project->billings()->latest()->get();
        return view('admin.billing.index', compact('project','billings'));
    }

     public function indexprojects()
    {
        $projects = Project::where('status', 'billing')->latest()->paginate(20);
        return view('admin.billing.indexprojects', compact('projects'));
    }
    
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'bill_number' => 'required',
            'bill_date' => 'required|date',
            'bill_type' => 'required|in:running,final',
            'mb_number' => 'required',
            'page_number' => 'required',
            'gross_amount' => 'required|numeric',
            'net_payable' => 'required|numeric',
            'remarks' => 'required|string',
            'bill_file' => 'nullable|mimes:pdf,jpg,png|max:4096'
        ]);

        $data = $request->only('bill_number','bill_date','bill_type','mb_number','page_number');
        $data['project_id'] = $project->id;

        if ($request->hasFile('bill_file')) {
            $data['bill_file'] = $request->bill_file->store('bills','public');
        }


        $data['gross_amount'] = $request->gross_amount;
        $data['net_payable'] = $request->net_payable;
        $data['remarks'] = $request->remarks;
        
        $data['approved_at'] = now();

        Billing::create($data);

        $project->update(['status' => 'billing']);

        return back()->with('success','Bill created, add items.');
    }

    public function approve(Billing $billing)
    {
        $billing->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now()
        ]);

        return back()->with('success','Bill Approved.');
    }

    public function destroy(Billing $billing)
    {
        $billing->delete();
        return back()->with('success','Bill Deleted.');
    }
}
