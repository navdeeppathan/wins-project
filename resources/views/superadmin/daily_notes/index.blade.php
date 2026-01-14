


<div class="mt-4">
    <h3 class="mb-3">Daily Notes</h3>
    @if(isset($notes) && $notes->count() > 0)
        <div class="table-responsive">
            <table class="table class-table nowrap" style="width:100%" id="dailynotesTable">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Paid To</th>
                        <th>Amount</th>
                        <th>Note *</th>
                        <th width="80">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($notes as $index => $note)
                        <tr >
                            <td>{{ $index+1 }}</td>
                            <td>{{ $note->paid_to }}</td>
                            <td>{{ $note->amount }}</td>
                            <td>{{ $note->note_text }}</td>
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
</div>

@push('scripts')
<script>

  new DataTable('#dailynotesTable', {
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

