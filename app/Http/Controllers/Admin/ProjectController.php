<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Models\Department;
use App\Models\EmdDetail;
use App\Models\PgDetail;
use App\Models\Project;
use App\Models\ScheduleWork;
use App\Models\SecurityDeposit;
use App\Models\State;
use App\Models\User;
use App\Models\Withheld;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Inventory;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ProjectController extends Controller
{
    // public function index(Request $request)
    // {
    //     $projects = Project::with(['departments', 'state', 'emds'])
    //         ->where('user_id', auth()->id())
    //         ->when($request->filled('year'), function ($query) use ($request) {
    //             $query->whereYear('created_at', $request->year);
    //         })
    //         ->latest()
    //         ->paginate(20);


    //     return view('admin.projects.index', compact('projects'));
    // }


    // public function dashboard()
    // {


    //     $totalProjects = Project::where('user_id', auth()->id())->count();
    //     $totalBidding = Project::where('user_id', auth()->id())->where('status', 'bidding')->count();
    //     $totalAwarded = Project::where('user_id', auth()->id())->where('status', 'awarded')->count();
    //     $totalCompleted = Project::where('user_id', auth()->id())->where('status', 'completed')->count();

    //     $totalEmd = Project::where('user_id', auth()->id())->sum('emd_amount');

    //     $totalVendors = Vendor::where('user_id', auth()->id())->count();
    //     $totalStaff = User::where('parent_id', auth()->id())->count();

    //     $totalTopStock = Inventory::where('user_id', auth()->id())->orderBy('amount', 'desc')->take(5)->get();

    //     $totalTopVendors = Vendor::where('user_id', auth()->id())->orderBy('amount', 'desc')->take(5)->get();

    //     $totalTopStaff = User::where('parent_id', auth()->id())->orderBy('id', 'desc')->take(5)->get();

    //     $totalTopProjects = Project::where('user_id', auth()->id())->orderBy('id', 'desc')->take(5)->get();

    //     $totalTopVendors = Vendor::where('user_id', auth()->id())->orderBy('id', 'desc')->take(5)->get();

    //     return view('admin.dashboard', compact(
    //         'totalProjects',
    //         'totalBidding',
    //         'totalAwarded',
    //         'totalCompleted',
    //         'totalEmd',
    //         'totalVendors',
    //         'totalStaff',
    //         'totalTopStock',
    //         'totalTopVendors',
    //         'totalTopStaff',
    //         'totalTopProjects'
    //     ));
    // }

 

    public function dashboard()
    {
        $userId = auth()->id();
        $today = Carbon::today();
        $nextMonth = Carbon::today()->addMonth();

            $totalInventory = Inventory::where('user_id', auth()->id())->orderBy('amount', 'desc')->take(5)->get();


        /* =======================
            PROJECT COUNTS
        ======================= */

        $totalProjects = Project::where('user_id', $userId)->count();

        $totalBidding = Project::where('user_id', $userId)
            ->where('status', 'bidding')
            ->count();

        $totalAwarded = Project::where('user_id', $userId)
            ->where('status', 'awarded')
            ->count();

        $totalCompleted = Project::where('user_id', $userId)
            ->where('status', 'completed')
            ->count();

        /* =======================
            TOTAL WORK DONE (₹)
        ======================= */

        $totalWorkDone = Project::where('user_id', $userId)
            ->where('status', 'completed')
            ->sum('estimated_amount');

        /* =======================
            SECURITY / DUES
            (Within next 1 month)
        ======================= */

        $totalEmdDue = Project::where('user_id', $userId)
            ->whereHas('emds', function ($q) use ($today, $nextMonth) {
                $q->whereBetween('releaseDueDate', [$today, $nextMonth]);
            })
            ->with(['emds' => function ($q) use ($today, $nextMonth) {
                $q->whereBetween('releaseDueDate', [$today, $nextMonth]);
            }])
            ->get()
            ->flatMap->emds
            ->sum('emd_amount');


        $totalPgDue = Project::where('user_id', $userId)
            ->whereHas('pgDetails', function ($q) use ($today, $nextMonth) {
                $q->whereBetween('releaseDueDate', [$today, $nextMonth]);
            })
            ->with(['pgDetails' => function ($q) use ($today, $nextMonth) {
                $q->whereBetween('releaseDueDate', [$today, $nextMonth]);
            }])
            ->get()
            ->flatMap->pgDetails
            ->sum('pg_amount');


        $totalSecurityDue = Project::where('user_id', $userId)
            ->whereHas('securityDeposits', function ($q) use ($today, $nextMonth) {
                $q->whereBetween('releaseDueDate', [$today, $nextMonth]);
            })
            ->with(['securityDeposits' => function ($q) use ($today, $nextMonth) {
                $q->whereBetween('releaseDueDate', [$today, $nextMonth]);
            }])
            ->get()
            ->flatMap->securityDeposits
            ->sum('security_amount');


        /* =======================
            PROJECT DATE ALERTS
        ======================= */

        // Projects completing in next 1 month
        $projectsCompletingSoon = Project::where('user_id', $userId)
            ->where('status', 'awarded')
            ->whereBetween('stipulated_date_ofcompletion', [$today, $nextMonth])
            ->count();

        // Projects running beyond completion date
        $projectsDelayed = Project::where('user_id', $userId)
            ->where('status', 'awarded')
            ->whereDate('stipulated_date_ofcompletion', '<', $today)
            ->count();

        /* =======================
            VENDORS & STAFF
        ======================= */

        $totalVendors = Vendor::where('user_id', $userId)->count();

        $totalStaff = User::where('parent_id', $userId)->count();

        /* =======================
            INVENTORY
        ======================= */

        // Total stock value
        $totalStockValue = Inventory::where('user_id', $userId)
            ->sum('amount');

        // Top 5 high value items
        $topInventoryItems = Inventory::where('user_id', $userId)
            ->orderBy('amount', 'desc')
            ->take(5)
            ->get();

        /* =======================
            DASHBOARD LISTING DATA
        ======================= */

        $latestProjects = Project::where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        $topVendors = Vendor::where('user_id', $userId)
            ->orderBy('amount', 'desc')
            ->take(5)
            ->get();

        /* =======================
            RETURN VIEW
        ======================= */

        return view('admin.dashboard', compact(
            'totalProjects',
            'totalBidding',
            'totalAwarded',
            'totalCompleted',
            'totalWorkDone',

            'totalEmdDue',
            'totalPgDue',
            'totalSecurityDue',

            'projectsCompletingSoon',
            'projectsDelayed',

            'totalVendors',
            'totalStaff',

            'totalStockValue',
            'topInventoryItems',

            'latestProjects',
            'topVendors',

            'totalInventory'
        ));
    }

    public function index(Request $request)
    {
        $projects = Project::with(['departments', 'state', 'emds'])
            ->where('user_id', auth()->id())
            ->when($request->filled('fy'), function ($query) use ($request) {

                $start = Carbon::create($request->fy, 4, 1)->startOfDay();
                $end   = Carbon::create($request->fy + 1, 3, 31)->endOfDay();

                $query->whereBetween('date_of_start', [$start, $end]);
            })
            ->latest()
            ->paginate(20);

        return view('admin.projects.index', compact('projects'));
    }


    public function indexUser(User $user)
    {
        $projects = Project::with(['departments', 'state','emds'])->where('user_id', $user->id)->latest()->paginate(20);

        return view('admin.users.projects', compact('projects', 'user'));
    }


    public function commonIndex()
    {
        $projects = Project::with(['departments', 'state','emds'])->where('user_id', auth()->id())->latest()->paginate(20);
        return view('admin.common.index', compact('projects'));
    }

    public function returnIndex()
    {
        $userId = auth()->id();
        $baseQuery = Project::with(['departments', 'state', 'emds'])
            ->where('user_id', $userId);

        // All projects
        $projects = (clone $baseQuery)
            ->latest()
            ->paginate(20);

        // Forfeited EMD projects
        $forfieteds = (clone $baseQuery)
            ->whereHas('emds', function ($q) {
                $q->where('isForfieted', 1);
            })
            ->latest()
            ->get();

        // Returned EMD projects
        $returneds = (clone $baseQuery)
            ->whereHas('emds', function ($q) {
                $q->where('isReturned', 1);
            })
            ->latest()
            ->get();

        // Active EMD projects (not returned & not forfeited)
        $actives = (clone $baseQuery)
            ->whereHas('emds', function ($q) {
                $q->where('isReturned', 0)
                ->where('isForfieted', 0);
            })
            ->latest()
            ->get();

        // All EMD-related project details
        $emdDetails = (clone $baseQuery)
            ->latest()
            ->get();

        return view('admin.unqualified.index', compact(
            'projects',
            'emdDetails',
            'forfieteds',
            'returneds',
            'actives'
        ));
    }

     public function forfietedIndex()
    {
        $projects = Project::with(['departments', 'state','emds'])->where('user_id', auth()->id())->latest()->paginate(20);
        return view('admin.forfitted.index', compact('projects'));
    }


     public function pgreturnIndex()
    {
        // $projects = Project::with(['departments', 'state','emds'])->where('user_id', auth()->id())->latest()->paginate(20);

        $userId = auth()->id();

        // Base query to avoid repetition
        $baseQuery = Project::with(['departments', 'state', 'pgDetails'])
            ->where('user_id', $userId);



        // All projects (paginated)
        $projects = (clone $baseQuery)
            ->latest()
            ->paginate(20);

        // Forfeited EMD projects
        $forfieteds = (clone $baseQuery)
            ->whereHas('pgDetails', function ($q) {
                $q->where('isForfieted', 1);
            })
            ->latest()
            ->get();



        // Returned EMD projects
        $returneds = (clone $baseQuery)
            ->whereHas('pgDetails', function ($q) {
                $q->where('isReturned', 1);
            })
            ->latest()
            ->get();



        // Active EMD projects (not returned & not forfeited)
        $actives = (clone $baseQuery)
            ->whereHas('pgDetails', function ($q) {
                $q->where('isReturned', 0)
                ->where('isForfieted', 0);
            })
            ->latest()
            ->get();

            // dd($actives);

        // All EMD-related project details
        $pgDetails = (clone $baseQuery)
            ->latest()
            ->get();

            // dd($pgDetails);


        return view('admin.pgreturn.index', compact(
            'projects',
            'pgDetails',
            'forfieteds',
            'returneds',
            'actives'
        ));
        // return view('admin.pgreturn.index', compact('projects'));
    }

     public function securityreturnIndex()
    {
        $userId = auth()->id();

        $baseQuery = Project::with(['departments', 'state', 'securityDeposits'])
            ->where('user_id', $userId);



        // All projects (paginated)
        $projects = (clone $baseQuery)
            ->latest()
            ->paginate(20);

        // Forfeited EMD projects
        $forfieteds = (clone $baseQuery)
            ->whereHas('securityDeposits', function ($q) {
                $q->where('isForfieted', 1);
            })
            ->latest()
            ->get();



        // Returned EMD projects
        $returneds = (clone $baseQuery)
            ->whereHas('securityDeposits', function ($q) {
                $q->where('isReturned', 1);
            })
            ->latest()
            ->get();



        // Active EMD projects (not returned & not forfeited)
        $actives = (clone $baseQuery)
            ->whereHas('securityDeposits', function ($q) {
                $q->where('isReturned', 0)
                ->where('isForfieted', 0);
            })
            ->latest()
            ->get();

            // dd($actives);

        // All EMD-related project details
        $securityDeposits = (clone $baseQuery)
            ->latest()
            ->get();

            // dd($pgDetails);


        return view('admin.security_deposits.index', compact(
            'projects',
            'securityDeposits',
            'forfieteds',
            'returneds',
            'actives'
        ));
        // return view('admin.security_deposits.index', compact('projects'));
    }

     public function withheldreturnIndex()
    {
        // $projects = Project::with(['departments', 'state','withhelds'])->where('user_id', auth()->id())->latest()->paginate(20);
         $userId = auth()->id();

        // Base query to avoid repetition
        $baseQuery = Project::with(['departments', 'state', 'securityDeposits'])
            ->where('user_id', $userId);



        // All projects (paginated)
        $projects = (clone $baseQuery)
            ->latest()
            ->paginate(20);

        // Forfeited EMD projects
        $forfieteds = (clone $baseQuery)
            ->whereHas('withhelds', function ($q) {
                $q->where('isForfieted', 1);
            })
            ->latest()
            ->get();



        // Returned EMD projects
        $returneds = (clone $baseQuery)
            ->whereHas('withhelds', function ($q) {
                $q->where('isReturned', 1);
            })
            ->latest()
            ->get();



        // Active EMD projects (not returned & not forfeited)
        $actives = (clone $baseQuery)
            ->whereHas('withhelds', function ($q) {
                $q->where('isReturned', 0)
                ->where('isForfieted', 0);
            })
            ->latest()
            ->get();

            // dd($actives);

        // All EMD-related project details
        $withhelds = (clone $baseQuery)
            ->latest()
            ->get();

            // dd($pgDetails);


        return view('admin.withheld.index', compact(
            'projects',
            'withhelds',
            'forfieteds',
            'returneds',
            'actives'
        ));
        // return view('admin.withheld.index', compact('projects'));
    }


     public function pgforfietedIndex()
    {
        $projects = Project::with(['departments', 'state','emds'])->where('user_id', auth()->id())->latest()->paginate(20);
        return view('admin.pgforfitted.index', compact('projects'));
    }

     public function securityforfietedIndex()
    {
        $projects = Project::with(['departments', 'state','emds'])->where('user_id', auth()->id())->latest()->paginate(20);
        return view('admin.securitydeposite_forfieted.index', compact('projects'));
    }


     public function withheldforfietedIndex()
    {
        $projects = Project::with(['departments', 'state','withhelds'])->where('user_id', auth()->id())->latest()->paginate(20);
        return view('admin.withheld_forfieted.index', compact('projects'));
    }


    public function create()
    {
        $user = auth()->user();

        // Collect allowed user IDs
        $userIds = [$user->id];

        if ($user->role === 'staff' && $user->parent_id) {
            $userIds[] = $user->parent_id;
        }

        $departments = Department::whereIn('user_id', $userIds)
            ->orderBy('name')
            ->get();

        $states = State::orderBy('name')->get();

        return view('admin.projects.create', compact('departments', 'states'));
    }




    public function commonCreate(Project $project)
    {
        $emdDetails = $project->emds;
        $pgDetails = $project->pgDetails;
        $securityDeposits = $project->securityDeposits;
        $withhelds = $project->withhelds;


        return view('admin.common.indexdetails', compact('project', 'emdDetails', 'pgDetails', 'securityDeposits', 'withhelds'));
    }

        public function returnedCreate(Project $project)
        {
            $forfieteds = $project->emds()
                ->where('isForfieted', 1)
                ->get();

            $returneds = $project->emds()
                ->where('isReturned', 1)
                ->get();

            $actives = $project->emds()
                ->where('isReturned', 0)
                ->where('isForfieted', 0)
                ->get();

            $emdDetails = $project->emds;

            return view('admin.unqualified.indexdetails', compact('project', 'emdDetails', 'forfieteds', 'returneds', 'actives'));
        }

          public function pgreturnedCreate(Project $project)
        {
            $pgDetails = $project->pgDetails;

            $actives = $project->pgDetails()
                ->where('isReturned', 0)
                ->where('isForfieted', 0)
                ->get();

            $returneds = $project->pgDetails()
                ->where('isReturned', 1)
                ->get();

            $forfieteds = $project->pgDetails()
                ->where('isForfieted', 1)
                ->get();

            return view('admin.pgreturn.indexdetails', compact('project', 'pgDetails', 'forfieteds', 'returneds', 'actives'));
        }

        public function securityreturnedCreate(Project $project)
        {
            $securityDeposits = $project->securityDeposits;
            $actives = $project->securityDeposits()
                ->where('isReturned', 0)
                ->where('isForfeited', 0)
                ->get();

            $returneds = $project->securityDeposits()
                ->where('isReturned', 1)
                ->get();

            $forfieteds = $project->securityDeposits()
                ->where('isForfeited', 1)
                ->get();

            return view('admin.security_deposits.indexdetails', compact('project', 'securityDeposits', 'forfieteds', 'returneds', 'actives'));
        }

           public function withheldreturnedCreate(Project $project)
        {
            $withhelds = $project->withhelds;

            $actives = $project->withhelds()
                ->where('isReturned', 0)
                ->where('isForfeited', 0)
                ->get();

            $returneds = $project->withhelds()
                ->where('isReturned', 1)
                ->get();

            $forfieteds = $project->withhelds()
                ->where('isForfeited', 1)
                ->get();

            return view('admin.withheld.index2', compact('project', 'withhelds', 'forfieteds', 'returneds', 'actives'));
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

        $data['user_id'] = Auth::id();

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

        ScheduleWork::create([
            'project_id'        => $project->id,
            'section_name'      => 'GENERAL',
            'description'       =>'Project Contingency',
            'quantity'          => 1,
            'unit'              => 1,
            'rate'              => 1,
            'amount'            => 1,
            'measured_quantity' => 1,
        ]);



        return redirect()->route('admin.projects.index')
            ->with('success', 'Project created.');
    }






    public function saveEmd(Request $request, Project $project)
    {
        $rows = $request->emd;

        // 🔹 If row-wise save
        if ($request->has('row_index')) {
            $rows = [$request->emd[$request->row_index]];
        }

        foreach ($rows as $row) {

            $emd = !empty($row['id'])
                ? EmdDetail::findOrFail($row['id'])
                : new EmdDetail(['project_id' => $project->id]);

            $emd->fill([
                'instrument_type'   => $row['instrument_type'] ?? null,
                'instrument_number' => $row['instrument_number'] ?? null,
                'instrument_date'   => $row['instrument_date'] ?? null,
                'amount'            => $row['amount'],
                'remarks'           => $row['remarks'] ?? null,
            ]);

            if (!empty($row['upload'])) {
                if ($emd->upload && Storage::disk('public')->exists($emd->upload)) {
                    Storage::disk('public')->delete($emd->upload);
                }
                $emd->upload = $row['upload']->store('emd_docs', 'public');
            }

            $emd->save();
        }

        return back()->with('success', 'EMD saved successfully');
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
        $securityDeposit->isForfieted = $request->isForfieted;
        $securityDeposit->save();

        return response()->json([
            'success' => true,
            'message' => 'Security forfieted updated successfully.'
        ]);
    }

         public function updateforfittedWithheldReturned(Request $request, Withheld $withheld)
    {
        $withheld->isForfieted = $request->isForfieted;
        $withheld->save();

        return response()->json([
            'success' => true,
            'message' => 'Withheld forfieted updated successfully.'
        ]);
    }


    public function acceptanceIndex( Request $request)
    {
       


        $projects = Project::whereIn('status', ['bidding', 'accepted', 'awarded'])
                    ->where('user_id', auth()->id())
                    ->when($request->filled('fy'), function ($query) use ($request) {

                        $start = Carbon::create($request->fy, 4, 1)->startOfDay();
                        $end   = Carbon::create($request->fy + 1, 3, 31)->endOfDay();

                        $query->whereBetween('date_of_start', [$start, $end]);
                    })
                    ->latest()
                    ->paginate(20);

        return view('admin.acceptance.index', compact('projects'));
    }

     public function awardIndex(Request $request)
    {
       

        $projects = Project::
        //  whereIn('status', ['bidding', 'accepted'])
        where('user_id', auth()->id())
        ->when($request->filled('fy'), function ($query) use ($request) {

            $start = Carbon::create($request->fy, 4, 1)->startOfDay();
            $end   = Carbon::create($request->fy + 1, 3, 31)->endOfDay();

            $query->whereBetween('date_of_start', [$start, $end]);
        })
        ->latest()
        ->paginate(20);

        return view('admin.award.index', compact('projects'));
    }

    public function awardIndexs(Request $request ,Project $project)
    {
       
        $projects = $project->where('user_id', auth()->id())
                    ->where("id", $project->id)
                    ->when($request->filled('fy'), function ($query) use ($request) {
                        $start = Carbon::create($request->fy, 4, 1)->startOfDay();
                        $end   = Carbon::create($request->fy + 1, 3, 31)->endOfDay();

                        $query->whereBetween('date_of_start', [$start, $end]);
                    })
                
                    ->latest()->paginate(20);

        return view('admin.award.index2', compact('projects'));
    }

    public function agreementIndex(Request $request)
    {
        $projects = Project::whereIn('status', ['bidding', 'accepted','awarded','agreement'])->where('user_id', auth()->id())
            ->when($request->filled('year'), function ($query) use ($request) {
                $query->whereYear('created_at', $request->year);
            })
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
            'pg_submission_date'    => 'nullable|date',
        ]);

        $project->status = 'accepted';
        $project->tendered_amount = $request->tendered_amount;
        $project->acceptance_letter_no = $request->acceptance_letter_no;
        $project->date = $request->date;
        $project->pg_submission_date = $request->pg_submission_date;

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
            'date_ofstartof_work'       => 'nullable|date',
            'agreement_no'  => 'nullable|string',
        ]);

        $project->status = 'agreement';

        $project->award_letter_no = $request->award_letter_no;
        $project->award_date = $request->award_date;
        $project->date_ofstartof_work = $request->date_ofstartof_work;
        $project->agreement_no = $request->agreement_no;

         // ✅ BACKEND DATE CALCULATION
        if ($request->award_date && $project->time_allowed_number && $project->time_allowed_type) {

            $awardDate = Carbon::parse($request->award_date);
            $number    = (int) $project->time_allowed_number;
            $type      = strtolower(trim($project->time_allowed_type));

            // normalize plural (Days → day)
            if (str_ends_with($type, 's')) {
                $type = rtrim($type, 's');
            }

            switch ($type) {
                case 'day':
                    $awardDate->addDays($number);
                    break;

                case 'month':
                    $awardDate->addMonths($number);
                    break;

                case 'year':
                    $awardDate->addYears($number);
                    break;
            }

            $project->stipulated_date_ofcompletion = $awardDate->format('Y-m-d');
        }


        if ($request->hasFile('award_upload')) {
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

            'stipulated_date_ofcompletion' => 'nullable|date',
            'agreement_upload'     => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
        ]);

        $project->status = 'agreement';

        $project->agreement_no = $request->agreement_no;

        $project->stipulated_date_ofcompletion = $request->stipulated_date_ofcompletion;

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
        $states = State::orderBy('name')->get();
        $departments = Department::where('user_id', auth()->id())->orderBy('name')->get();
        return view('admin.projects.edit', compact('project', 'states', 'departments'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'name'                => 'required',
            'emd_rate'            => 'nullable',
            'nit_number'          => 'required|string|max:255',
            'department'          => 'required|exists:departments,id',
            'location'            => 'required|exists:states,id',
            'estimated_amount'    => 'required|numeric|min:0',
            'time_allowed_number' => 'required|numeric|min:1',
            'time_allowed_type'   => 'required|in:Days,Weeks,Months,Years',
            'date_of_start'       => 'nullable|date',
            'date_of_opening'     => 'nullable|date',
            'emd_amount'          => 'required|numeric|min:0',
        ]);

        $project->update($data);

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project updated successfully.');
    }



    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success','Deleted.');
    }
}
