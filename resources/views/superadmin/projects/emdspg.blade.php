
<h3 class="mb-3">EMD Details</h3>


@if(isset($emds) && $emds->count() > 0)
    <div class="table-responsive">
        <table id="emdTable" class="table class-table nowrap" style="width:100%">
            <thead class="table-light">
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Instrument Type</th>
                    <th class="text-center">Instrument No</th>
                    <th class="text-center">Instrument Date</th>
                    <th class="text-center">Amount *</th>
                    <th class="text-center">Upload</th>
                   
                </tr>
            </thead>
            <tbody>
                    @foreach($emds as $i => $emd)
                    <tr>
                        <td>{{ $i+1 }}</td>

                        <td>
                            {{$emd->instrument_type}}
                        </td>

                        <td>
                            {{ $emd->instrument_number }}
                        </td>

                        <td>
                           {{ $emd->instrument_date }}
                        </td>

                        <td>
                            {{ $emd->amount }}
                        </td>

                        <td>
                            @if(!empty($emd->upload))
                                <a href="{{ asset('storage/'.$emd->upload) }}"
                                target="_blank"
                                class="btn btn-sm btn-outline-primary mb-1">
                                View
                                </a>
                            @endif  
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="alert alert-warning text-center">
        No data found.
    </div>
@endif



{{-- PG DETAILS --}}
<div class="mt-4">
    <h4>PG Details</h4>

    @if(isset($pgs) && $pgs->count() > 0)
        <div class="table-responsive">
            <table id="example" class="table class-table nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>INSTRUMENT TYPE</th>
                        <th>INSTRUMENT NUMBER</th>
                        <th>INSTRUMENT DATE</th>
                        <th>INSTRUMENT VALID UPTO</th>
                        <th>INSTRUMENT AMOUNT</th>
                        <th>UPLOAD</th>
                        
                    </tr>
                </thead>

                <tbody >
                    @foreach($pgs as $i => $pg)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>
                                {{$pg->instrument_type}}
                            </td>

                            <td>{{ $pg->instrument_number }}</td>
                            <td>{{ $pg->instrument_date }}</td>
                            <td>{{ $pg->instrument_valid_upto }}</td>
                            <td>{{ $pg->amount }}</td>

                            <td>
                                @if($pg->upload)
                                    <a href="{{ asset('storage/'.$pg->upload) }}" target="_blank">View</a>
                                @endif
                            
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-warning text-center">
            No  data found.
        </div>
    @endif

</div>

@push('scripts')
<script>
    new DataTable('#emdTable', {
        retrieve: true,
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
