<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Agreement;
use App\Models\Project;
use Illuminate\Http\Request;

class AgreementController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'agreement_no' => 'required',
            'agreement_date' => 'required|date',
            'start_date' => 'required|date',
            'time_allowed_number' => 'required|numeric',
            'time_allowed_type' => 'required',
            'agreement_file' => 'nullable|mimes:pdf,jpg,png|max:4096'
        ]);

        $data = $request->except('_token');

        if ($request->hasFile('agreement_file')) {
            $data['agreement_file'] = $request->agreement_file->store('agreements','public');
        }

        $data['project_id'] = $project->id;
        Agreement::create($data);

        $project->update(['status' => 'agreement']);

        return back()->with('success','Agreement stored.');
    }
}
