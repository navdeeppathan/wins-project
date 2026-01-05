<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recovery;
use App\Models\Billing;
use App\Models\Project;
use Illuminate\Http\Request;

class RecoveryController extends Controller
{
    public function index(Project $project, Billing $billing)
    {
        $recoveries = $billing->recoveries()->latest()->get();
        $securityDeposits = $billing->securityDeposits()->latest()->get();
        return view('admin.recoveries.index', compact(
            'project',
            'billing',
            'recoveries',
            'securityDeposits'
        ));
    }

    public function store(Request $request, Billing $billing)
    {
        $request->validate([
            'security'       => 'numeric',
            'income_tax'     => 'numeric',
            'labour_cess'    => 'numeric',
            'water_charges'  => 'numeric',
            'license_fee'    => 'numeric',
            'cgst'           => 'numeric',
            'sgst'           => 'numeric',
            'withheld_1'     => 'numeric',
            'withheld_2'     => 'numeric',
            'recovery'       => 'numeric',
            'total'          => 'numeric',
        ]);

        // Create NEW recovery row (important change)
        Recovery::create([
            'billing_id'     => $billing->id,
            'security'       => $request->security,
            'income_tax'     => $request->income_tax,
            'labour_cess'    => $request->labour_cess,
            'water_charges'  => $request->water_charges,
            'license_fee'    => $request->license_fee,
            'cgst'           => $request->cgst,
            'sgst'           => $request->sgst,
            'withheld_1'     => $request->withheld_1,
            'withheld_2'     => $request->withheld_2,
            'recovery'       => $request->recovery,
            'total'          => $request->total,
        ]);

        // Recalculate totals from ALL recoveries
        $totalRecovery = $billing->recoveries()->sum('total');

        $billing->update([
            'total_recovery' => $totalRecovery,
            'net_payable'    => $billing->gross_amount - $totalRecovery,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Recovery saved successfully'
        ]);
    }
}
