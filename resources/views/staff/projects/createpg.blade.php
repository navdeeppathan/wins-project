@extends('layouts.staff')

@section('title','Add PG Details')

@section('content')

<h3 class="mb-3">Project – PG Details – #{{ $project->name}}</h3>




{{-- PROJECT INFO (DISABLED) --}}
<div class="row">

     <div class="col-md-12 mb-3">
        <label>Project Name</label>
        <input type="text" class="form-control" value="{{ $project->name }}" disabled>
    </div>

    <div class="col-md-4 mb-3">
        <label>NIT Number</label>
        <input type="text" class="form-control" value="{{ $project->nit_number }}" disabled>
    </div>

     <div class="col-md-4 mb-3">
        <label>Department</label>
        <input class="form-control"
               value="{{ $project->departments->name ?? '-' }}"
               disabled>
    </div>

    <div class="col-md-4 mb-3">
        <label>State</label>
        <input class="form-control"
               value="{{ $project->state->name ?? '-' }}"
               disabled>
    </div>

    <div class="col-md-4 mb-3">
        <label>Date of Submission</label>
        <input type="text" class="form-control" value="{{ date('d-m-y', strtotime($project->date_of_start)) ?? '-' }}" disabled>
    </div>

    <div class="col-md-4 mb-3">
        <label>Date of Opening</label>
        <input type="text" class="form-control" value="{{ date('d-m-y', strtotime($project->date_of_opening)) ?? '-' }}" disabled>
    </div>


    

    <div class="col-md-4 mb-3">
        <label>Estimated Amount</label>
        <input type="text" class="form-control" value="{{ $project->estimated_amount }}" disabled>
    </div>

    <div class="col-md-4 flex mb-3">
        <label>Time</label>
        <input type="text" class="form-control" value="{{ $project->time_allowed_number }} {{ $project->time_allowed_type }}" disabled>
 
    </div>


    <div class="col-md-4 mb-3">
        <label>Tender Amount</label>
        <input type="text" class="form-control" value="{{ $project->tendered_amount }}" disabled>
    </div>

</div>

<hr>

{{-- PG DETAILS --}}
<form action="{{ route('staff.projects.pg.save', $project) }}" method="POST" enctype="multipart/form-data">
@csrf

<h4>PG Details</h4>
<div class="table-responsive">

<table id="example" class="table class-table nowrap" style="width:100%">
<thead>
<tr>
    <th>#</th>
    <th>Type</th>
    <th>No</th>
    <th>Date</th>
    <th>Valid Upto</th>
    <th>Amount</th>
    <th>Upload</th>
    <th>Action</th>
</tr>
</thead>

<tbody id="pgTable">
@forelse($pgs as $i => $pg)
<tr>
    <td>{{ $i+1 }}</td>

    <input type="hidden" name="pg[{{ $i }}][id]" value="{{ $pg->id }}">

    <td>
        <select name="pg[{{ $i }}][instrument_type]" class="form-select">
            @foreach(['FDR','DD','BG','Challan'] as $t)
                <option value="{{ $t }}" @selected($pg->instrument_type==$t)>{{ $t }}</option>
            @endforeach
        </select>
    </td>

    <td><input name="pg[{{ $i }}][instrument_number]" value="{{ $pg->instrument_number }}" class="form-control"></td>
    <td><input type="date" name="pg[{{ $i }}][instrument_date]" value="{{ $pg->instrument_date }}" class="form-control"></td>
    <td><input type="date" name="pg[{{ $i }}][instrument_valid_upto]" value="{{ $pg->instrument_valid_upto }}" class="form-control"></td>
    <td><input type="number" step="0.01" name="pg[{{ $i }}][amount]" value="{{ $pg->amount }}" class="form-control"></td>

    <td>
        @if($pg->upload)
            <a href="{{ asset('storage/'.$pg->upload) }}" target="_blank">View</a>
        @endif
        <input type="file" name="pg[{{ $i }}][upload]" class="form-control">
    </td>

    <td><button type="button" class="btn btn-danger removeRow">X</button></td>
</tr>
@empty
<tr>
<td>1</td>
<td>
<select name="pg[0][instrument_type]" class="form-select">
    @foreach(['FDR','DD','BG','Challan'] as $t)
        <option value="{{ $t }}">{{ $t }}</option>
    @endforeach
</select>
</td>
<td><input name="pg[0][instrument_number]" class="form-control"></td>
<td><input type="date" name="pg[0][instrument_date]" class="form-control"></td>
<td><input type="date" name="pg[0][instrument_valid_upto]" class="form-control"></td>
<td>
<input type="number" step="0.01"
       name="pg[0][amount]"
       value="{{ number_format($project->tendered_amount * 0.05, 2,'.','') }}"
       class="form-control">
</td>
<td><input type="file" name="pg[0][upload]" class="form-control"></td>
<td></td>
</tr>
@endforelse
</tbody>
</table>

<div class="d-flex  align-items-center justify-content-end">
<button type="button" class="btn btn-primary mb-3" id="addPgRow">
    + Add More
</button>
</div>
<div class="d-flex  align-items-center justify-content-end">

<button type="submit" class="btn btn-success">
    Save PG Details
</button>
</div>

</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    let pgIndex = {{ count($pgs ?? []) }};
    const tenderedAmount = {{ $project->tendered_amount ?? 0 }};

    document.getElementById('addPgRow').addEventListener('click', function () {

        let defaultAmount = (tenderedAmount * 0.05).toFixed(2);

        let row = `
        <tr>
            <td>${pgIndex + 1}</td>

            <td>
                <select name="pg[${pgIndex}][instrument_type]" class="form-select">
                    <option value="">Select</option>
                    <option value="FDR">FDR</option>
                    <option value="DD">DD</option>
                    <option value="BG">BG</option>
                    <option value="Challan">Challan</option>
                </select>
            </td>

            <td>
                <input type="text"
                       name="pg[${pgIndex}][instrument_number]"
                       class="form-control">
            </td>

            <td>
                <input type="date"
                       name="pg[${pgIndex}][instrument_date]"
                       class="form-control">
            </td>

            <td>
                <input type="date"
                       name="pg[${pgIndex}][instrument_valid_upto]"
                       class="form-control">
            </td>

            <td>
                <input type="number"
                       step="0.01"
                       name="pg[${pgIndex}][amount]"
                       value="${defaultAmount}"
                       class="form-control">
            </td>

            <td>
                <input type="file"
                       name="pg[${pgIndex}][upload]"
                       class="form-control">
            </td>

            <td>
                <button type="button"
                        class="btn btn-danger removeRow">
                    X
                </button>
            </td>
        </tr>`;

        document.getElementById('pgTable')
                .insertAdjacentHTML('beforeend', row);

        pgIndex++;
    });

    // ❌ REMOVE ROW
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('removeRow')) {
            e.target.closest('tr').remove();
            reindexPgRows();
        }
    });

    function reindexPgRows() {
        document.querySelectorAll('#pgTable tr').forEach((row, i) => {
            row.querySelector('td:first-child').innerText = i + 1;
        });
    }
});

</script>
@endpush


@endsection
