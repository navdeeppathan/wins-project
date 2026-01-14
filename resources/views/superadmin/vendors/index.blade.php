
<div class="d-flex justify-content-between align-items-center ">
    <h3 class="mb-3">All Vendors</h3>
</div>

@if(isset($vendors) && $vendors->count() > 0)

<div class="table-responsive">
    <table id="vendor" class="table class-table nowrap" style="width:100%">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">State</th>
                <th class="text-center">Vendor Agency</th>
                <th class="text-center">Contact Person</th>
                <th class="text-center">Contact No</th>
                <th class="text-center">Email</th>
                <th class="text-center">GST</th>
                
            </tr>
        </thead>

        <tbody>
        @foreach($vendors as $i => $v)
            <tr>
                <td class="text-center">{{ $i+1 }}</td>
                <td class="text-center">{{ $v->state }}</td>
                <td class="text-center">{{ $v->vendor_agency_name }}</td>
                <td class="text-center">{{ $v->contact_person }}</td>
                <td class="text-center">{{ $v->contact_number }}</td>
                <td class="text-center">{{ $v->email_id }}</td>
                <td class="text-center">{{ $v->gst_number }}</td>
                
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@else
    <div class="alert alert-warning text-center">No vendors found</div>
@endif



@push('scripts')
<script>
new DataTable('#vendor', {
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


