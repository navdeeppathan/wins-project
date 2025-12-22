<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\BillingItem;
use App\Models\Billing;
use Illuminate\Http\Request;

class BillingItemController extends Controller
{
    public function store(Request $request, Billing $billing)
    {
        $request->validate([
            'category' => 'required',
            'description' => 'required',
            'quantity' => 'required|numeric',
            'amount' => 'required|numeric'
        ]);

        $data = $request->all();
        $data['net_payable'] = ($request->amount - ($request->deduction ?? 0));
        $data['billing_id'] = $billing->id;

        BillingItem::create($data);

        $billing->update(['gross_amount' => BillingItem::where('billing_id',$billing->id)->sum('net_payable')]);

        return back()->with('success','Item added.');
    }

    public function destroy(BillingItem $billingItem)
    {
        $billing = $billingItem->billing;
        $billingItem->delete();
        $billing->update(['gross_amount' => BillingItem::where('billing_id',$billing->id)->sum('net_payable')]);

        return back()->with('success','Item removed.');
    }
}
