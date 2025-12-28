@if($actives->count() > 0)
<div class="table-responsive">
    <table id="pgactive" class="table class-table nowrap" style="width:100%">
        <thead >
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>NIT No</th>
                <th>Estimate Amount</th>
                <th>Date of Opening</th>
                <th>Location</th>
                <th>Department</th>
                <th>EMD Amount</th>
                <th>Instrument Type</th>
                <th>Instrument Number</th>
                <th>Instrument Date</th>
                <th>Return</th>
                <th>Save</th>

                <th>Forfieted</th>
                <th>Save</th>

            </tr>
        </thead>
        <tbody>
            @forelse($actives as $emd)
                <tr>
                    <td>{{ $project->id }}</td>
                    <td>{{  $project->name }}</td>
                    <td>{{  $project->nit_number }}</td>
                    <td>{{ number_format( $project->estimated_amount,2) }}</td>
                    <td>{{ date('d-m-y', strtotime($project->date_of_opening)) ?? "-" }}</td>
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
                        </td>

                    <!-- SAVE BUTTON -->
                    <td style="background:yellow;">
                        <button class="btn btn-sm btn-success saveisReturnedBtn"
                                data-id="{{ $emd->id }}">
                            Save
                        </button>
                    </td>

                    <td style="background:yellow;">
                            <input type="checkbox"
                                class="form-check-input isForfietedBox"
                                data-id="{{ $emd->id }}"
                                {{ $emd->isForfieted ? 'checked' : '' }}>
                    </td>

                    <!-- SAVE BUTTON -->
                    <td style="background:yellow;">
                        <button class="btn btn-sm btn-success saveisForfietedBtn"
                                data-id="{{ $emd->id }}">
                            Save
                        </button>
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

$(document).on('click', '.saveisReturnedBtn', function () {

    let id = $(this).data('id');
    let isReturned = $(this).closest('tr').find('.isReturnedBox').is(':checked') ? 1 : 0;

    $.ajax({
        url: "/staff/projects/update-pgreturned/" + id,
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


$(document).on('click', '.saveisForfietedBtn', function () {

    let id = $(this).data('id');
    let isForfieted = $(this).closest('tr').find('.isForfietedBox').is(':checked') ? 1 : 0;

    $.ajax({
        url: "/staff/projects/update-pgforfieted/" + id,
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

new DataTable('#pgactive', {
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