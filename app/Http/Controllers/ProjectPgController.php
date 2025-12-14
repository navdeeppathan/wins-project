<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\PgDetail;
use Illuminate\Http\Request;

class ProjectPgController extends Controller
{
    // Show PG form (project already exists)
    public function create(Project $project)
    {
        return view('admin.projects.createpg', compact('project'));
    }

    // Store multiple PG rows
    public function store(Request $request, Project $project)
    {
        if ($request->has('pg')) {

            foreach ($request->pg as $row) {

                $pgData = [
                    'project_id'        => $project->id,
                    'instrument_type'   => $row['instrument_type'] ?? null,
                    'instrument_number' => $row['instrument_number'] ?? null,
                    'instrument_date'   => $row['instrument_date'] ?? null,
                    'amount'            => $row['amount'] ?? null,
                ];

                if (isset($row['upload']) && $row['upload'] instanceof \Illuminate\Http\UploadedFile) {
                    $pgData['upload'] = $row['upload']->store('pg_docs', 'public');
                }

                PgDetail::create($pgData);
            }
        }

        return redirect()
            ->route('admin.projects.acceptance')
            ->with('success', 'PG Details added successfully');
    }
}
