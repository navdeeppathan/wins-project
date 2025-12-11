<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Models\Department;
use App\Models\Project;
use App\Models\State;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->paginate(20);
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $departments = Department::where('user_id', auth()->id())->orderBy('name')->get();
        $states = State::orderBy('name')->get();
        return view('admin.projects.create', compact('departments','states'));
    }

    public function store(ProjectRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();

        if ($request->hasFile('emd_file')) {
            $data['emd_file'] = $request->emd_file->store('emd_docs', 'public');
        }

        Project::create($data);
        return redirect()->route('admin.projects.index')->with('success','Project created.');
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
