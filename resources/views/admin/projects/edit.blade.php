@extends('layouts.admin')

@section('title','Edit Project')

@section('content')
<h3 class="mb-3">Edit Project</h3>

{{-- Main project edit form --}}
<form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data" class="mb-4">
    @csrf @method('PUT')

    <div class="row">

       <div class="col-12 mb-3">
        <label class="form-label">Project Name *</label>
        <textarea name="name"
                class="form-control"
                rows="3"
                required>{{ old('name', $project->name) }}</textarea>
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
            <label class="form-label">Time Allowed *</label>
            <select name="time_allowed_number" class="form-select" required>
                <option value="">Select</option>

                @for ($i = 1; $i <= 120; $i++)
                    <option value="{{ $i }}"
                        {{ old('time_allowed_number', $project->time_allowed_number) == $i ? 'selected' : '' }}>
                        {{ $i }}
                    </option>
                @endfor
            </select>
        </div>


        <div class="col-md-4 mb-3">
            <label class="form-label">Term *</label>
            <select name="time_allowed_type" class="form-select" required>
                <option value="">Select</option>
                @foreach(['Days','Weeks','Months','Years'] as $t)
                    <option value="{{ $t }}" @selected($project->time_allowed_type==$t)>{{ $t }}</option>
                @endforeach
            </select>
        </div>


    <div class="col-md-3 mb-3">
        <label class="form-label">EMD Rate *</label>
        <select id="emd_rate" name="emd_rate" class="form-select">
            <option value="">Select</option>
            <option value="2">2 PERCENT</option>
            <option value="1">1 PERCENT</option>
            <option value="other">OTHER</option>
        </select>
    </div>

    {{-- EMD AMOUNT --}}
    <div class="col-md-3 mb-3">
        <label class="form-label">EMD Amount *</label>
        <input type="text"
               id="emd_amount_display"
               class="form-control"
               placeholder="EMD Amount"
               value="{{ number_format($project->emd_amount) }}"
               readonly>

        <input type="hidden" name="emd_amount" id="emd_amount">
    </div>

    {{-- DATE OF SUBMISSION --}}
    <div class="col-md-3 mb-3">
        <label class="form-label">Date of Submission</label>
        <input type="date"
               name="date_of_start"
               value="{{ old('date_of_start', $project->date_of_start) }}"
               class="form-control">
    </div>

    {{-- DATE OF OPENING --}}
    <div class="col-md-3 mb-3">
        <label class="form-label">Date of Opening</label>
        <input type="date"
               name="date_of_opening"
               value="{{ old('date_of_opening', $project->date_of_opening) }}"
               class="form-control">
    </div>



    </div>

    <button class="btn btn-success">Update Project</button>
    <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">Back</a>
</form>

<hr>

@include('admin.projects.editemd', ['emds' => $project->emds])


<script>
    const baseAmount = {{ (float) $project->estimated_amount }};
    // OR use tendered_amount if required

    const rateSelect  = document.getElementById('emd_rate');
    const displayAmt  = document.getElementById('emd_amount_display');
    const hiddenAmt   = document.getElementById('emd_amount');

    rateSelect.addEventListener('change', function () {
        let rate = this.value;

        if (rate === 'other') {
            displayAmt.readOnly = false;
            displayAmt.value = '';
            hiddenAmt.value = '';
            displayAmt.focus();
            return;
        }

        if (rate !== '') {
            let emd = (baseAmount * rate) / 100;
            emd = emd.toFixed(2);

            displayAmt.readOnly = true;
            displayAmt.value = emd;
            hiddenAmt.value = emd;
        }
    });

    // Manual entry sync for OTHER
    displayAmt.addEventListener('input', function () {
        if (!displayAmt.readOnly) {
            hiddenAmt.value = this.value;
        }
    });
</script>

@endsection
