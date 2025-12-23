@extends('layouts.admin')

@section('title','Inventory')

@section('content')
<h3 class="mb-3">Inventory</h3>
@php
    $selectedProjectId = request()->query('project_id'); // get ?project_id=10
@endphp

<div class="row">
    <div class="col-md-12 mb-3">
        <table id="inventoryTable" class="table table-sm table-bordered">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Project *</th>
                    <th>Item Name *</th>
                    <th>SKU</th>
                    <th>Quantity *</th>
                    <th>Vendor</th>
                    <th>Remarks</th>
                    <th width="80">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $index => $i)
                <tr data-id="{{ $i->id }}">
                    <td>{{ $index+1 }}</td>
                    <td>
                        @if($selectedProjectId)
                            <input type="hidden" class="project_id" value="{{ $selectedProjectId }}">
                            {{ $projects->firstWhere('id', $selectedProjectId)->name }}
                        @else
                            <select class="form-select project_id">
                                <option value="">Select Project</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" {{ old('project_id', $i->project_id) == $project->id ? 'selected' : '' }}>
                                        {{ $project->name }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                    </td>


                    <td><input type="text" class="form-control item_name" value="{{ $i->item_name }}"></td>
                    <td><input type="text" class="form-control sku" value="{{ $i->sku }}"></td>
                    <td><input type="number" step="0.01" class="form-control quantity" value="{{ $i->quantity }}"></td>
                    <td>
                        <select class="form-select vendor_id">
                            <option value="">Select Vendor</option>
                            @foreach($vendors as $vendor)
                                <option value="{{ $vendor->id }}" {{ $i->vendor_id == $vendor->id ? 'selected' : '' }}>
                                    {{ $vendor->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="text" class="form-control remarks" value="{{ $i->remarks }}"></td>
                    <td>
                        <button class="btn btn-success btn-sm saveRow">Save</button>
                        {{-- <button class="btn btn-danger btn-sm removeRow">Del</button> --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button id="addRow" class="btn btn-primary btn-sm mt-2">+ Add New Row</button>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {

    // Add new empty row
  let selectedProjectId = "{{ $selectedProjectId ?? '' }}";

$('#addRow').click(function() {
    let index = $('#inventoryTable tbody tr').length + 1;
    let newRow = `<tr>
        <td>${index}</td>
        <td>
            <select class="form-select project_id">
                <option value="">Select Project</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}" ${selectedProjectId == '{{ $project->id }}' ? 'selected' : ''}>
                        {{ $project->name }}
                    </option>
                @endforeach
            </select>
        </td>
        <td><input type="text" class="form-control item_name"></td>
        <td><input type="text" class="form-control sku"></td>
        <td><input type="number" step="0.01" class="form-control quantity"></td>
        <td>
            <select class="form-select vendor_id">
                <option value="">Select Vendor</option>
                @foreach($vendors as $vendor)
                    <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                @endforeach
            </select>
        </td>
        <td><input type="text" class="form-control remarks"></td>
        <td>
            <button class="btn btn-success btn-sm saveRow">Save</button>
            <button class="btn btn-danger btn-sm removeRow">Del</button>
        </td>
    </tr>`;
    $('#inventoryTable tbody').append(newRow);
});


    // Save row via AJAX
    $(document).on('click', '.saveRow', function() {
        let row = $(this).closest('tr');
        let id = row.data('id') || null;
        let data = {
            _token: "{{ csrf_token() }}",
            project_id: row.find('.project_id').val(),
            item_name: row.find('.item_name').val(),
            sku: row.find('.sku').val(),
            quantity: row.find('.quantity').val(),
            vendor_id: row.find('.vendor_id').val(),
            remarks: row.find('.remarks').val()
        };

        $.post(id ? `/admin/inventory/${id}/update` : "{{ route('admin.inventory.store') }}", data, function(res){
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
            if(confirm('Delete this item?')) {
                $.ajax({
                    url: `/admin/inventory/${id}/destroy`,
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
</script>
@endpush

@endsection
