@extends('layouts.staff')

@section('title','Projects')

@section('content')





<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Projects (PG Forfieted)</h3>
    {{-- <a href="{{ route('staff.projects.create') }}" class="btn btn-primary">+ Create Project</a> --}}
</div>
@if($projects->count() > 0)

<div class="table-responsive">
    <table id="example" class="table table-striped nowrap" style="width:100%">
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

            
                {{-- <th>Status</th> --}}

                <th width="160">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($projects as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->nit_number }}</td>
                    <td>{{ number_format($p->estimated_amount,2) }}</td>
                    <td>{{ $p->date_of_opening }}</td>
                    <td>{{  $p->state->name ?? '-' }}</td>
                    <td>{{  $p->departments->name ?? '-' }}</td> 
                    <td>{{ number_format($p->emds->sum('amount'),2) }}</td>


                    
                    {{-- <td><span class="badge bg-info">{{ ucfirst($p->status) }}</span></td> --}}

                    <td>
                        <a href="{{ route('staff.projects.pgforfieted.create', $p) }}" class="btn btn-sm btn-warning">Edit</a>
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
$(document).on('click', '.saveQualifiedBtn', function () {

    let id = $(this).data('id');
    let isQualified = $(this).closest('tr').find('.isQualifiedBox').is(':checked') ? 1 : 0;

    $.ajax({
        url: "/staff/projects/update-qualified/" + id,
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            isQualified: isQualified,
        },
        success: function (response) {
            alert("Updated Successfully");
        }
    });

});
</script>
@endpush

{{ $projects->links() }}




@endsection
