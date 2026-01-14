<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Models\Department;
use App\Models\departments;
use App\Models\EmdDetail;
use App\Models\Inventory;
use App\Models\PgDetail;
use App\Models\Project;
use App\Models\SecurityDeposit;
use App\Models\State;
use App\Models\User;
use App\Models\Withheld;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;

class ProjectController extends Controller
{
    public function index(User $user)
    {
        $projects = Project::with(['departments', 'state','emds','user'])->where('user_id', $user->id)->latest()->paginate(20);
        $inventories = Inventory::where('user_id', $user->id)->latest()->paginate(20);
       
        return view('superadmin.projects.index', compact('projects','inventories'));
    }

   



}
