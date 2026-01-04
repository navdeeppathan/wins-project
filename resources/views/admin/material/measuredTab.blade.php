<div class="table-responsive">
    <table id="example" class="table class-table nowrap" style="width:100%">
        <thead class="">
        <tr>
            <th>#</th>
            <th>Description</th>
            <th>Stores</th>
            <th>Measured</th>
            <th>Dismantals</th>
            <th width="">Action</th>

        </tr>
        </thead>

        <tbody>
        @forelse($items as $index => $i)
            <tr data-id="{{ $i->id }}">
                <td>{{ $index + 1 }}</td>



                <td>{{ $i->description }}</td>

                <td>{{ $i->quantity }}</td>

                <td>{{$i->scheduleOfWorks->sum('measured_quantity')}}</td>

                <td>
                            <input type="number" step="0.01"
                                class="form-control form-control-sm dismantals"
                                value="{{ $i->dismantals }}" required>
                </td>

                <td>
                            <button class="btn btn-sm btn-success saveDismantalBtn"
                                    data-id="{{ $i->id }}">
                                Save
                            </button>
                </td>

            </tr>
        @empty
            <tr>
                <td colspan="13" class="text-center text-muted">
                    No inventory records found
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

@push('scripts')
<script>
    $(document).on('click', '.saveDismantalBtn', function () {

        let btn = $(this);
        let row = btn.closest('tr');

        let dismantals = row.find('.dismantals').val();


        if (!dismantals) {
            alert('Please fill all required fields');
            return;
        }

        let inventoryId = btn.data('id');

        let formData = new FormData();
        formData.append('_method', 'PUT'); // spoof PUT
        formData.append('_token', "{{ csrf_token() }}");

        formData.append(
            'dismantals',
            row.find('.dismantals').val()
        );



        btn.prop('disabled', true).text('Saving...');

        $.ajax({
            url: "/admin/projects/" + inventoryId + "/inventory-update",
            type: "POST", // IMPORTANT
            data: formData,
            processData: false, // required for FormData
            contentType: false, // required for FormData
            success: function (response) {
                btn.prop('disabled', false).text('Save');

                if (response.success) {
                    window.location.reload();
                    alert(response.message);


                } else {
                    alert('Update failed');
                }
            },
            error: function (xhr) {
                btn.prop('disabled', false).text('Save');
                alert('Server error');
                console.error(xhr.responseText);
            }
        });
    });

    new DataTable('#storeTable', {
        scrollX: true,
        scrollCollapse: true,
        responsive: false,
        autoWidth: false,
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



