<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\State;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VendorController extends Controller
{
    /**
     * Vendor list
     */
    public function index()
    {
        $vendors = Vendor::where('user_id', auth()->id())
            ->latest()
            ->paginate(20);

        $states = State::all();    

        return view('admin.vendors.index', compact('vendors', 'states'));
    }


     public function index2(Vendor $vendor)
    {
        
        $inventories = Inventory::where('paid_to', $vendor->vendor_agency_name)->get();
        $totalNetPayable = $inventories->where('isApproved',0)->sum('net_payable');
        $totalPaidNetPayable = $inventories->where('isApproved',1)->sum('net_payable');
        $balanceAmount = $totalNetPayable - $totalPaidNetPayable;
          

        return view('admin.vendors.vendordetails', compact('vendor', 'inventories', 'totalNetPayable', 'totalPaidNetPayable', 'balanceAmount'));
    }
     public function create()
    {
        $vendors = Vendor::where('user_id', auth()->id())
            ->latest()
            ->paginate(20);

        $states = State::all();    

        return view('admin.vendors.create', compact('vendors', 'states'));
    }

    /**
     * Store vendor entry
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            
            'date'          => 'nullable|date',
            'category'      => 'nullable|string|max:100',
            'description'   => 'nullable|string',
            'delivered_to'  => 'nullable|string|max:255',
            'voucher'       => 'nullable|string|max:100',
            'quantity'      => 'nullable|numeric|min:0',
            'amount'        => 'nullable|numeric|min:0',
            'deduction'     => 'nullable|numeric|min:0',
            'upload'        => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'state'         => 'nullable',
            'vendor_agency_name'    => 'nullable|string|max:255',
            'contact_number'=> 'nullable|string|max:20',
            'email_id'=>'nullable|string|unique:vendors,email_id',
            'contact_person'=>'nullable|string',
            'gst_number'=>'nullable|string',
        ]);

        // attach user
        $data['user_id'] = auth()->id();

        // calculate net payable
        $data['net_payable'] = ($data['amount'] ?? 0) - ($data['deduction'] ?? 0);

        // upload file (public folder)
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $fileName = 'vendor_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('vendor_uploads'), $fileName);
            $data['upload'] = 'vendor_uploads/' . $fileName;
        }

        Vendor::create($data);

        return redirect()->route('admin.vendors.index')->with('success', 'Vendor added successfully.');
    }


    public function edit(Vendor $vendor)
    {
      

        $states = State::all();    

        return view('admin.vendors.edit', compact('vendor', 'states'));
    }
    /**
     * Update vendor entry
     */
    public function update(Request $request, Vendor $vendor)
    {
        $data = $request->validate([
            
            'date'          => 'nullable|date',
            'category'      => 'nullable|string|max:100',
            'description'   => 'nullable|string',
            'delivered_to'  => 'nullable|string|max:255',
            'voucher'       => 'nullable|string|max:100',
            'quantity'      => 'nullable|numeric|min:0',
            'amount'        => 'nullable|numeric|min:0',
            'deduction'     => 'nullable|numeric|min:0',
            'upload'        => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'state'         => 'nullable',
            'vendor_agency_name'    => 'nullable|string|max:255',
            'contact_number'=> 'nullable|string|max:20',
            'email_id'=>'nullable|string',
            'contact_person'=>'nullable|string',
            'gst_number'=>'nullable|string',

        ]);

        // recalc net payable
        $data['net_payable'] = ($data['amount'] ?? 0) - ($data['deduction'] ?? 0);

        // replace upload
        if ($request->hasFile('upload')) {

            // delete old file
            if ($vendor->upload && file_exists(public_path($vendor->upload))) {
                unlink(public_path($vendor->upload));
            }

            $file = $request->file('upload');
            $fileName = 'vendor_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('vendor_uploads'), $fileName);
            $data['upload'] = 'vendor_uploads/' . $fileName;
        }

        $vendor->update($data);

        return redirect()->back()->with('success', 'Vendor entry updated successfully!');
    }

    /**
     * Delete vendor entry
     */
    public function destroy(Vendor $vendor)
    {
        // delete file if exists
        if ($vendor->upload && file_exists(public_path($vendor->upload))) {
            unlink(public_path($vendor->upload));
        }

        $vendor->delete();

        return response()->json([
            'success' => true,
            'message' => 'Vendor entry removed successfully'
        ]);
    }
}
