@extends('layouts.admin')

@section('title','Projects')

@section('content')


<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Projects (Award)</h3>

</div>
@if($projects->count() > 0)
<div class="table-responsive">
    <table id="example" class="table table-striped nowrap" style="width:100%">

        <thead >
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Acceptance Letter No.</th>
                <th>Date</th>
                <th>Estimate Amount</th>
                <th>Tendered Amount</th>
                <th>Location</th>
                <th>Department</th>
                <th>Award Letter No.</th>
                <th>Award Date</th>
                <!-- NEW COLUMNS -->
                <th>Upload</th>
                <th>Save</th>
                <th>Status</th>
                <th>PG Details</th>

            </tr>
        </thead>
        <tbody>
            @forelse($projects as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->acceptance_letter_no }}</td>
                    <td>{{ $p->date}}</td>

                    <td>{{ number_format($p->estimated_amount,2) }}</td>
                    <td>{{ number_format($p->tendered_amount,2) }}</td>
                    <td>{{ $p->state->name ?? '' }}</td>
                    <td>{{ $p->departments->name ?? '-' }}</td> 

                    {{-- Tendered Amount --}}
                    {{-- <td>
                        <input type="number" step="0.01"
                            class="form-control form-control-sm tendered_amount"
                            value="{{ $p->tendered_amount }}">
                    </td>
                    --}}
                

                    {{-- Acceptance Letter No --}}
                    <td>
                        <input type="text"
                            class="form-control form-control-sm award_letter_no"
                            value="{{ $p->award_letter_no }}">
                    </td>

                    {{-- Acceptance Date --}}
                    <td>
                        <input type="date"
                            class="form-control form-control-sm award_date"
                            value="{{ $p->award_date }}">
                    </td>

                    {{-- Upload --}}
                    <td>
                        <input type="file"
                            class="form-control form-control-sm award_upload">
                    </td>
                    

                {{-- Save --}}
                    <td>
                        <button class="btn btn-sm btn-success saveAwardBtn"
                                data-id="{{ $p->id }}">
                            Save
                        </button>
                    </td>
                    
                    <td><span class="badge bg-info">{{ ucfirst($p->status) }}</span></td>
                    <td>
                        <a href="{{ route('admin.projects.pg.create', $p->id) }}"
                        class="btn btn-sm btn-primary">
                            Add PG
                        </a>
                    </td>

                    
                </tr>
            @empty
                <tr><td colspan="8" class="text-center">No projects yet.</td></tr>
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
$(document).on('click', '.saveAwardBtn', function () {

    let btn = $(this);
    let row = btn.closest('tr');
    let projectId = btn.data('id');

    let formData = new FormData();
    formData.append('_method', 'PUT'); // spoof PUT
    formData.append('_token', "{{ csrf_token() }}");

    

    formData.append(
        'award_letter_no',
        row.find('.award_letter_no').val()
    );

    formData.append(
        'award_date',
        row.find('.award_date').val()
    );

    let fileInput = row.find('.award_upload')[0];
    if (fileInput.files.length > 0) {
        formData.append('award_upload', fileInput.files[0]);
    }

    btn.prop('disabled', true).text('Saving...');

    $.ajax({
        url: "/admin/projects/" + projectId + "/award-update",
        type: "POST", // IMPORTANT
        data: formData,
        processData: false, // required for FormData
        contentType: false, // required for FormData
        success: function (response) {
            btn.prop('disabled', false).text('Save');

            if (response.success) {
                alert(response.message);

                // OPTIONAL: update status text without reload
                row.find('.badge')
                   .removeClass('bg-info')
                   .addClass('bg-success')
                   .text('Awarded');
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
</script>
@endpush



{{ $projects->links() }}

@endsection
