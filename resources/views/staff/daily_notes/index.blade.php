@extends('layouts.staff')

@section('title','Daily Notes')

@section('content')
<h3 class="mb-3">Daily Notes</h3>

<div class="row">
    <div class="col-md-12 mb-3">
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
                @forelse($notes as $index => $note)
                    <tr data-id="{{ $note->id }}">
                        <td>{{ $index+1 }}</td>
                        <td><input type="text" class="form-control paid_to" value="{{ $note->paid_to }}"></td>
                        <td><input type="text" class="form-control amount" value="{{ $note->amount }}"></td>
                        <td><input type="text" class="form-control note_text" value="{{ $note->note_text }}"></td>
                        
                        <td>
                            <button class="btn btn-success btn-sm saveRow">Save</button>
                            
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td>1</td>
                        <td><input type="text" class="form-control paid_to"></td>
                        <td><input type="text" class="form-control amount"></td>
                        <td><input type="text" class="form-control note_text"></td>
                        
                        <td>
                            <button class="btn btn-success btn-sm saveRow">Save</button>
                        </td>
                    </tr>
                @endforelse

            </tbody>

        </table>
    </div>
        <button id="addRow" class="btn btn-primary btn-sm mt-2">+ Add New Row</button>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {

    // Add new empty row
 $('#addRow').click(function() {
    let index = $('#dailyNotesTable tbody tr').length + 1;
    let today = new Date().toISOString().split('T')[0];

    let newRow = `<tr>
        <td>${index}</td>
        <td><input type="text" class="form-control paid_to"></td>
        <td><input type="text" class="form-control amount"></td>
        <td><input type="text" class="form-control note_text"></td>
        
        <td>
            <button class="btn btn-success btn-sm saveRow">Save</button>
            <button class="btn btn-danger btn-sm removeRow">Del</button>
        </td>
    </tr>`;

    $('#dailyNotesTable tbody').append(newRow);
});



    // Save row via AJAX
    $(document).on('click', '.saveRow', function() {
        let row = $(this).closest('tr');
        let id = row.data('id') || null;
        let data = {
            _token: "{{ csrf_token() }}",
            note_date: row.find('.note_date').val(),
            note_text: row.find('.note_text').val(),
            amount: row.find('.amount').val(),
            paid_to: row.find('.paid_to').val()
        };

        $.post(id ? `/staff/daily-notes/${id}/update` : "{{ route('staff.daily-notes.store') }}", data, function(res){
            if(!id) {
                // Reload page to get new id, or set row.data('id', res.id)
                location.reload();
            } else {
                alert('Updated successfully');
            }
        });
    });

    // Remove row
    $(document).on('click', '.removeRow', function() {
        let row = $(this).closest('tr');
        let id = row.data('id');
        if(id) {
            if(confirm('Delete this note?')) {
                $.ajax({
                    url: `/staff/daily-notes/${id}/destroy`,
                    type: 'POST',
                    data: {_token: "{{ csrf_token() }}"},
                    success: function() { row.remove(); }
                });
            }
        } else {
            row.remove(); // just remove unsaved row
        }
    });

});

  new DataTable('#dailynotesTable', {
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

@endsection
