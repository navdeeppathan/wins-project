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


    public function tabRecoveries()
    {
        $userId = auth()->id();

        $projects = \DB::table('projects as p')
            ->join('billings as b', 'b.project_id', '=', 'p.id')
            ->join('recoveries as r', 'r.billing_id', '=', 'b.id')
            ->leftJoin('departments as d', 'd.id', '=', 'p.department')
            ->leftJoin('states as s', 's.id', '=', 'p.location')
            ->where('p.user_id', auth()->id())
            ->groupBy(
                'p.id',
                'p.name',
                'p.agreement_no',
                's.name',
                'd.name',
                'p.estimated_amount',
                'p.emd_amount'
            )
            ->selectRaw('
                p.id AS project_id,
                p.name AS project_name,
                p.agreement_no,
                s.name AS state_name,
                d.name AS department_name,
                p.estimated_amount,
                p.emd_amount,

                SUM(r.security)      AS security,
                SUM(r.income_tax)    AS income_tax,
                SUM(r.labour_cess)   AS labour_cess,
                SUM(r.water_charges) AS water_charges,
                SUM(r.license_fee)   AS license_fee,
                SUM(r.cgst)          AS cgst,
                SUM(r.sgst)          AS sgst,
                SUM(r.recovery)      AS recovery,
                SUM(r.total)         AS total
            ')
            ->get();

        // $projects = Project::with([
        //             'billings.recoveries',
        //             'departments',
        //             'state'
        //         ])
        //         ->whereHas('billings.recoveries')
        //         ->where('user_id', auth()->id())
        //         ->get();

        return view('admin.recoveries.tabRecoveries', compact('projects'));
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
