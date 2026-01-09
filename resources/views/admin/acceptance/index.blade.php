@extends('layouts.admin')

@section('title','Projects')

@section('content')


<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Projects (Acceptance)</h3>
</div>


@php
    use Carbon\Carbon;

    $startFY = 2011;

    $today = Carbon::today();
    $currentFY = $today->month >= 4
        ? $today->year
        : $today->year - 1;
@endphp

<form method="GET" action="{{ route('admin.projects.acceptance') }}">
    <div class="row mb-3">
        <div class="col-md-4">
            <label class="fw-bold">Filter by Financial Year</label>
            <select name="fy" class="form-select" onchange="this.form.submit()">
                <option value="">All Financial Years</option>

                @for ($fy = $startFY; $fy <= $currentFY; $fy++)
                    @php $label = $fy . '-' . ($fy + 1); @endphp
                    <option value="{{ $fy }}"
                        {{ request('fy') == $fy ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endfor
            </select>
        </div>
    </div>
</form>

@if($projects->count() > 0)
<div class="table-responsive">
    <table id="example" class="table class-table nowrap" style="width:100%">

        <thead >
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">Name</th>
                <th class="text-center">NIT No</th>
                <th class="text-center">Date of Opening</th>
                <th class="text-center">Estimate Amt</th>
                <!-- <th class="text-center">EMD Amt</th> -->
                <th class="text-center">Tendered Amount*</th>
                <th class="text-center">Acceptance Letter No.</th>
                <th class="text-center">Date</th>
                <th class="text-center">PG Submission By Date</th>
                <th class="text-center">Upload</th>
                <th class="text-center">Save</th>
                <th class="text-center">Add PG</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i=1;
            @endphp
            @forelse($projects as $p)

            @if ($p->isQualified == 1)
                <tr>
                    <td class="text-center">{{ $i }}</td>
                    <td style="
                            text-align: justify;
                            word-break: break-word;
                            text-align-last: justify;
                            text-justify: inter-word;
                            hyphens: auto;
                            ">
                        {!! implode('<br>', array_map(
                            fn($chunk) => implode(' ', $chunk),
                            array_chunk(explode(' ', $p->name), 10)
                        )) !!}
                    </td>
                    <td class="text-center">{{ $p->nit_number }}</td>
                    <!-- <td>{{ $p->state->name ?? '-' }}</td>
                    <td>{{ $p->departments->name ?? '-' }}</td> -->
                    <td class="text-center">{{ date('d-m-Y', strtotime($p->date_of_opening)) }}</td>
                    <td class="text-center">{{ number_format($p->estimated_amount,2) }}</td>
                    <!-- <td>{{ number_format($p->emds?->sum('amount') ?? 0, 2) }}</td> -->
                    <td class="text-center">
                        <input type="number" step="0.01"
                            class="form-control form-control-sm tendered_amount"
                            value="{{ $p->tendered_amount }}" required>
                    </td>
                    <td class="text-center">
                        <input type="text"
                            class="form-control form-control-sm acceptance_letter_no"
                            value="{{ $p->acceptance_letter_no }}" required>
                    </td>
                    <td class="text-center">
                        <input type="date"
                            class="form-control form-control-sm acceptance_date"
                            value="{{ $p->date }}" required>
                    </td>
                     <td class="text-center">
                        <input type="date"
                            class="form-control form-control-sm pg_submission_date"
                            value="{{ $p->pg_submission_date }}" required>
                    </td>
                   <td class="text-center">
                        @if($p->acceptance_upload)
                            <a href="{{ Storage::url($p->acceptance_upload) }}"
                            target="_blank"
                            class="btn btn-sm btn-outline-primary mb-1">
                                View
                            </a>
                        @endif

                        <input type="file"
                            class="form-control form-control-sm acceptance_upload">
                    </td>

                    <td class="text-center">
                        {{-- @if (empty($p->pg_submission_date ) && empty($p->tendered_amount) && empty($p->acceptance_letter_no) && empty($p->date)) --}}
                        <button class="btn btn-sm btn-success saveAcceptanceBtn"
                                data-id="{{ $p->id }}">
                            Save
                        </button>

                    </td>
                    <td class="text-center">

                            <a href="{{ route('admin.projects.pg.create', $p->id) }}" class="btn btn-sm btn-primary addPgBtn">
                                Add PG
                            </a>
                            @if (!empty($p->acceptance_letter_no) && $p->pgDetails->isEmpty())
                            <a href="{{ route('admin.projects.awards', $p->id) }}" class="btn btn-sm btn-primary ">Awards</a>
                            @endif
                    </td>
                </tr>
                @endif
                 @php
                    $i++;
                @endphp
            @empty
                <tr><td colspan="13" class="text-center">No projects yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@else
    <div class="alert alert-warning text-center">
        Data is not available.
    </div>
@endif

@push('scripts')
<script>
$(document).on('click', '.saveAcceptanceBtn', function () {

    let btn = $(this);
    let row = btn.closest('tr');

    let tenderedAmount = row.find('.tendered_amount').val();
    let letterNo = row.find('.acceptance_letter_no').val();
    let date = row.find('.acceptance_date').val();

    if (!tenderedAmount || !letterNo || !date) {
        alert('Please fill all required fields');
        return;
    }

    let projectId = btn.data('id');

    let formData = new FormData();
    formData.append('_method', 'PUT'); // spoof PUT
    formData.append('_token', "{{ csrf_token() }}");

    formData.append(
        'tendered_amount',
        row.find('.tendered_amount').val()
    );

    formData.append(
        'acceptance_letter_no',
        row.find('.acceptance_letter_no').val()
    );

    formData.append(
        'date',
        row.find('.acceptance_date').val()
    );

    formData.append(
        'pg_submission_date',
        row.find('.pg_submission_date').val()
    );

    let fileInput = row.find('.acceptance_upload')[0];
    if (fileInput.files.length > 0) {
        formData.append('acceptance_upload', fileInput.files[0]);
    }

    btn.prop('disabled', true).text('Saving...');

    $.ajax({
        url: "/admin/projects/" + projectId + "/acceptance-update",
        type: "POST", // IMPORTANT
        data: formData,
        processData: false, // required for FormData
        contentType: false, // required for FormData
        success: function (response) {
            btn.prop('disabled', false).text('Save');

            if (response.success) {
                window.location.reload();
                alert(response.message);

                // OPTIONAL: update status text without reload
                row.find('.badge')
                   .removeClass('bg-info')
                   .addClass('bg-success')
                   .text('Accepted');
            } else {
                alert('Update failed');
            }
        },
        error: function (xhr) {
            btn.prop('disabled', false).text('Save');
            alert('Server error');
            console.error(xhr.responseText);
        }
    });
});


document.addEventListener('change', function (e) {
    if (e.target.classList.contains('acceptance_date')) {

        const acceptanceDate = new Date(e.target.value);
        if (isNaN(acceptanceDate)) return;

        // Add 5 days
        acceptanceDate.setDate(acceptanceDate.getDate() + 5);

        // Format to YYYY-MM-DD
        const yyyy = acceptanceDate.getFullYear();
        const mm = String(acceptanceDate.getMonth() + 1).padStart(2, '0');
        const dd = String(acceptanceDate.getDate()).padStart(2, '0');

        // Find PG submission date in same row
        const row = e.target.closest('tr');
        const pgDateInput = row.querySelector('.pg_submission_date');

        if (pgDateInput) {
            pgDateInput.value = `${yyyy}-${mm}-${dd}`;
        }
    }
});



document.addEventListener('input', function (e) {

    if (e.target.classList.contains('tendered_amount')) {

        const row = e.target.closest('tr');
        const addPgBtn = row.querySelector('.addPgBtn');

        const value = parseFloat(e.target.value);

        if (!value || value <= 0) {
            addPgBtn.classList.add('disabled');
            addPgBtn.style.pointerEvents = 'none';
            addPgBtn.style.opacity = '0.5';
        } else {
            addPgBtn.classList.remove('disabled');
            addPgBtn.style.pointerEvents = 'auto';
            addPgBtn.style.opacity = '1';
        }
    }
});

// Initial check on page load
document.querySelectorAll('.tendered_amount').forEach(input => {
    const event = new Event('input');
    input.dispatchEvent(event);
});



</script>
@endpush



{{ $projects->links() }}

@endsection
