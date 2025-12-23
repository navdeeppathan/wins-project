@extends('layouts.admin')

@section('title','Schedule of Work')

@section('content')
<div class="container">
    <h4 class="mb-3">Schedule of Work #{{ $project->name }}</h4>

    <div class="table-responsive">
        <table id="workTable" class="table table-sm table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Description *</th>
                    <th>Qty *</th>
                    <th>Unit *</th>
                    <th>Rate *</th>
                    <th>Amount</th>
                    <th width="120">Action</th>
                </tr>
            </thead>
            <tbody>

@foreach($works as $section => $items)

{{-- SECTION HEADER --}}
<tr class="table-secondary fw-bold">
    <td colspan="7">{{ strtoupper($section ?? 'GENERAL WORK') }}</td>
</tr>

@foreach($items as $index => $work)
<tr data-id="{{ $work->id }}">
    <td>{{ $loop->iteration }}</td>
    <td><textarea class="form-control description">{{ $work->description }}</textarea></td>
    <td><input type="number" class="form-control quantity" value="{{ $work->quantity }}"></td>
    <td><input type="number" class="form-control unit" value="{{ $work->unit }}"></td>
    <td><input type="number" class="form-control rate" value="{{ $work->rate }}"></td>
    <td class="amount">₹ {{ number_format($work->amount,2) }}</td>
    <td>
        <button class="btn btn-success btn-sm saveRow">Save</button>
    </td>
</tr>
@endforeach

{{-- SUBTOTAL --}}
<tr class="table-warning fw-bold">
    <td colspan="5" class="text-end">Subtotal ({{ $section }})</td>
    <td colspan="2">₹ {{ number_format($subtotals[$section],2) }}</td>
</tr>

@endforeach

{{-- GRAND TOTAL --}}
<tr class="table-dark fw-bold">
    <td colspan="5" class="text-end">GRAND TOTAL</td>
    <td colspan="2">₹ {{ number_format($grandTotal,2) }}</td>
</tr>

</tbody>

        </table>

        <button id="addRow" class="btn btn-primary btn-sm mt-2">
            + Add New Row
        </button>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function(){

    // ➕ Add Row
    $('#addRow').click(function(){
        let index = $('#workTable tbody tr').length + 1;

        let row = `
        <tr>
            <td>${index}</td>
            <td><textarea class="form-control description"></textarea></td>
            <td><input type="number" step="0.01" class="form-control quantity"></td>
            <td><input type="number" step="0.01" class="form-control unit" value="1"></td>
            <td><input type="number" step="0.01" class="form-control rate"></td>
            <td class="amount">₹ 0.00</td>
            <td>
                <button class="btn btn-success btn-sm saveRow">Save</button>
                <button class="btn btn-danger btn-sm removeRow">Del</button>
            </td>
        </tr>`;
        $('#workTable tbody').append(row);
    });

    // 🧮 Auto calculate amount (Qty × Rate × Unit)
    $(document).on('input', '.quantity, .rate, .unit', function(){
        let row = $(this).closest('tr');

        let qty  = parseFloat(row.find('.quantity').val()) || 0;
        let rate = parseFloat(row.find('.rate').val()) || 0;
        let unit = parseFloat(row.find('.unit').val()) || 1;

        let amount = qty * rate * unit;
        row.find('.amount').text('₹ ' + amount.toFixed(2));
    });

    // 💾 Save Row (AJAX)
    $(document).on('click','.saveRow',function(){
        let row = $(this).closest('tr');
        let id = row.data('id') || null;

        let data = {
            _token: "{{ csrf_token() }}",
            project_id: "{{ $project->id }}",
            description: row.find('.description').val(),
            quantity: row.find('.quantity').val(),
            unit: row.find('.unit').val(),
            rate: row.find('.rate').val()
        };

        $.post(
            id ? `/admin/schedule-work/${id}`
               : "{{ route('admin.schedule-work.store') }}",
            data,
            function(){
                if(!id){
                    location.reload();
                } else {
                    alert('Updated successfully');
                }
            }
        );
    });

    // ❌ Delete Row
    $(document).on('click','.removeRow',function(){
        let row = $(this).closest('tr');
        let id = row.data('id');

        if(id){
            if(confirm('Delete this item?')){
                $.post(`/admin/schedule-work/${id}/destroy`,
                    {_token:"{{ csrf_token() }}"},
                    function(){
                        row.remove();
                    }
                );
            }
        } else {
            row.remove();
        }
    });

});
</script>
@endpush

@endsection
