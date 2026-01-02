@extends('layouts.admin')

@section('title','Projects')

@section('content')


<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Projects (Award)</h3>

</div>
@if($projects->count() > 0)
<div class="table-responsive">
    <table id="example" class="table class-table nowrap" style="width:100%">

        <thead >
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>NIT No</th>
                <th>Location</th>
                <th>Department</th>
                <th>Date of Opening</th>
                <th>Estimate Amount</th>
                <th>Tendered Amount</th>
                <th>Acceptance Letter No.</th>
                <th>Date</th>
                <th>Award Letter No.</th>
                <th>Award Date</th>
                <th>Date of Start of Work</th>
                <th>Agreement Number</th>

                <th>Upload</th>
                <th>Save</th>
            </tr>
        </thead>
        <tbody>
             @php
                $i=1;
            @endphp
            @forelse($projects as $p)
               @if (!empty($p->acceptance_letter_no))
                <tr>
                   
                    <td>{{ $i }}</td>
                    <td>
                        {!! implode('<br>', array_map(
                            fn($chunk) => implode(' ', $chunk),
                            array_chunk(explode(' ', $p->name), 10)
                        )) !!}
                    </td>
                    <td>{{ $p->nit_number }}</td>
                    <td>{{ $p->state->name ?? '' }}</td>
                    <td>{{ $p->departments->name ?? '-' }}</td> 
                    <td>{{ date('d-m-Y', strtotime($p->date_of_opening)) }}</td>
                    <td>{{ number_format($p->estimated_amount,2) }}</td>
                    <td>{{ number_format($p->tendered_amount,2) }}</td>
                    <td>{{ $p->acceptance_letter_no }}</td>
                    <td>{{ date('d-m-Y', strtotime($p->date)) ?? '-' }}</td>
                    <td>
                        <input type="text"
                            class="form-control form-control-sm award_letter_no"
                            value="{{ $p->award_letter_no }}">
                    </td>
                    <td>
                        <input type="date"
                            class="form-control form-control-sm award_date"
                            value="{{ $p->award_date }}">
                    </td>

                    <td>
                        <input type="date"
                            class="form-control form-control-sm date_ofstartof_work"
                            value="{{ $p->date_ofstartof_work }}">
                    </td>

                    <td>
                        <input type="text"
                            class="form-control form-control-sm agreement_no"
                            value="{{ $p->agreement_no }}">
                    </td>
                    
                    <td>
                         @if($p->award_upload)
                            <a href="{{ Storage::url($p->award_upload) }}"
                            target="_blank"
                            class="btn btn-sm btn-outline-primary mb-1">
                                View
                            </a>
                        @endif
                        <input type="file"
                            class="form-control form-control-sm award_upload">
                    </td>

                    
                    <td>
                        {{-- @if (empty($p->award_letter_no)) --}}
                             <button class="btn btn-sm btn-success saveAwardBtn"
                                data-id="{{ $p->id }}">
                            Save
                        </button>
                        {{-- @else
                        <span class="badge bg-success">Saved</span>
                        @endif --}}
                       
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

    formData.append(
        'date_ofstartof_work',
        row.find('.date_ofstartof_work').val()
    );

    formData.append(
        'agreement_no',
        row.find('.agreement_no').val()
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
                window.location.reload();
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



$(document).on('change', '.award_date', function () {

    let awardDateInput = $(this);
    let row = awardDateInput.closest('tr');
    let startDateInput = row.find('.date_ofstartof_work');

    if (!awardDateInput.val()) return;

    let awardDate = new Date(awardDateInput.val());
    awardDate.setDate(awardDate.getDate() + 1); // +1 day

    let yyyy = awardDate.getFullYear();
    let mm = String(awardDate.getMonth() + 1).padStart(2, '0');
    let dd = String(awardDate.getDate()).padStart(2, '0');

    let nextDay = `${yyyy}-${mm}-${dd}`;

    // set value + minimum selectable date
    startDateInput.val(nextDay);
    startDateInput.attr('min', nextDay);
});




</script>




@endpush



{{ $projects->links() }}

@endsection
