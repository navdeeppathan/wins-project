<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Recovery;
use App\Models\Billing;
use App\Models\Project;
use App\Models\SecurityDeposit;
use Illuminate\Http\Request;

class RecoveryController extends Controller
{
   public function index(Project $project, Billing $billing)
    {
        $recoveries = Recovery::where('billing_id', $billing->id)->latest()->paginate(20);
        $securityDeposits = SecurityDeposit::where('billing_id', $billing->id)->latest()->paginate(20);

        return view('superadmin.recoveries.index', compact(
            'project',
            'billing',
            'recoveries',
            'securityDeposits'
        ));
    }


   
}
