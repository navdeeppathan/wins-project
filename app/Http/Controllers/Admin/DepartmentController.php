<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Exception;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::where('user_id', auth()->id())->latest()->get();
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
                'contact_person_name'=>'nullable|string|max:255',
                'contact_person_designation'=>'nullable|string|max:255',
                'contact_number'=>'nullable|string|max:20',
                'email_id'=>'nullable|string',
            ]);

            Department::create([
                'user_id' => auth()->id(), // current user
                'name' => $request->name,
                'contact_person_name'=>$request->contact_person_name,
                'contact_person_designation'=>$request->contact_person_designation,
                'contact_number'=>$request->contact_number,
                'email_id'=>$request->email_id
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
                'contact_person_name'=>'nullable|string|max:255',
                'contact_person_designation'=>'nullable|string|max:255',
                'contact_number'=>'nullable|string|max:20',
                'email_id'=>'nullable|string',
            ]);

            $department = Department::findOrFail($id);
            $department->update(['name' => $request->name,'contact_person_name'=>$request->contact_person_name,'contact_person_designation'=>$request->contact_person_designation,'contact_number'=>$request->contact_number,'email_id'=>$request->email_id]);

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
