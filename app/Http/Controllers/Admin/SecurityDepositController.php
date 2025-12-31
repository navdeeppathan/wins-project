<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\Project;
use App\Models\SecurityDeposit;
use Illuminate\Http\Request;

class SecurityDepositController extends Controller
{
    public function create(Project $project, Billing $billing)
    {
        $securityDeposits = $billing->securityDeposits()->latest()->get();
        return view('admin.security_deposits.create', compact('project', 'billing', 'securityDeposits'));
    }

    public function store(Request $request, Project $project, Billing $billing)
    {
        $request->validate([
            'instrument_type'   => 'required|string|max:50',
            'instrument_number' => 'required|string|max:100',
            'instrument_date'   => 'required|date',
            'amount'            => 'required|numeric|min:0',
            'upload'            => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        $filePath = null;

        if ($request->hasFile('upload')) {
            $filePath = $request->file('upload')
                ->store('security-deposits', 'public');
        }

        SecurityDeposit::create([
            'project_id'        => $project->id,
            'billing_id'           =>$billing->id,
            'instrument_type'   => $request->instrument_type,
            'instrument_number' => $request->instrument_number,
            'instrument_date'   => $request->instrument_date,
            'amount'            => $request->amount,
            'upload'            => $filePath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Security Deposit saved successfully.'
        ]);

    }
}
