{{-- @extends('layouts.admin')

@section('title','Projects')

@section('content')


<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Projects (Withheld Forfieted)</h3>
</div> --}}

@if($forfieteds->count() > 0)
<div class="table-responsive">
    <table id="withheldforfieted" class="table table-striped nowrap" style="width:100%">
        <thead >
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>NIT No</th>
                <th>Estimate Amount</th>
                {{-- <th>Date of Opening</th> --}}
                <th>Location</th>
                <th>Department</th>
                <th>EMD Amount</th>
                <th>Instrument Type</th>
                <th>Instrument Number</th>
                <th>Instrument Date</th>
                


                <!-- NEW COLUMNS -->
                <th>Forfieted</th>
                <th>Save</th>
                {{-- <th>Status</th> --}}

                {{-- <th width="160">Actions</th> --}}
            </tr>
        </thead>
        <tbody>
             @php
                $i=1;
            @endphp
            @forelse($forfieteds as $emd)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{  $project->name }}</td>
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
                                class="form-check-input isForfietedBox"
                                data-id="{{ $emd->id }}"
                                {{ $emd->isForfeited ? 'checked' : '' }}>
                        </td>

                    <!-- SAVE BUTTON -->
                    <td style="background:yellow;">
                        <button class="btn btn-sm btn-success saveisForfietedBtn"
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
$(document).on('click', '.saveisForfietedBtn', function () {

    let id = $(this).data('id');
    let isForfieted = $(this).closest('tr').find('.isForfietedBox').is(':checked') ? 1 : 0;

    $.ajax({
        url: "/admin/projects/update-withheldforfieted/" + id,
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            isForfieted: isForfieted,
        },
        success: function (response) {
            alert("Updated Successfully");
        }
    });

});
new DataTable('#withheldforfieted', {
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
