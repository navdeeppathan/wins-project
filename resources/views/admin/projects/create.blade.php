@extends('layouts.admin')

@section('title','Create Project')

@section('content')
<h3 class="mb-3">Create Project (Bidding)</h3>

<form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">State *</label>
            <select name="location" class="form-select" required>
                <option value="">Select State</option>
                @foreach($states as $state)
                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Department *</label>
            <select name="department" class="form-select" required>
                <option value="">Select Department</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Project Name *</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
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
            <input type="number" step="0.01" name="estimated_amount" value="{{ old('estimated_amount') }}" class="form-control" required>
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Time Allowed (Number) *</label>
            <select name="time_allowed_number" class="form-select" style="height: 45px;" required>
                <option value="">Select</option>

                @for ($i = 1; $i <= 120; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
                
            </select>
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

        {{-- <div class="col-md-4 mb-3">
            <label class="form-label">EMD Amount</label>
            <input type="number" step="0.01" name="emd_amount" value="{{ old('emd_amount') }}" class="form-control">
        </div> --}}

        {{-- <div class="col-md-4 mb-3">
            <label class="form-label">EMD Type</label>
            <select name="emd_type" class="form-select">
                <option value="">Select</option>
                <option value="FDR">FDR</option>
                <option value="DD">DD</option>
                <option value="BG">BG</option>
            </select>
        </div> --}}

        {{-- <div class="col-md-4 mb-3">
            <label class="form-label">EMD Document (PDF/JPG/PNG)</label>
            <input type="file" name="emd_file" class="form-control">
        </div> --}}

        {{-- <div class="col-md-4 mb-3">
            <label class="form-label">Stipulated Completion</label>
            <input type="date" name="stipulated_completion" value="{{ old('stipulated_completion') }}" class="form-control">
        </div> --}}
    </div>

    <!-- ---------------- EMD DETAILS MULTIPLE ROW SECTION ---------------- -->
    <h4 class="mt-4">EMD Details (Multiple)</h4>

    <table class="table table-bordered" id="emdTable">
        <thead class="table-dark">
            <tr>
                <th>No.</th>
                <th>Instrument Type</th>
                <th>Instrument Number</th>
                <th>Instrument Date</th>
                <th>Amount</th>
                <th>Remarks</th>
                <th>Upload (PDF)</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>1</td>
                <td>
                 
                    <select name="emd[0][instrument_type]" class="form-select">
                        <option value="">Select</option>
                        <option value="FDR">FDR</option>
                        <option value="DD">DD</option>
                        <option value="BG">BG</option>
                    </select>
                </td>

                <td><input type="text" name="emd[0][instrument_number]" class="form-control"></td>
                <td><input type="date" name="emd[0][instrument_date]" class="form-control"></td>
                <td><input type="number" step="0.01" name="emd[0][amount]" class="form-control"></td>
                <td><input type="text" name="emd[0][remarks]" class="form-control"></td>
                <td><input type="file" name="emd[0][upload]" class="form-control"></td>
                <td><button type="button" class="btn btn-danger removeRow">X</button></td>
            </tr>
        </tbody>
    </table>

    <button type="button" class="btn btn-primary mb-4" id="addEmdRow">+ Add More</button>

    <button class="btn btn-success">Save Project</button>
    <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">Back</a>
</form>


<script>
let emdIndex = 1;

// Add Row
document.getElementById('addEmdRow').addEventListener('click', function () {

    let table = document.querySelector('#emdTable tbody');

    let newRow = `
        <tr>
            <td>${emdIndex + 1}</td>
            <td>
                
                <select name="emd[${emdIndex}][instrument_type]" class="form-select">
                    <option value="">Select</option>
                    <option value="FDR">FDR</option>
                    <option value="DD">DD</option>
                    <option value="BG">BG</option>
                </select>
            </td>

            <td><input type="text" name="emd[${emdIndex}][instrument_number]" class="form-control"></td>
            <td><input type="date" name="emd[${emdIndex}][instrument_date]" class="form-control"></td>
            <td><input type="number" step="0.01" name="emd[${emdIndex}][amount]" class="form-control"></td>
            <td><input type="text" name="emd[${emdIndex}][remarks]" class="form-control"></td>
            <td><input type="file" name="emd[${emdIndex}][upload]" class="form-control"></td>
            <td><button type="button" class="btn btn-danger removeRow">X</button></td>
        </tr>
    `;

    table.insertAdjacentHTML('beforeend', newRow);
    emdIndex++;
});

// Remove Row
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('removeRow')) {
        e.target.closest('tr').remove();
    }
});
</script>
@endsection
