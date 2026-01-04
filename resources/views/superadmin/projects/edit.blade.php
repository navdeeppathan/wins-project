@extends('layouts.admin')

@section('title','Edit Project')

@section('content')
<h3 class="mb-3">Edit Project #{{ $project->id }}</h3>

{{-- Main project edit form --}}
<form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data" class="mb-4">
    @csrf @method('PUT')

    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">NIT Number *</label>
            <input type="text" name="nit_number" value="{{ old('nit_number', $project->nit_number) }}" class="form-control" required>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Department *</label>
            <input type="text" name="department" value="{{ old('department', $project->departments->name) }}" class="form-control" required>
        </div>
{{--
        <div class="col-md-4 mb-3">
            <label class="form-label">Location *</label>
            <input type="text" name="location" value="{{ old('location', $project->state->name) }}" class="form-control" required>
        </div> --}}

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
            <input type="number" name="time_allowed_number"
                   value="{{ old('time_allowed_number', $project->time_allowed_number) }}" class="form-control" required>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Term *</label>
            <select name="time_allowed_type" class="form-select" required>
                <option value="">Select</option>
                @foreach(['Days','Weeks','Months'] as $t)
                    <option value="{{ $t }}" @selected($project->time_allowed_type==$t)>{{ $t }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">EMD Amt</label>
            <input type="number" step="0.01" name="emd_amount"
                   value="{{ old('emd_amount', $project->emd_amount) }}" class="form-control">
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">EMD Type</label>
            <select name="emd_type" class="form-select">
                <option value="">Select</option>
                @foreach(['FDR','DD','BG'] as $t)
                    <option value="{{ $t }}" @selected($project->emd_type==$t)>{{ $t }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">EMD Document</label>
            <input type="file" name="emd_file" class="form-control">
            @if($project->emd_file)
                <small class="text-muted d-block mt-1">
                    Current: <a href="{{ asset('storage/'.$project->emd_file) }}" target="_blank">View</a>
                </small>
            @endif
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Date of Opening</label>
            <input type="date" name="date_of_opening" value="{{ old('date_of_opening', $project->date_of_opening) }}" class="form-control">
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Date of Start</label>
            <input type="date" name="date_of_start" value="{{ old('date_of_start', $project->date_of_start) }}" class="form-control">
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Stipulated Completion</label>
            <input type="date" name="stipulated_completion"
                   value="{{ old('stipulated_completion', $project->stipulated_completion) }}" class="form-control">
        </div>
    </div>

    <button class="btn btn-success">Update Project</button>
    <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">Back</a>
</form>

<hr>

{{-- WORKFLOW CARDS: Acceptance, Award, Agreement --}}
<div class="row">
    {{-- Acceptance --}}
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-header bg-light">
                <strong>Acceptance</strong>
            </div>
            <div class="card-body">
                @if($project->acceptance)
                    <p><strong>No:</strong> {{ $project->acceptance->acceptance_letter_no }}</p>
                    <p><strong>Date:</strong> {{ $project->acceptance->acceptance_date }}</p>
                    @if($project->acceptance->acceptance_file)
                        <a href="{{ asset('storage/'.$project->acceptance->acceptance_file) }}" target="_blank">View Letter</a>
                    @endif
                @else
                    <form action="{{ route('admin.projects.acceptance.store', $project) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label">Letter No *</label>
                            <input type="text" name="acceptance_letter_no" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Date *</label>
                            <input type="date" name="acceptance_date" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Upload Letter</label>
                            <input type="file" name="acceptance_file" class="form-control">
                        </div>
                        <button class="btn btn-sm btn-primary">Save Acceptance</button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    {{-- Award --}}
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-header bg-light">
                <strong>Award</strong>
            </div>
            <div class="card-body">
                @if($project->award)
                    <p><strong>No:</strong> {{ $project->award->award_letter_no }}</p>
                    <p><strong>Date:</strong> {{ $project->award->award_date }}</p>
                    <p><strong>Amount:</strong> {{ number_format($project->award->awarded_amount,2) }}</p>
                    @if($project->award->award_file)
                        <a href="{{ asset('storage/'.$project->award->award_file) }}" target="_blank">View Award</a>
                    @endif
                @else
                    <form action="{{ route('admin.projects.award.store', $project) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label">Award Letter No *</label>
                            <input type="text" name="award_letter_no" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Date *</label>
                            <input type="date" name="award_date" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Awarded Amount *</label>
                            <input type="number" step="0.01" name="awarded_amount" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Upload Letter</label>
                            <input type="file" name="award_file" class="form-control">
                        </div>
                        <button class="btn btn-sm btn-primary">Save Award</button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    {{-- Agreement --}}
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-header bg-light">
                <strong>Agreement</strong>
            </div>
            <div class="card-body">
                @if($project->agreement)
                    <p><strong>No:</strong> {{ $project->agreement->agreement_no }}</p>
                    <p><strong>Date:</strong> {{ $project->agreement->agreement_date }}</p>
                    <p><strong>Start:</strong> {{ $project->agreement->start_date }}</p>
                    @if($project->agreement->agreement_file)
                        <a href="{{ asset('storage/'.$project->agreement->agreement_file) }}" target="_blank">View Agreement</a>
                    @endif
                @else
                    <form action="{{ route('admin.projects.agreement.store', $project) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label">Agreement No *</label>
                            <input type="text" name="agreement_no" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Agreement Date *</label>
                            <input type="date" name="agreement_date" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Start Date *</label>
                            <input type="date" name="start_date" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Time Allowed *</label>
                            <input type="number" name="time_allowed_number" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Term *</label>
                            <select name="time_allowed_type" class="form-select" required>
                                <option value="Days">Days</option>
                                <option value="Weeks">Weeks</option>
                                <option value="Months">Months</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Upload Agreement</label>
                            <input type="file" name="agreement_file" class="form-control">
                        </div>
                        <button class="btn btn-sm btn-primary">Save Agreement</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('admin.projects.billing.index', $project) }}" class="btn btn-outline-primary">
        Go to Billing
    </a>
</div>
@endsection
