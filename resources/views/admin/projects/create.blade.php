@extends('layouts.admin')

@section('title','Create Project')

@section('content')
<h3 class="mb-3">Create Project (Bidding)</h3>

<form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row">
         <div class="col-md-4 mb-3">
            <label class="form-label">State *</label>
            <input type="text" name="location" value="{{ old('location') }}" class="form-control" required>
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Department *</label>
            <input type="text" name="department" value="{{ old('department') }}" class="form-control" required>
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">NIT Number *</label>
            <input type="text" name="nit_number" value="{{ old('nit_number') }}" class="form-control" required>
        </div>
         <div class="col-md-4 mb-3">
            <label class="form-label">Date of Opening</label>
            <input type="date" name="date_of_opening" value="{{ old('date_of_opening') }}" class="form-control">
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Date of Submission</label>
            <input type="date" name="date_of_start" value="{{ old('date_of_start') }}" class="form-control">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Estimated Cost *</label>
            <input type="number" step="0.01" name="estimated_amount"
                   value="{{ old('estimated_amount') }}" class="form-control" required>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Time Allowed (Number) *</label>
            <input type="number" name="time_allowed_number"
                   value="{{ old('time_allowed_number') }}" class="form-control" required>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Time Type *</label>
            <select name="time_allowed_type" class="form-select" required>
                <option value="">Select</option>
                <option value="Days">Days</option>
                <option value="Weeks">Weeks</option>
                <option value="Months">Months</option>
            </select>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">EMD Amount</label>
            <input type="number" step="0.01" name="emd_amount"
                   value="{{ old('emd_amount') }}" class="form-control">
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">EMD Type</label>
            <select name="emd_type" class="form-select">
                <option value="">Select</option>
                <option value="FDR">FDR</option>
                <option value="DD">DD</option>
                <option value="BG">BG</option>
            </select>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">EMD Document (PDF/JPG/PNG)</label>
            <input type="file" name="emd_file" class="form-control">
        </div>

       

        <div class="col-md-4 mb-3">
            <label class="form-label">Stipulated Completion</label>
            <input type="date" name="stipulated_completion"
                   value="{{ old('stipulated_completion') }}" class="form-control">
        </div>
    </div>

    <button class="btn btn-success">Save Project</button>
    <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">Back</a>
</form>
@endsection
