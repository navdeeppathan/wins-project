<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TAndP;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TAndPController extends Controller
{
    public function index(Request $request)
    {
        $projectId = $request->query('project_id');

        $items = TAndP::when($projectId, fn($q) => $q->where('project_id', $projectId))
            ->orderBy('id')
            ->get();

             $user = auth()->user();
        // Admin → own + staff projects
        if ($user->role === 'admin') {
            $userIds = \App\Models\User::where('parent_id', $user->id)
                        ->pluck('id')
                        ->toArray();

            $userIds[] = $user->id;
        }else {
            $userIds = [$user->id];
        }
        $projects = Project::whereIn('user_id', $userIds)->get();

        return view('admin.tandp.index', compact('items', 'projects'));
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        $data['net_payable'] = $data['amount'] - ($data['deduction'] ?? 0);

        if ($request->hasFile('upload')) {
            $data['upload'] = $this->uploadFile($request);
        }

        TAndP::create($data);

        return response()->json(['success' => true]);
    }

    public function update(Request $request, TAndP $tAndP)
    {
        $data = $this->validatedData($request);

        $data['net_payable'] = $data['amount'] - ($data['deduction'] ?? 0);

        if ($request->hasFile('upload')) {
            if ($tAndP->upload && File::exists(public_path($tAndP->upload))) {
                File::delete(public_path($tAndP->upload));
            }
            $data['upload'] = $this->uploadFile($request);
        }

        $tAndP->update($data);

        return response()->json(['success' => true]);
    }

    public function destroy(TAndP $tAndP)
    {
        if ($tAndP->upload && File::exists(public_path($tAndP->upload))) {
            File::delete(public_path($tAndP->upload));
        }

        $tAndP->delete();

        return response()->json(['success' => true]);
    }

    private function validatedData(Request $request)
    {
        return $request->validate([

            'date'        => 'nullable|date',
            'category'    => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'paid_to'     => 'nullable|string|max:255',
            'voucher'     => 'nullable|string|max:100',
            'quantity'    => 'required|numeric|min:0',
            'amount'      => 'required|numeric|min:0',
            'deduction'   => 'nullable|numeric|min:0',
        ]);
    }

    private function uploadFile(Request $request)
    {
        $file = $request->file('upload');
        $name = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('uploads/t_and_p'), $name);
        return 'uploads/t_and_p/'.$name;
    }
}
