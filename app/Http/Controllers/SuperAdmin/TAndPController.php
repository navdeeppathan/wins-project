<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\TAndP;
use Illuminate\Http\Request;

class TAndPController extends Controller
{
    public function index()
    {
        $records = TAndP::latest()->paginate(20);
        return view('admin.tandp.index',compact('records'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'project_id'=>'required',
            'expense_date'=>'required|date',
            'amount'=>'required|numeric'
        ]);

        $data = $request->all();
        $data['net_payable'] = ($request->amount - ($request->deduction ?? 0));

        if ($request->hasFile('file')) {
            $data['file'] = $request->file->store('t_and_p', 'public');
        }

        TAndP::create($data);

        return back()->with('success','T&P expense added.');
    }
}
