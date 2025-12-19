<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Models\departments;
use App\Models\EmdDetail;
use App\Models\PgDetail;
use App\Models\Project;
use App\Models\SecurityDeposit;
use App\Models\State;
use App\Models\Withheld;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with(['departments', 'state','emds'])->latest()->paginate(20);
       
        return view('admin.projects.index', compact('projects'));
    }

    public function returnIndex()
    {
        $projects = Project::with(['departments', 'state','emds'])->latest()->paginate(20);
        return view('admin.unqualified.index', compact('projects'));
    }

     public function forfietedIndex()
    {
        $projects = Project::with(['departments', 'state','emds'])->latest()->paginate(20);
        return view('admin.forfitted.index', compact('projects'));
    }


     public function pgreturnIndex()
    {
        $projects = Project::with(['departments', 'state','emds'])->latest()->paginate(20);
        return view('admin.pgreturn.index', compact('projects'));
    }

     public function securityreturnIndex()
    {
        $projects = Project::with(['departments', 'state','emds'])->latest()->paginate(20);
        return view('admin.security_deposits.index', compact('projects'));
    }

     public function withheldreturnIndex()
    {
        $projects = Project::with(['departments', 'state','withhelds'])->latest()->paginate(20);
        return view('admin.withheld.index', compact('projects'));
    }
    

     public function pgforfietedIndex()
    {
        $projects = Project::with(['departments', 'state','emds'])->latest()->paginate(20);
        return view('admin.pgforfitted.index', compact('projects'));
    }

     public function securityforfietedIndex()
    {
        $projects = Project::with(['departments', 'state','emds'])->latest()->paginate(20);
        return view('admin.securitydeposite_forfieted.index', compact('projects'));
    }

    
     public function withheldforfietedIndex()
    {
        $projects = Project::with(['departments', 'state','withhelds'])->latest()->paginate(20);
        return view('admin.withheld_forfieted.index', compact('projects'));
    }


    public function create()
    {
        $departmentss = Departments::where('user_id', auth()->id())->orderBy('name')->get();
        $states = State::orderBy('name')->get();
        return view('admin.projects.create', compact('department','states'));
    }

   

        public function returnedCreate(Project $project)
        {
            $emdDetails = $project->emds;

            return view('admin.unqualified.index2', compact('project', 'emdDetails'));
        }

          public function pgreturnedCreate(Project $project)
        {
            $pgDetails = $project->pgDetails;

            return view('admin.pgreturn.index2', compact('project', 'pgDetails'));
        }

          public function securityreturnedCreate(Project $project)
        {
            $securityDeposits = $project->securityDeposits;

            return view('admin.security_deposits.index2', compact('project', 'securityDeposits'));
        }

           public function withheldreturnedCreate(Project $project)
        {
            $withhelds = $project->withhelds;

            return view('admin.withheld.index2', compact('project', 'withhelds'));
        }



    public function forfietedCreate(Project $project)
    {
        $emdDetails = $project->emds;
        return view('admin.forfitted.index2', compact('project', 'emdDetails'));
    }

    public function pgforfietedCreate(Project $project)
    {
        $pgDetails = $project->pgDetails;

        return view('admin.pgforfitted.index2', compact('project', 'pgDetails'));
    }

    public function securityforfietedCreate(Project $project)
    {
        $securityDeposits = $project->securityDeposits;

        return view('admin.securitydeposite_forfieted.index2', compact('project', 'securityDeposits'));
    }

    public function withheldforfietedCreate(Project $project)
    {
        $withhelds = $project->withhelds;

        return view('admin.withheld_forfieted.index2', compact('project', 'withhelds'));
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

    //  public function updateReturned(Request $request, Project $project)
    // {
        
    //     $project->isReturned = $request->isReturned;
    //     $project->save();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Project return updated.'
    //     ]);
    // }

    public function updateReturned(Request $request, EmdDetail $emdDetail)
    {
        $emdDetail->isReturned = $request->isReturned;
        $emdDetail->save();

        return response()->json([
            'success' => true,
            'message' => 'EMD return updated successfully.'
        ]);
    }

    public function updatePgReturned(Request $request, PgDetail $pgDetail)
    {
        $pgDetail->isReturned = $request->isReturned;
        $pgDetail->save();

        return response()->json([
            'success' => true,
            'message' => 'EMD pgreturn updated successfully.'
        ]);
    }


    public function updateSecurityReturned(Request $request, SecurityDeposit $securityDeposit)
    {
        $securityDeposit->isReturned = $request->isReturned;
        $securityDeposit->save();

        return response()->json([
            'success' => true,
            'message' => 'Security return updated successfully.'
        ]);
    }

    public function updateWithheldReturned(Request $request, Withheld $withheld)
    {
        $withheld->isReturned = $request->isReturned;
        $withheld->save();

        return response()->json([
            'success' => true,
            'message' => 'Withheld return updated successfully.'
        ]);
    }

    //  public function updateforfittedReturned(Request $request, Project $project)
    // {
        
    //     $project->isForfieted = $request->isForfitted;
    //     $project->save();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Project forfitted updated.'
    //     ]);
    // }

    public function updateforfittedReturned(Request $request, EmdDetail $emdDetail)
    {
        $emdDetail->isForfieted = $request->isForfieted;
        $emdDetail->save();

        return response()->json([
            'success' => true,
            'message' => 'EMD forfieted updated successfully.'
        ]);
    }


        public function updateforfittedPgReturned(Request $request, PgDetail $pgDetail)
    {
        $pgDetail->isForfieted = $request->isForfieted;
        $pgDetail->save();

        return response()->json([
            'success' => true,
            'message' => 'EMD pgforfieted updated successfully.'
        ]);
    }


        public function updateforfittedSecurityReturned(Request $request, SecurityDeposit $securityDeposit)
    {
        $securityDeposit->isForfeited = $request->isForfieted;
        $securityDeposit->save();

        return response()->json([
            'success' => true,
            'message' => 'Security forfieted updated successfully.'
        ]);
    }

         public function updateforfittedWithheldReturned(Request $request, Withheld $withheld)
    {
        $withheld->isForfeited = $request->isForfieted;
        $withheld->save();

        return response()->json([
            'success' => true,
            'message' => 'Withheld forfieted updated successfully.'
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
            'date'                  => 'nullable|date',
        ]);

        $project->status = 'accepted';
        $project->tendered_amount = $request->tendered_amount;
        $project->acceptance_letter_no = $request->acceptance_letter_no;
        $project->date = $request->date;

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
            'award_date'       => 'nullable|date',
        ]);

        $project->status = 'awarded';
        
        $project->award_letter_no = $request->award_letter_no;
        $project->award_date = $request->award_date;

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
