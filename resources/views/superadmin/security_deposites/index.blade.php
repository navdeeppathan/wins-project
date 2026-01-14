

<h3 class="mb-3">Security Deposits</h3>
@if(isset($securityDeposits) && $securityDeposits->count() > 0)
<div class="table-responsive">
    <table class="table table-bordered nowrap class-table" id="securityTable" style="width:100%">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Instrument Type</th>
                <th>Instrument Number</th>
                <th>Instrument Date</th>
                <th>Amount</th>
                <th>Upload</th>
            
            </tr>
        </thead>

        <tbody id="securityBody">
            @forelse($securityDeposits as $index => $p)
                <tr>
                    <td>{{ $index+1 }}</td>

                    <td>
                        {{ $p->instrument_type }}
                    </td>

                    <td>{{ $p->instrument_number }}</td>
                <td>
                        {{ $p->instrument_date ? \Carbon\Carbon::parse($p->instrument_date)->format('Y-m-d') : '' }}
                    </td>

                    <td>{{ $p->amount }}</td>

                    <td>
                        @if($p->upload)
                            <a href="{{ Storage::url($p->upload) }}"
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



@push('scripts')
<script>
    new DataTable('#recoveryTable', {
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


