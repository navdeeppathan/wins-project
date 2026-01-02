@extends('layouts.admin')

@section('title','Projects')

@section('content')





<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Projects (Milestone) </h3>
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
                <th>Estimate Amount</th>
                <th>Tendered Amount</th>
                <th>Date of Opening</th>
                <th width="160">Actions</th>
            </tr>
        </thead>
        <tbody>
             @php
                $i=1;
            @endphp
            @forelse($projects as $p)
                <tr>
                    <td>{{ $i }}</td>
                    <td>
                        {!! implode('<br>', array_map(
                            fn($chunk) => implode(' ', $chunk),
                            array_chunk(explode(' ', $p->name), 10)
                        )) !!}
                    </td>
                    <td>{{ $p->nit_number }}</td>
                     <td>{{  $p->state->name ?? '-' }}</td>
                    <td>{{  $p->departments->name ?? '-' }}</td> 
                    <td>{{ number_format($p->estimated_amount,2) }}</td>
                    <td>{{ number_format($p->tendered_amount,2) }}</td>
                    <td>{{ date('d-m-Y', strtotime($p->date_of_opening)) ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.activities.index2', $p) }}" class="btn btn-sm btn-warning">Add Milestone</a>
                    </td>
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
$(document).on('click', '.saveQualifiedBtn', function () {

    let id = $(this).data('id');
    let isQualified = $(this).closest('tr').find('.isQualifiedBox').is(':checked') ? 1 : 0;

    $.ajax({
        url: "/admin/projects/update-qualified/" + id,
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
