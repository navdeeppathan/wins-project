
<div class="d-flex justify-content-between align-items-center ">
    <h3 class="mb-3">Departments</h3>
</div>
    {{-- Table --}}
  @if($departments->count() > 0)
    <div class="card dept-card shadow-sm">
        <div class="table-responsive">
            <table id="department" class="table class-table nowrap " style="width:100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Department</th>
                        <th>Contact Person</th>
                        <th>Designation</th>
                        <th>Contact No.</th>
                        <th>Email</th>
                      
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i=1;
                    @endphp
                    @foreach($departments as $dept)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $dept->name }}</td>
                        <td>
                            {{ $dept->contact_person_name }}
                        </td>

                        <td>
                            {{ $dept->contact_person_designation }}
                        </td>

                        <td>
                            {{ $dept->contact_number }}
                        </td>

                        <td>
                            {{ $dept->email_id ?? '-' }}
                        </td>
                       
                    </tr>
                    @php
                        $i++;
                    @endphp
                    

                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="alert alert-warning text-center">
        Data is not available.
    </div>
  @endif


@push('scripts')
<script>
new DataTable('#department', {
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