<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\EmdDetail;
use App\Models\PgDetail;
use App\Models\Project;
use App\Models\ScheduleWork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillingController extends Controller
{
    public function index(Project $project)
    {
        $billings = Billing::where('project_id', $project->id)->latest()->paginate(20);
        $emds = EmdDetail::where('project_id', $project->id)->latest()->paginate(20);
        $pgs = PgDetail::where('project_id', $project->id)->latest()->paginate(20);
        $schedule_works = ScheduleWork::where('project_id', $project->id)->latest()->paginate(20);
        return view('superadmin.billing.index', compact('project','billings','emds','pgs','schedule_works'));
    }

   
}
