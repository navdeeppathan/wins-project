{{-- @extends('layouts.admin')

@section('title','Projects')

@section('content')


<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Projects (Security Deposit Returned)</h3>
</div> --}}

@if($returneds->count() > 0)
<div class="table-responsive">
    <table id="securityreturn" class="table table-striped nowrap" style="width:100%">
        <thead >
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>NIT No</th>
                <th>Estimate Amt</th>
                {{-- <th>Date of Opening</th> --}}
                <th>Location</th>
                <th>Department</th>
                <th>EMD Amt</th>
                <th>Instrument Type</th>
                <th>Instrument Number</th>
                <th>Instrument Date</th>



                <!-- NEW COLUMNS -->
                <th>Return</th>
                {{-- <th>Status</th> --}}

                {{-- <th width="160">Actions</th> --}}
            </tr>
        </thead>
        <tbody>
             @php
                $i=1;
            @endphp
            @forelse($returneds as $emd)
                <tr>
                    <td>{{ $i }}</td>

                     <td>
                        {!! implode('<br>', array_map(
                            fn($chunk) => implode(' ', $chunk),
                            array_chunk(explode(' ', $project->name), 10)
                        )) !!}
                    </td>
                    <td>{{  $project->nit_number }}</td>
                    <td>{{ number_format( $project->estimated_amount,2) }}</td>
                    {{-- <td>{{ $p->date_of_opening }}</td> --}}
                    <td>{{  $project->state->name ?? '-' }}</td>
                    <td>{{  $project->departments->name ?? '-' }}</td>
                    <td>{{  number_format( $emd->amount,2) }}</td>
                    <td>

                            {{ $emd->instrument_type }}<br>

                    </td>

                    <td>

                            {{ $emd->instrument_number }}<br>

                    </td>

                    <td>

                            {{ $emd->instrument_date }}<br>

                    </td>

                    <td style="background:yellow;">
                            <input type="checkbox"
                                class="form-check-input isReturnedBox"
                                data-id="{{ $emd->id }}"
                                {{ $emd->isReturned ? 'checked' : '' }}>
                            &nbsp;&nbsp;
                        <button class="btn btn-sm btn-success saveisReturnedBtn"
                                data-id="{{ $emd->id }}">
                            Save
                        </button>
                    </td>

                    <td><span class="badge bg-info">{{ ucfirst($project->status) }}</span></td>

                </tr>
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
$(document).on('click', '.saveisReturnedBtn', function () {

    let id = $(this).data('id');
    let isReturned = $(this).closest('tr').find('.isReturnedBox').is(':checked') ? 1 : 0;

    $.ajax({
        url: "/admin/projects/update-securityreturned/" + id,
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            isReturned: isReturned,
        },
        success: function (response) {
            alert("Updated Successfully");
        }
    });

});

new DataTable('#securityreturn', {
    scrollX: true,
    responsive: false,
    autoWidth: false,
    // layout: {
    //     topStart: {
    //         buttons: ['copy', 'excel', 'pdf', 'print']
    //     }
    // }
});
</script>
@endpush

{{-- {{ $emdDetails->links() }} --}}




{{-- @endsection --}}
