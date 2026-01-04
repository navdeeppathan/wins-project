

@extends('layouts.staff')

@section('title','Projects')

@section('content')


<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Projects (Agreement)</h3>

</div>
@if($projects->count() > 0)
<div class="table-responsive">
    <table id="example" class="table class-table nowrap" style="width:100%">

        <thead >
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Location</th>
                <th>Department</th>
                <th>Award Letter No.</th>
                <th>Award Date</th>
                <th>Estimate Amt</th>
                <th>Tendered Amount</th>
                <th>Agreement No.</th>
                <th>Agreement Start Date</th>
                <th>Stipulated Date of Completion</th>
                <th>Upload</th>
                <th>Save</th>
            </tr>
        </thead>
        <tbody>
             @php
                $i=1;
            @endphp
            @forelse($projects as $p)
            @if (!empty($p->award_letter_no))
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->state->name ?? '' }}</td>
                    <td>{{ $p->departments->name ?? '-' }}</td>
                    <td>{{ $p->award_letter_no }}</td>
                    <td>{{ date('d-m-Y', strtotime($p->award_date)) ?? '-' }}</td>
                    <td>{{ number_format($p->estimated_amount,2) }}</td>
                    <td>{{ number_format($p->tendered_amount,2) }}</td>
                    <td>
                        <input type="text"
                            class="form-control form-control-sm agreement_no"
                            value="{{ $p->agreement_no }}">
                    </td>
                    <td>
                        <input type="date"
                            class="form-control form-control-sm agreement_start_date"
                            value="{{ $p->agreement_start_date }}">
                    </td>
                    <td>
                        <input type="date"

                            class="form-control form-control-sm stipulated_date_ofcompletion"
                                value="{{ $p->stipulated_date_ofcompletion }}">
                    </td>
                    <td>
                        <input type="file"
                            class="form-control form-control-sm agreement_upload">
                    </td>
                    <td>
                        @if (empty($p->agreement_no))
                             <button class="btn btn-sm btn-success saveAgreementBtn"
                                data-id="{{ $p->id }}">
                            Save
                        </button>
                        @else
                        <span class="badge bg-success">Saved</span>
                        @endif

                    </td>
                </tr>
                @endif
                 @php
                $i++;
            @endphp
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
$(document).on('click', '.saveAgreementBtn', function () {

    let btn = $(this);
    let row = btn.closest('tr');
    let projectId = btn.data('id');

    let formData = new FormData();
    formData.append('_method', 'PUT'); // spoof PUT
    formData.append('_token', "{{ csrf_token() }}");



    formData.append(
        'agreement_no',
        row.find('.agreement_no').val()
    );

    formData.append(
        'agreement_start_date',
        row.find('.agreement_start_date').val()
    );

    formData.append(
        'stipulated_date_ofcompletion',
        row.find('.stipulated_date_ofcompletion').val()
    );

    let fileInput = row.find('.agreement_upload')[0];
    if (fileInput.files.length > 0) {
        formData.append('agreement_upload', fileInput.files[0]);
    }

    btn.prop('disabled', true).text('Saving...');

    $.ajax({
        url: "/staff/projects/" + projectId + "/agreement-update",
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
                   .text('Agreement');
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
