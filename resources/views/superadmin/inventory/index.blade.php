

<h3 class="mb-3">Inventories</h3>

<style>
    #inventoryTable {
        width: 100%;
    }
    #inventoryTable td, 
    #inventoryTable th {
        white-space: nowrap;
        vertical-align: middle;
    }
</style>

@if(isset($inventories) && $inventories->count() > 0)

<div class="table-responsive">
<table id="inventoryTable" class="table table-bordered class-table  table-striped nowrap">
    <thead class="">
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Category</th>
            <th>Description</th>
            <th>Qty</th>
            <th>Rate</th>
            <th>Net Amount</th>
        </tr>
    </thead>

    <tbody>
        @foreach($inventories as $index => $i)
            <tr>
                <td>{{ $index + 1 }}</td>

                <td>
                    {{ $i->date ? \Carbon\Carbon::parse($i->date)->format('d-m-Y') : '-' }}
                </td>

                


                <td>{{ $i->category }}</td>

                

                <td>{{ $i->description }}</td>

                <td>{{ $i->quantity }}</td>

                <td>{{ number_format($i->amount, 2) }}</td>

                <td>{{ number_format($i->net_payable, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>

@else
<div class="alert alert-warning text-center">
    No inventory data found.
</div>
@endif




@push('scripts')
<script>
new DataTable('#inventoryTable', {
    scrollX: true,
    scrollY: 600,
    paging: true,
    responsive: false,
    autoWidth: false,
    fixedHeader: true,

    createdRow: function (row, data, index) {
        let bg = (index % 2 === 0) ? '#D7E2F2' : '#B4C5E6';
        $('td', row).css('background-color', bg);
    },

    rowCallback: function (row, data, index) {
        let base = (index % 2 === 0) ? '#D7E2F2' : '#B4C5E6';

        $(row).hover(
            () => $('td', row).css('background-color', '#e9ecff'),
            () => $('td', row).css('background-color', base)
        );
    }
});
</script>
@endpush
