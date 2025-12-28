<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Acceptance;
use Illuminate\Http\Request;

class AcceptanceController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'acceptance_letter_no' => 'required',
            'acceptance_date' => 'required|date',
            'acceptance_file' => 'nullable|mimes:pdf,jpg,png|max:4096'
        ]);

        $data = $request->only('acceptance_letter_no','acceptance_date');

        if ($request->hasFile('acceptance_file')) {
            $data['acceptance_file'] = $request->acceptance_file->store('acceptance', 'public');
        }

        $data['project_id'] = $project->id;
        Acceptance::create($data);

        $project->update(['status' => 'accepted']);

        return back()->with('success', 'Project moved to ACCEPTED stage.');
    }
}
