<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Award;
use App\Models\Project;
use Illuminate\Http\Request;

class AwardController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'award_letter_no' => 'required',
            'award_date' => 'required|date',
            'awarded_amount' => 'required|numeric',
            'award_file' => 'nullable|mimes:pdf,jpg,png|max:4096'
        ]);

        $data = $request->only('award_letter_no','award_date','awarded_amount');

        if ($request->hasFile('award_file')) {
            $data['award_file'] = $request->award_file->store('awards','public');
        }

        $data['project_id'] = $project->id;
        Award::create($data);

        $project->update(['status' => 'awarded']);

        return back()->with('success','Project Awarded.');
    }
}
