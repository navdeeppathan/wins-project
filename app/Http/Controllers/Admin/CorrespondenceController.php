<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Correspondence;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CorrespondenceController extends Controller
{
    public function index()
    {
        $projects = Project::with(['departments', 'state','emds'])->where('user_id', auth()->id())->latest()->paginate(20);
        
        return view('admin.correspondence.index', compact('projects'));
    }
    // Show form (create + edit together)
    public function index2(Project $project)
    {
        $letters = $project->correspondences()->get();

        return view('admin.correspondence.correspondence', compact('project', 'letters'));
    }

    // Store + Update in ONE method
    public function save(Request $request, Project $project)
    {
        if (!$request->has('correspondence')) {
            return back();
        }

        foreach ($request->correspondence as $row) {

            $data = [
                'project_id'     => $project->id,
                'letter_subject' => $row['letter_subject'] ?? null,
                'letter_date'    => $row['letter_date'] ?? null,
            ];

            // File upload
            if (isset($row['upload']) && $row['upload'] instanceof \Illuminate\Http\UploadedFile) {

                // delete old file if update
                if (!empty($row['id'])) {
                    $old = Correspondence::find($row['id']);
                    if ($old && $old->upload) {
                        Storage::disk('public')->delete($old->upload);
                    }
                }

                $data['upload'] = $row['upload']->store('correspondence_docs', 'public');
            }

            // UPDATE or CREATE
            if (!empty($row['id'])) {
                Correspondence::where('id', $row['id'])->update($data);
            } else {
                Correspondence::create($data);
            }
        }

        return response()->json([
            'success' => true
            
        ]);

    }

    // Delete row
    public function destroy(Correspondence $correspondence)
    {
        if ($correspondence->upload) {
            Storage::disk('public')->delete($correspondence->upload);
        }

        $correspondence->delete();

        return back()->with('success', 'Correspondence removed.');
    }
}
