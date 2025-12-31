
<style>
    /* 🔥 Allow full width inputs */
    #emdactive input.form-control,
    #emdactive select.form-select {
        min-width: 180px;
        width: 100%;
    }

    /* 🔥 Paid To & Narration extra wide */
    #emdactive td:nth-child(3) input,
    #emdactive td:nth-child(5) input {
        min-width: 250px;
    }

    /* 🔥 Disable text cutting */
    #emdactive input,
    #emdactive select {
        white-space: nowrap;
        overflow-x: auto;
    }

    /* 🔥 Horizontal scroll inside input */
    #emdactive input {
        text-overflow: clip;
    }

    /* Optional: show scrollbar only when needed */
    #emdactive input::-webkit-scrollbar {
        height: 6px;
    }
</style>

@if($actives->count() > 0)
    <div class="table-responsive">
        <table id="emdactive" class="table table-striped nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>NIT No</th>
                    <th>Estimate Amount</th>
                    <th>Location</th>
                    <th>Department</th>
                    <th>EMD Amount</th>
                    <th>Instrument Type</th>
                    <th>Instrument Number</th>
                    <th>Instrument Date</th>
                    <th>Return</th>
                    <th>Save</th>
                    <th>Forfeited</th>
                    <th>Save</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>

            @forelse($actives as $project)
                @foreach($project->emds as $emd)
                    <tr>
                        <td>{{ $project->id }}</td>

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

                        {{-- Returned --}}
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

                        {{-- Forfeited --}}
                        <td style="background:yellow;">
                            <input type="checkbox"
                                class="form-check-input isForfietedBox"
                                data-id="{{ $emd->id }}"
                                {{ $emd->isForfieted ? 'checked' : '' }}>
                        </td>

                        <td style="background:yellow;">
                            <button class="btn btn-sm btn-success saveisForfietedBtn"
                                data-id="{{ $emd->id }}">
                                Save
                            </button>
                        </td>

                        <td>
                            <span class="badge bg-info">
                                {{ ucfirst($project->status) }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="15" class="text-center">No projects yet.</td>
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

    $(document).on('click', '.saveisForfietedBtn', function () {

        let id = $(this).data('id');
        let isForfieted = $(this).closest('tr').find('.isForfietedBox').is(':checked') ? 1 : 0;

        $.ajax({
            url: "/admin/projects/update-forfieted/" + id,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                isForfieted: isForfieted,
            },
            success: function (response) {
                alert("Updated Successfully");
                location.reload();
            }
        });

    });

    new DataTable('#emdactive', {
        scrollX: true,
        responsive: false,
        autoWidth: false,
         /* 🔥 GUARANTEED ROW COLOR FIX */
        createdRow: function (row, data, index) {
            let bg = (index % 2 === 0) ? '#f7f8ff' : '#ffffff';
            $('td', row).css('background-color', bg);
        },

        rowCallback: function (row, data, index) {
            let base = (index % 2 === 0) ? '#f7f8ff' : '#ffffff';

            $(row).off('mouseenter mouseleave').hover(
                () => $('td', row).css('background-color', '#e9ecff'),
                () => $('td', row).css('background-color', base)
            );
        }
    });
</script>
@endpush
