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
           <input type="number" step="0.01"
                name="estimated_amount"
                id="estimated_amount"
                value="{{ old('estimated_amount', $project->estimated_amount) }}"
                class="form-control"
                required>
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


        <div class="col-md-2 mb-3">
            <label class="form-label">EMD Rate *</label>
            <select id="emd_rate" name="emd_rate" class="form-select">
                <option value="2" {{ $project->emd_rate == 2 ? 'selected' : '' }}>2 PERCENT</option>
                <option value="1" {{ $project->emd_rate == 1 ? 'selected' : '' }}>1 PERCENT</option>
                <option value="other" {{ $project->emd_rate == 'other' ? 'selected' : '' }}>OTHER</option>

            </select>
        </div>

        {{-- EMD AMOUNT --}}
       <div class="col-md-2 mb-3">
            <label class="form-label">EMD Amount *</label>
            <input type="number"
                step="0.01"
                name="emd_amount"
                id="emd_amount"
                class="form-control"
                value="{{ old('emd_amount', $project->emd_amount) }}"
                required>
        </div>

        <div class="col-md-2 mb-3">
            <label class="form-label">Tender Fee</label>
           <input
            type="number" 
            step="0.01" 
            name="tender_fee"
            id="tender_fee"
            value="{{ old('tender_fee', $project->tender_fee) }}"
            placeholder="Enter Estimated Cost"
            class="form-control">
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
    const rateSelect     = document.getElementById('emd_rate');
    const emdInput       = document.getElementById('emd_amount');
    const estimateInput  = document.getElementById('estimated_amount');

    let userInteracted = false; // 🔑 important flag

    function calculateEMD() {
        const rate = rateSelect.value;
        const base = parseFloat(estimateInput.value);

        if (!base || base <= 0) return;

        if (rate === 'other') {
            // OTHER selected → manual entry allowed
            return;
        }

        const percent = parseFloat(rate);
        if (!isNaN(percent)) {
            const emd = ((base * percent) / 100).toFixed(2);
            emdInput.value = emd;
        }
    }

    // 🔹 User interaction detection
    rateSelect.addEventListener('change', () => {
        userInteracted = true;
        calculateEMD();
    });

    estimateInput.addEventListener('input', () => {
        userInteracted = true;
        calculateEMD();
    });

    // ❌ No auto calculation on page load
    // Database value will remain untouched
</script>



@endsection
