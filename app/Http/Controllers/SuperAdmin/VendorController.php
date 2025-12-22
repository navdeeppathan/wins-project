<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::latest()->paginate(20);
        return view('admin.vendors.index', compact('vendors'));
    }

    public function store(Request $request)
    {
        $request->validate(['name'=>'required','phone'=>'required']);
        Vendor::create($request->all());
        return back()->with('success','Vendor added.');
    }

    public function destroy(Vendor $vendor)
    {
        $vendor->delete();
        return back()->with('success','Vendor removed.');
    }
}
