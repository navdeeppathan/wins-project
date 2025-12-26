@extends('layouts.admin')

@section('title','Edit Project')

@section('content')
<h3 class="mb-3">Edit Project #{{ $project->name }}</h3>

{{-- Main project edit form --}}
<form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data" class="mb-4">
    @csrf @method('PUT')

    <div class="row">

        <div class="col-12 mb-3">
            <label class="form-label">Project Name *</label>
            <input type="text" name="name"
                value="{{ old('name', $project->name) }}"
                class="form-control" required>
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">NIT Number *</label>
            <input type="text" name="nit_number" value="{{ old('nit_number', $project->nit_number) }}" class="form-control" required>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Department *</label>
            <select name="department" class="form-select" required>
                <option value="">Select Department</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}"
                        {{ old('department', $project->department) == $dept->id ? 'selected' : '' }}>
                        {{ $dept->name }}
                    </option>
                @endforeach
            </select>
        </div>


        <div class="col-md-4 mb-3">
            <label class="form-label">State *</label>
            <select name="location" class="form-select" required>
                <option value="">Select State</option>
                @foreach($states as $state)
                    <option value="{{ $state->id }}"
                        {{ old('location', $project->location) == $state->id ? 'selected' : '' }}>
                        {{ $state->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Estimated Amount *</label>
            <input type="number" step="0.01" name="estimated_amount"
                   value="{{ old('estimated_amount', $project->estimated_amount) }}" class="form-control" required>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Time Allowed (Number) *</label>
            <input type="number" name="time_allowed_number"
                   value="{{ old('time_allowed_number', $project->time_allowed_number) }}" class="form-control" required>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Time Type *</label>
            <select name="time_allowed_type" class="form-select" required>
                <option value="">Select</option>
                @foreach(['Days','Weeks','Months'] as $t)
                    <option value="{{ $t }}" @selected($project->time_allowed_type==$t)>{{ $t }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="col-md-4 mb-3">
            <label class="form-label">EMD Amount</label>

            {{-- Visible (readonly, not disabled) --}}
            <input type="text"
                class="form-control"
                value="{{ number_format($project->emds->sum('amount'), 2) }}"
                readonly>

            {{-- Hidden (this will submit) --}}
            <input type="hidden"
                name="emd_amount"
                value="{{ $project->emds->sum('amount') }}">
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Date of Submission</label>
            <input type="date" name="date_of_start" value="{{ old('date_of_start', $project->date_of_start) }}" class="form-control">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Date of Opening</label>
            <input type="date" name="date_of_opening" value="{{ old('date_of_opening', $project->date_of_opening) }}" class="form-control">
        </div>      
        
    </div>

    <button class="btn btn-success">Update Project</button>
    <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">Back</a>
</form>

<hr>

@include('admin.projects.editemd', ['emds' => $project->emds])

@endsection
