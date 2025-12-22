@extends('layouts.admin')

@section('title','Create Project')

@section('content')
<h3 class="mb-3">Create Project (Agreement Date)</h3>

{{-- PROJECT INFO (DISABLED) --}}
<div class="row">

    <div class="col-md-4 mb-3">
        <label>State</label>
        <input class="form-control"
               value="{{ $project->state->name ?? '-' }}"
               disabled>
    </div>

    <div class="col-md-4 mb-3">
        <label>Department</label>
        <input class="form-control"
               value="{{ $project->department->name ?? '-' }}"
               disabled>
    </div>

    <div class="col-md-4 mb-3">
        <label>Project Name</label>
        <input type="text" class="form-control" value="{{ $project->name }}" disabled>
    </div>

    <div class="col-md-4 mb-3">
        <label>NIT Number</label>
        <input type="text" class="form-control" value="{{ $project->nit_number }}" disabled>
    </div>

    <div class="col-md-4 mb-3">
        <label>Date of Submission</label>
        <input type="text" class="form-control" value="{{ $project->date_of_start }}" disabled>
    </div>

    <div class="col-md-4 mb-3">
        <label>Date of Opening</label>
        <input type="text" class="form-control" value="{{ $project->date_of_opening }}" disabled>
    </div>

    <div class="col-md-4 mb-3">
        <label>Estimated Amount</label>
        <input type="text" class="form-control" value="{{ $project->estimated_amount }}" disabled>
    </div>

    <div class="col-md-4 mb-3">
        <label>Time Allowed (Number)</label>
        <input type="text" class="form-control" value="{{ $project->time_allowed_number }}" disabled>
    </div>

    <div class="col-md-4 mb-3">
        <label>Time Type</label>
        <input type="text" class="form-control" value="{{ $project->time_allowed_type }}" disabled>
    </div>

</div>

<hr>

{{-- ✅ AGREEMENT DETAILS FORM --}}
<form action="{{ route('admin.projects.agreementdate.update', $project->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row">

        <div class="col-md-4 mb-3">
            <label>Agreement Start Date</label>
            <input type="date"
                   name="agreement_start_date"
                   class="form-control"
                   value="{{ $project->agreement_start_date }}">
        </div>

        <div class="col-md-4 mb-3">
            <label>Stipulated Date of Completion</label>
            <input type="date"
                   name="stipulated_date_ofcompletion"
                   class="form-control"
                   value="{{ $project->stipulated_date_ofcompletion }}">
        </div>

        <div class="col-md-4 mb-3 d-flex align-items-end">
            <button type="submit" class="btn btn-success w-100">
                💾 Save Agreement Dates
            </button>
        </div>

    </div>
</form>



@endsection
