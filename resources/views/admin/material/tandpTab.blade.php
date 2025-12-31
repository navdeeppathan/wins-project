{{-- @extends('layouts.admin')

@section('title', 'Inventory')

@section('content') --}}


   
    



<div class="table-responsive">
<table id="measuredTable" class="table class-table nowrap" style="width:100%">
    <thead class="">
    <tr>
        <th>#</th>
        <th>Description</th>
        <th>T&P</th>
        <th>Dismantals</th>
        <th width="">Action</th>
       
    </tr>
    </thead>

    <tbody>
    @forelse($schedules as $index => $i)
        <tr data-id="{{ $i->id }}">
            <td>{{ $index + 1 }}</td>

            

            <td>{{ $i->description }}</td>

            <td>{{ $i->quantity }}</td>

            

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
                No records found
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

    let scheduleId = btn.data('id');

    let formData = new FormData();
    formData.append('_method', 'PUT'); // spoof PUT
    formData.append('_token', "{{ csrf_token() }}");

    formData.append(
        'dismantals',
        row.find('.dismantals').val()
    );

    

    btn.prop('disabled', true).text('Saving...');

    $.ajax({
        url: "/admin/projects/" + scheduleId + "/schedule-update",
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

  new DataTable('#measuredTable', {
        scrollX: true,
        scrollCollapse: true,
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

{{-- @endsection --}}


