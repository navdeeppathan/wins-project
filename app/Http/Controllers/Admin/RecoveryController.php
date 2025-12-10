<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recovery;
use App\Models\Billing;
use Illuminate\Http\Request;

class RecoveryController extends Controller
{
    public function store(Request $request, Billing $billing)
    {
        $request->validate([
            'security' => 'numeric',
            'income_tax' => 'numeric',
            'labour_cess' => 'numeric',
            'water_charges' => 'numeric',
            'license_fee' => 'numeric',
            'cgst' => 'numeric',
            'sgst' => 'numeric',
            'withheld_1' => 'numeric',
            'withheld_2' => 'numeric'
        ]);

        $data = $request->all();
        $data['billing_id'] = $billing->id;
        $data['total'] = array_sum($request->except('_token'));

        Recovery::updateOrCreate(['billing_id'=>$billing->id], $data);

        $billing->update([
            'total_recovery' => $data['total'],
            'net_payable' => ($billing->gross_amount - $data['total'])
        ]);

        return back()->with('success','Recoveries applied.');
    }
}
