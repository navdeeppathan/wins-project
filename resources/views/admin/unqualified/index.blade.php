@extends('layouts.admin')

@section('title','Projects')

@section('content')


<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Projects (Unqualified)</h3>
</div>

<div class="table-responsive">
    <table id="example" class="table table-striped nowrap" style="width:100%">

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
        <th>Return</th>
        <th>Save</th>
            <th>Status</th>
            {{-- <th width="160">Actions</th> --}}
        </tr>
    </thead>
    <tbody>
        @forelse($projects as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->name }}</td>
                <td>{{ $p->nit_number }}</td>
                <td>{{ number_format($p->estimated_amount,2) }}</td>
                {{-- <td>{{ $p->date_of_opening }}</td> --}}
                 <td>{{ $p->location }}</td>
                <td>{{ $p->department }}</td> 
                <td>{{ number_format($p->emds->sum('amount'),2) }}</td>
               <td>
                    @foreach($p->emds as $emd)
                        {{ $emd->instrument_type }}<br>
                    @endforeach
                </td>

                <td>
                    @foreach($p->emds as $emd)
                        {{ $emd->instrument_number }}<br>
                    @endforeach
                </td>

                <td>
                    @foreach($p->emds as $emd)
                        {{ $emd->instrument_date }}<br>
                    @endforeach
                </td>

                <td style="background:yellow;">
                        <input type="checkbox"
                            class="form-check-input isReturnedBox"
                            data-id="{{ $p->id }}"
                            {{ $p->isReturned ? 'checked' : '' }}>
                    </td>

                <!-- SAVE BUTTON -->
                <td style="background:yellow;">
                    <button class="btn btn-sm btn-success saveisReturnedBtn"
                            data-id="{{ $p->id }}">
                        Save
                    </button>
                </td>
                
                <td><span class="badge bg-info">{{ ucfirst($p->status) }}</span></td>
               
            </tr>
        @empty
            <tr><td colspan="8" class="text-center">No projects yet.</td></tr>
        @endforelse
    </tbody>
</table>
</div>


@push('scripts')
<script>
$(document).on('click', '.saveisReturnedBtn', function () {

    let id = $(this).data('id');
    let isReturned = $(this).closest('tr').find('.isReturnedBox').is(':checked') ? 1 : 0;

    $.ajax({
        url: "/admin/projects/update-returned/" + id,
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
@endpush

{{ $projects->links() }}




@endsection
