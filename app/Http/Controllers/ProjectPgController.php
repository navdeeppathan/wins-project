<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\PgDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectPgController extends Controller
{
    public function create(Project $project)
    {
        $pgs = $project->pgDetails;
        return view('admin.projects.createpg', compact('project', 'pgs'));
    }

    public function save(Request $request, Project $project)
    {
        $request->validate([
            'pg.*.id'                    => 'nullable|exists:pg_details,id',
            'pg.*.instrument_type'       => 'nullable|string|max:50',
            'pg.*.instrument_number'     => 'nullable|string|max:100',
            'pg.*.instrument_date'       => 'nullable|date',
            'pg.*.instrument_valid_upto' => 'nullable|date',
            'pg.*.amount'                => 'required|numeric|min:0',
            'pg.*.upload'                => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ]);

        $existingIds  = $project->pgDetails()->pluck('id')->toArray();
        $submittedIds = [];

        foreach ($request->pg as $row) {

            // UPDATE or CREATE
            if (!empty($row['id'])) {
                $pg = $project->pgDetails()->where('id', $row['id'])->firstOrFail();
                $submittedIds[] = $pg->id;
            } else {
                $pg = new PgDetail();
                $pg->project_id = $project->id;
            }

            $pg->instrument_type       = $row['instrument_type'] ?? null;
            $pg->instrument_number     = $row['instrument_number'] ?? null;
            $pg->instrument_date       = $row['instrument_date'] ?? null;
            $pg->instrument_valid_upto = $row['instrument_valid_upto'] ?? null;
            $pg->amount                = $row['amount'];

            // FILE REPLACE
            if (!empty($row['upload'])) {
                if ($pg->upload && Storage::disk('public')->exists($pg->upload)) {
                    Storage::disk('public')->delete($pg->upload);
                }
                $pg->upload = $row['upload']->store('pg_docs', 'public');
            }

            $pg->save();
        }

        // DELETE REMOVED ROWS
        $toDelete = array_diff($existingIds, $submittedIds);

        foreach ($toDelete as $id) {
            $pg = PgDetail::find($id);
            if ($pg) {
                if ($pg->upload && Storage::disk('public')->exists($pg->upload)) {
                    Storage::disk('public')->delete($pg->upload);
                }
                $pg->delete();
            }
        }

        return back()->with('success', 'PG Details saved successfully');
    }
}

