<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Exception;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::latest()->get();
        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            Department::create([
                'user_id' => auth()->id(), // current user
                'name' => $request->name,
            ]);

            return redirect()->route('departments.index')->with('success', 'Department created successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error occurred: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $department = Department::findOrFail($id);
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $department = Department::findOrFail($id);
            $department->update(['name' => $request->name]);

            return redirect()->route('departments.index')->with('success', 'Department updated successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Update failed: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $department = Department::findOrFail($id);
            $department->delete();

            return redirect()->route('departments.index')->with('success', 'Department deleted successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Delete failed: ' . $e->getMessage());
        }
    }
}
