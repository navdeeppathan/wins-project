<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillingController extends Controller
{
    public function index(Project $project, Request $request)
    {
         $billings = $project->billings()
                    ->withSum('recoveries','total')

                    ->latest()
                    ->get();

        // dd($billings);
        return view('admin.billing.index', compact('project','billings'));
    }

     public function indexprojects(Request $request)
    {


        // $projects = Project::where('user_id', auth()->id())
        //                         ->where(function ($query) {
        //                             $query->where('status', 'agreement')
        //                                 ->orWhere('status', 'billing');
        //                         })
        //                         ->when($request->filled('year'), function ($query) use ($request) {
        //                             $query->whereYear('created_at', $request->year);
        //                         })
        //                         ->latest()
        //                         ->paginate(10);

         $projects = Project::where('user_id', auth()->id())
                    ->where(function ($query) {
                                    $query->where('status', 'agreement')
                                        ->orWhere('status', 'billing');
                                })
                    ->when($request->filled('fy'), function ($query) use ($request) {

                        $start = Carbon::create($request->fy, 4, 1)->startOfDay();
                        $end   = Carbon::create($request->fy + 1, 3, 31)->endOfDay();

                        $query->whereBetween('date_of_start', [$start, $end]);
                    })
                    ->latest()
                    ->paginate(20);

        //  dd($projects);
        return view('admin.billing.indexprojects', compact('projects'));
    }

    public function store(Request $request, Project $project)
    {
        $request->validate([
            'bill_number' => 'required',
            'bill_date' => 'required|date',
            'bill_type' => 'required|in:running,final,rescind',
            'mb_number' => 'required',
            'page_number' => 'required',
            'gross_amount' => 'required|numeric',
            'net_payable' => 'required|numeric',
            'bill_file' => 'nullable|mimes:pdf,jpg,png|max:4096',
            'completion_date' => 'nullable|date'
        ]);

        $data = $request->only('bill_number','bill_date','bill_type','mb_number','page_number','completion_date');
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

    public function update(Request $request, Billing $billing)
    {
        $data = $request->validate([
            'bill_number' => 'required',
            'bill_type' => 'required',
            'bill_date' => 'required|date',
            'mb_number' => 'required',
            'page_number' => 'required',
            'gross_amount' => 'nullable|numeric',
            'net_payable' => 'nullable|numeric',
            'remarks' => 'nullable|string',
            'bill_file' => 'nullable|mimes:pdf,jpg,jpeg,png',

            'completion_date' => 'nullable|date'
        ]);

        if ($request->hasFile('bill_file')) {
            $data['bill_file'] = $request->file('bill_file')->store('billings');
        }

        $billing->update($data);

        return response()->json(['success' => true]);
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
