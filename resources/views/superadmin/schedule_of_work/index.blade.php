{{-- TABLE --}}
<div class="mt-4">
<h4>Schedule Of Work</h4>
@if(isset($schedule_works) && $schedule_works->count() > 0)
<div class="table-responsive">
    <table id="scheduleTable" class="table class-table table-bordered nowrap" style="width:100%">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Unit</th>
                <th>Rate</th>
                <th>Amount</th>
                <th>Measured Qty</th>
                
            </tr>
        </thead>
        <tbody >
            @foreach ($schedule_works as $i => $w)
                <tr >
                    <td>{{ $i+1 }}</td>

                    <td>
                            {{ $w->description }}
                    </td>
                   

                    <td>
                            {{ $w->quantity }}
                    </td>

                    <td>
                        {{ $w->unit }}
                    </td>

                    <td>
                        {{ $w->rate }}
                    </td>

                    <td class="amount text-center">
                        {{ number_format($w->amount,2) }}
                    </td>

                    <td>
                        {{ $w->measured_quantity }}
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
    new DataTable('#scheduleTable', {
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