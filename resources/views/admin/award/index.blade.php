@extends('layouts.admin')

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
                <th class="text-center">#</th>
                <th class="text-center">Name</th>
                <th class="text-center">Award Letter No.</th>
                <th class="text-center">Award Letter Date</th>
                <th class="text-center">Estimate Amt</th>
                <th class="text-center">Tendered Amount</th>
                <th class="text-center">Stipulated Date of Completion</th>
                <th class="text-center">Date of Start of Work</th>
                <th class="text-center">Agreement Number</th>
                <th class="text-center">Upload</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
             @php
                $i=1;
            @endphp
            @forelse($projects as $p)
            @if (!empty($p->award_letter_no))
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
                    <td>{{ $p->award_letter_no }}</td>
                    <td>{{ date('d-m-Y', strtotime($p->award_date)) ?? '-' }}</td>

                    <td>{{ number_format($p->estimated_amount,2) }}</td>
                    <td>{{ number_format($p->tendered_amount,2) }}</td>
                    <td>
                        <input type="date"
                            class="form-control form-control-sm stipulated_date_ofcompletion"
                            value="{{ $p->stipulated_date_ofcompletion }}">

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



                    {{-- <td>
                        <input type="date"
                            class="form-control form-control-sm agreement_start_date"
                            value="{{ $p->agreement_start_date }}">
                    </td> --}}
                    {{-- <td>
                        {{ date('d-m-Y', strtotime($p->stipulated_date_ofcompletion)) ?? '-' }}

                    </td> --}}
                    <td>
                        @if($p->agreement_upload)
                            <a href="{{ Storage::url($p->agreement_upload) }}"
                            target="_blank"
                            class="btn btn-sm btn-outline-primary mb-1">
                                View
                            </a>
                        @endif
                        <input type="file"
                            class="form-control form-control-sm agreement_upload">
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-success saveAwardBtn"
                                    data-id="{{ $p->id }}">
                                Save
                            </button>
                            <a href="{{ route('admin.projects.correspondence', $p->id) }}" class="btn btn-sm btn-primary"> + NOTE</a>
                            <a href="{{ route('admin.activities.index2', $p) }}" class="btn btn-sm btn-primary"> Milestone</a>
                        </div>

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
        'agreement_no',
        row.find('.agreement_no').val()
    );

    // formData.append(
    //     'agreement_start_date',
    //     row.find('.agreement_start_date').val()
    // );

    formData.append(
        'stipulated_date_ofcompletion',
        row.find('.stipulated_date_ofcompletion').val()
    );

    formData.append(
        'date_ofstartof_work',
        row.find('.date_ofstartof_work').val()
    )



    let fileInput = row.find('.agreement_upload')[0];
    if (fileInput.files.length > 0) {
        formData.append('agreement_upload', fileInput.files[0]);
    }

    btn.prop('disabled', true).text('Saving...');

    $.ajax({
        url: "/admin/projects/" + projectId + "/agreement-update",
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
