<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Models\Department;
use App\Models\EmdDetail;
use App\Models\PgDetail;
use App\Models\Project;
use App\Models\State;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with(['department', 'state','emds'])->latest()->paginate(20);
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $departments = Department::where('user_id', auth()->id())->orderBy('name')->get();
        $states = State::orderBy('name')->get();
        return view('admin.projects.create', compact('departments','states'));
    }

    public function returnedCreate()
    {
         $projects = Project::with(['department', 'state','emds'])->latest()->paginate(20);
        return view('admin.unqualified.index', compact('projects'));
    }

    public function forfietedCreate()
    {
         $projects = Project::with(['department', 'state','emds'])->latest()->paginate(20);
        return view('admin.forfitted.index', compact('projects'));
    }


   public function store(ProjectRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();

        // Store project main file
        if ($request->hasFile('emd_file')) {
            $data['emd_file'] = $request->emd_file->store('emd_docs', 'public');
        }

        // 1️⃣ Create Project
        $project = Project::create($data);

        // 2️⃣ Insert Multiple EMD Details
        if ($request->has('emd')) {

            foreach ($request->emd as $row) {

                $emdData = [
                    'project_id'        => $project->id,
                    'instrument_type'   => $row['instrument_type'] ?? null,
                    'instrument_number' => $row['instrument_number'] ?? null,
                    'instrument_date'   => $row['instrument_date'] ?? null,
                    'amount'            => $row['amount'] ?? null,
                    'remarks'           => $row['remarks'] ?? null,
                ];

                // file upload for each row
                if (isset($row['upload']) && $row['upload'] instanceof \Illuminate\Http\UploadedFile) {
                    $emdData['upload'] = $row['upload']->store('emd_docs', 'public');
                }

                EmdDetail::create($emdData);
            }
        }

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project created.');
    }


   



    public function updateQualified(Request $request, Project $project)
    {
        
        $project->isQualified = $request->isQualified;
        $project->save();

        return response()->json([
            'success' => true,
            'message' => 'Project qualification updated.'
        ]);
    }

     public function updateReturned(Request $request, Project $project)
    {
        
        $project->isReturned = $request->isReturned;
        $project->save();

        return response()->json([
            'success' => true,
            'message' => 'Project return updated.'
        ]);
    }


     public function updateforfittedReturned(Request $request, Project $project)
    {
        
        $project->isForfitted = $request->isForfitted;
        $project->save();

        return response()->json([
            'success' => true,
            'message' => 'Project forfitted updated.'
        ]);
    }

    public function acceptanceIndex()
    {
        $projects = Project::whereIn('status', ['bidding', 'accepted'])
            ->latest()
            ->paginate(10);

        return view('admin.acceptance.index', compact('projects'));
    }

     public function awardIndex()
    {
        $projects = Project::whereIn('status', ['bidding', 'accepted','awarded'])
            ->latest()
            ->paginate(10);

        return view('admin.award.index', compact('projects'));
    }

      public function agreementIndex()
    {
        $projects = Project::whereIn('status', ['bidding', 'accepted','awarded','agreement'])
            ->latest()
            ->paginate(10);

        return view('admin.agreement.index', compact('projects'));
    }



    public function updateDocAndStatus(Request $request, Project $project)
    {
        $request->validate([
            'tendered_amount'       => 'nullable|numeric',
            'acceptance_letter_no'  => 'nullable|string|max:255',
            'acceptance_upload'     => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
        ]);

        $project->status = 'accepted';
        $project->tendered_amount = $request->tendered_amount;
        $project->acceptance_letter_no = $request->acceptance_letter_no;
        $project->date = now()->toDateString();

        if ($request->hasFile('acceptance_upload')) {
            $project->acceptance_upload = $request->acceptance_upload
                ->store('project_docs', 'public');
        }

        $project->save();

        return response()->json([
            'success' => true,
            'message' => 'Acceptance details updated successfully.'
        ]);
    }


     public function updateDocAndStatus2(Request $request, Project $project)
    {
        $request->validate([
            
            'award_letter_no'  => 'nullable|string|max:255',
            'award_upload'     => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
        ]);

        $project->status = 'awarded';
        
        $project->award_letter_no = $request->award_letter_no;
        $project->award_date = now()->toDateString();

        if ($request->hasFile('acceptance_upload')) {
            $project->award_upload = $request->award_upload
                ->store('project_docs', 'public');
        }

        $project->save();

        return response()->json([
            'success' => true,
            'message' => 'Award details updated successfully.'
        ]);
    }

     public function updateDocAndStatus3(Request $request, Project $project)
    {
        $request->validate([
            
            'agreement_no'  => 'nullable|string|max:255',
            'agreement_upload'     => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
        ]);

        $project->status = 'agreement';
        
        $project->agreement_no = $request->agreement_no;
        
        if ($request->hasFile('agreement_upload')) {
            $project->agreement_upload = $request->agreement_upload
                ->store('project_docs', 'public');
        }

        $project->save();

        return response()->json([
            'success' => true,
            'message' => 'Agreement details updated successfully.'
        ]);
    }


    public function agreementDateCreate(Project $project)
    {
        return view('admin.projects.createagreementdate', compact('project'));
    }

   public function updateDocAndStatus4(Request $request, Project $project)
    {
        $request->validate([
            'agreement_start_date' => 'nullable|date',
            'stipulated_date_ofcompletion' => 'nullable|date|after_or_equal:agreement_start_date',
        ]);

        $project->update([
            'agreement_start_date' => $request->agreement_start_date,
            'stipulated_date_ofcompletion' => $request->stipulated_date_ofcompletion,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Agreement details updated successfully.');
    }




    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }


    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(ProjectRequest $request, Project $project)
    {
        $data = $request->validated();

        if ($request->hasFile('emd_file')) {
            $data['emd_file'] = $request->emd_file->store('emd_docs', 'public');
        }

        $project->update($data);
        return redirect()->route('admin.projects.index')->with('success','Project updated.');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success','Deleted.');
    }
}
