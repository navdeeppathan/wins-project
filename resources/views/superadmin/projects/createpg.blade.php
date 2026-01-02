@extends('layouts.admin')

@section('title','Add PG Details')

@section('content')

<h3 class="mb-3">Project – PG Details</h3>

<form action="{{ route('admin.projects.pg.store', $project->id) }}" 
      method="POST" enctype="multipart/form-data">
@csrf

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
        <label>Time Allowed</label>
        <input type="text" class="form-control" value="{{ $project->time_allowed_number }}" disabled>
    </div>

    <div class="col-md-4 mb-3">
        <label>Temporal</label>
        <input type="text" class="form-control" value="{{ $project->time_allowed_type }}" disabled>
    </div>


</div>

<hr>

{{-- PG DETAILS --}}
<h4>PG Details (Multiple)</h4>

<div class="table-responsive">
    <table id="example"  data-pg-table class="table table-striped nowrap" style="width:100%">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Instrument Type</th>
            <th>Instrument Number</th>
            <th>Instrument Date</th>
            <th>Amount</th>
            <th>Upload</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td>1</td>
            <td>
                <select name="pg[0][instrument_type]" class="form-select">
                    <option value="">Select</option>
                    <option value="FDR">FDR</option>
                    <option value="DD">DD</option>
                    <option value="BG">BG</option>
                </select>
            </td>
            <td><input type="text" name="pg[0][instrument_number]" class="form-control"></td>
            <td><input type="date" name="pg[0][instrument_date]" class="form-control"></td>
            <td><input type="number" step="0.01" name="pg[0][amount]" class="form-control"></td>
            <td><input type="file" name="pg[0][upload]" class="form-control"></td>
            <td><button type="button" class="btn btn-danger removeRow">X</button></td>
        </tr>
    </tbody>
</table>
</div>

<button type="button" class="btn btn-primary mb-3" id="addPgRow">+ Add More</button>

<br>
<button class="btn btn-success">Save PG Details</button>
<a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">Back</a>

</form>

<script>
let pgIndex = 1;

document.getElementById('addPgRow').addEventListener('click', function () {

    let table = document.querySelector('[data-pg-table] tbody');


    let row = `
    <tr>
        <td>${pgIndex + 1}</td>
        <td>
            <select name="pg[${pgIndex}][instrument_type]" class="form-select">
                <option value="">Select</option>
                <option value="FDR">FDR</option>
                <option value="DD">DD</option>
                <option value="BG">BG</option>
            </select>
        </td>
        <td><input type="text" name="pg[${pgIndex}][instrument_number]" class="form-control"></td>
        <td><input type="date" name="pg[${pgIndex}][instrument_date]" class="form-control"></td>
        <td><input type="number" step="0.01" name="pg[${pgIndex}][amount]" class="form-control"></td>
        <td><input type="file" name="pg[${pgIndex}][upload]" class="form-control"></td>
        <td><button type="button" class="btn btn-danger removeRow">X</button></td>
    </tr>`;

    table.insertAdjacentHTML('beforeend', row);
    pgIndex++;
});

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('removeRow')) {
        e.target.closest('tr').remove();
    }
});
</script>

@endsection
