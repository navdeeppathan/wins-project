{{-- @if($emdDetails->count() > 0)
<div class="table-responsive">
    <table id="example" class="table table-striped nowrap" style="width:100%">
        <thead >
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>NIT No</th>
                <th>Estimate AMT</th>
               
                <th>Location</th>
                <th>Department</th>
                <th>EMD AMT</th>
                <th>Instrument Type</th>
                <th>Instrument Number</th>
                <th>Instrument Date</th>
                


                
                <th>Return</th>
                <th>Save</th>
                {{-- <th>Status</th> --}}

                
            </tr>
        </thead>
        <tbody>
            @forelse($emdDetails as $emd)
                <tr>
                    <td>{{ $project->id }}</td>
                    <td>{{  $project->name }}</td>
                    <td>{{  $project->nit_number }}</td>
                    <td>{{ number_format( $project->estimated_amount,2) }}</td>
                    
                    <td>{{  $project->state->name ?? '-' }}</td>
                    <td>{{  $project->department->name ?? '-' }}</td> 
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

                    
                    <td style="background:yellow;">
                        <button class="btn btn-sm btn-success saveisReturnedBtn"
                                data-id="{{ $emd->id }}">
                            Save
                        </button>
                    </td>
                    
                    <td><span class="badge bg-info">{{ ucfirst($project->status) }}</span></td>
                
                </tr>
            @empty
                <tr><td colspan="8" class="text-center">No projects yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@else --}}
    <div class="alert alert-warning text-center">
        Data is not available.
    </div>
{{-- @endif --}}


{{-- @push('scripts')
<script>
$(document).on('click', '.saveisReturnedBtn', function () {

    let id = $(this).data('id');
    let isReturned = $(this).closest('tr').find('.isReturnedBox').is(':checked') ? 1 : 0;

    $.ajax({
        url: "/staff/projects/update-returned/" + id,
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
</script>
@endpush --}}