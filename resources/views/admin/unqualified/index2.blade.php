@if($returneds->count() > 0)
<div class="table-responsive">
    <table id="emdreturned" class="table table-striped nowrap" style="width:100%">
        <thead>
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
                <th>Returned</th>
                <th>Save</th>
            </tr>
        </thead>
        <tbody>

        @php $i = 1; @endphp

        @forelse($returneds as $project)
            @foreach($project->emds as $emd)
                @if($emd->isReturned)
                <tr>
                    <td>{{ $i++ }}</td>

                    <td>
                        {!! implode('<br>', array_map(
                            fn($chunk) => implode(' ', $chunk),
                            array_chunk(explode(' ', $project->name), 10)
                        )) !!}
                    </td>

                    <td>{{ $project->nit_number }}</td>
                    <td>{{ number_format($project->estimated_amount, 2) }}</td>
                    <td>{{ $project->state->name ?? '-' }}</td>
                    <td>{{ $project->department->name ?? '-' }}</td>

                    <td>{{ number_format($emd->amount, 2) }}</td>
                    <td>{{ $emd->instrument_type }}</td>
                    <td>{{ $emd->instrument_number }}</td>
                    <td>{{ date('d-m-Y', strtotime($emd->instrument_date)) }}</td>

                    <td style="background:yellow;">
                        <input type="checkbox"
                            class="form-check-input isReturnedBox"
                            data-id="{{ $emd->id }}"
                            checked>
                    </td>

                    <td style="background:yellow;">
                        <button class="btn btn-sm btn-success saveisReturnedBtn"
                            data-id="{{ $emd->id }}">
                            Save
                        </button>
                    </td>
                </tr>
                @endif
            @endforeach
        @empty
            <tr>
                <td colspan="12" class="text-center">No returned EMDs found.</td>
            </tr>
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
            url: "/admin/projects/update-returned/" + id,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                isReturned: isReturned,
            },
            success: function (response) {
                alert("Updated Successfully");
                location.reload();
            }
        });

    });

    new DataTable('#emdreturned', {
            scrollX: true,
            scrollCollapse: true,
            responsive: false,
            autoWidth: false,


            /* 🔥 GUARANTEED ROW COLOR FIX */
            createdRow: function (row, data, index) {
                let bg = (index % 2 === 0) ? '#D7E2F2' : '#B4C5E6';
                $('td', row).css('background-color', bg);
            },

            rowCallback: function (row, data, index) {
                 let base = (index % 2 === 0) ? '#D7E2F2' : '#B4C5E6';

                $(row).off('mouseenter mouseleave').hover(
                    () => $('td', row).css('background-color', '#e9ecff'),
                    () => $('td', row).css('background-color', base)
                );
            }
    });
</script>
@endpush
