@extends('layouts.admin')

@section('title','Inventory')

@section('content')
<h3 class="mb-3">Inventory</h3>

@php
    $selectedProjectId = request()->query('project_id');
    
$categories = [
    'MATERIAL',
    'WAGES',
    'LOGISTIC',
    'MAINTENANCE',
    'T&P',
    'FEE',
    'TOURS',
    'OTHERS'
];


@endphp

<div class="row">
<div class="col-md-12">

<table id="inventoryTable" class="table table-sm table-bordered">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>Project</th>
            <th>Date</th>
            <th>Category</th>
            <th>Description</th>
            <th>Paid To</th>
            <th>Voucher</th>
            <th>Qty</th>
            <th>Amount</th>
            <th>Deduction</th>
            <th>Net Payable</th>
            <th>Upload</th>
            <th width="120">Action</th>
        </tr>
    </thead>

    <tbody>
    @forelse($items as $index => $i)
        <tr data-id="{{ $i->id }}">
            <td>{{ $index+1 }}</td>

            <td>
                @if($selectedProjectId)
                    <input type="hidden" class="project_id" value="{{ $selectedProjectId }}">
                   
                @else
                    <select class="form-select project_id">
                        <option value="">Select Project</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" {{ $i->project_id == $project->id ? 'selected':'' }}>
                                {{ $project->name }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </td>

            <td><input type="date" class="form-control date" value="{{ $i->date }}"></td>
            {{-- <td><input type="text" class="form-control category" value="{{ $i->category }}"></td> --}}
            <td>
                <select class="form-select category">
                    <option value="">Select</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ $i->category == $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>
            </td>

            <td><input type="text" class="form-control description" value="{{ $i->description }}"></td>
            <td><input type="text" class="form-control paid_to" value="{{ $i->paid_to }}"></td>
            <td><input type="text" class="form-control voucher" value="{{ $i->voucher }}"></td>

            <td><input type="number" step="0.01" class="form-control quantity" value="{{ $i->quantity }}"></td>
            <td><input type="number" step="0.01" class="form-control amount" value="{{ $i->amount }}"></td>
            <td><input type="number" step="0.01" class="form-control deduction" value="{{ $i->deduction }}"></td>

            <td class="net_payable">{{ number_format($i->net_payable,2) }}</td>

            <td>
                {{-- @if($i->upload)
                    <a href="{{ asset($i->upload) }}"
                    target="_blank"
                    class="btn btn-sm btn-outline-primary">
                        View
                    </a>
                @endif --}}

                <input type="file" class="form-control upload">
            </td>

            <td>
                <button class="btn btn-success btn-sm saveRow">Save</button>
                <button class="btn btn-danger btn-sm removeRow">Del</button>
            </td>
        </tr>
    @empty
        <tr>
            <td>1</td>

            <td>
                <select class="form-select project_id">
                    <option value="">Select Project</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach
                </select>
            </td>

            <td><input type="date" class="form-control date" value="{{ date('Y-m-d') }}"></td>
            <td><input type="text" class="form-control category"></td>
            <td><input type="text" class="form-control description"></td>
            <td><input type="text" class="form-control paid_to"></td>
            <td><input type="text" class="form-control voucher"></td>
            <td><input type="number" step="0.01" class="form-control quantity"></td>
            <td><input type="number" step="0.01" class="form-control amount"></td>
            <td><input type="number" step="0.01" class="form-control deduction"></td>
            <td class="net_payable">0.00</td>
            <td><input type="file" class="form-control upload"></td>
            <td>
                <button class="btn btn-success btn-sm saveRow">Save</button>
            </td>
        </tr>
    @endforelse
    </tbody>
</table>

<button id="addRow" class="btn btn-primary btn-sm mt-2">+ Add New Row</button>

</div>
</div>

@push('scripts')
<script>
$(document).ready(function(){

    let selectedProjectId = "{{ $selectedProjectId ?? '' }}";

    // ADD ROW
    $('#addRow').click(function(){
        let index = $('#inventoryTable tbody tr').length + 1;

        let projectCell = selectedProjectId
            ? `<input type="hidden" class="project_id" value="${selectedProjectId}">
               `
            : `<select class="form-select project_id">
                    <option value="">Select Project</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach
               </select>`;

        let row = `
        <tr>
            <td>${index}</td>
            <td>${projectCell}</td>
            <td><input type="date" class="form-control date" value="{{ date('Y-m-d') }}"></td>
            <td>
                <select class="form-select category">
                    <option value="">Select</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>
            </td>

            <td><input type="text" class="form-control description"></td>
            <td><input type="text" class="form-control paid_to"></td>
            <td><input type="text" class="form-control voucher"></td>
            <td><input type="number" step="0.01" class="form-control quantity"></td>
            <td><input type="number" step="0.01" class="form-control amount"></td>
            <td><input type="number" step="0.01" class="form-control deduction"></td>
            <td class="net_payable">0.00</td>
            <td><input type="file" class="form-control upload"></td>
            <td>
                <button class="btn btn-success btn-sm saveRow">Save</button>
                <button class="btn btn-danger btn-sm removeRow">Del</button>
            </td>
        </tr>`;
        $('#inventoryTable tbody').append(row);
    });

    // NET PAYABLE
    $(document).on('input','.amount,.deduction',function(){
        let row = $(this).closest('tr');
        let amount = parseFloat(row.find('.amount').val()) || 0;
        let deduction = parseFloat(row.find('.deduction').val()) || 0;
        row.find('.net_payable').text((amount - deduction).toFixed(2));
    });

    // SAVE
    $(document).on('click','.saveRow',function(){
        let row = $(this).closest('tr');
        let id = row.data('id') || null;

        let formData = new FormData();
        formData.append('_token',"{{ csrf_token() }}");
        formData.append('project_id', row.find('.project_id').val());
        formData.append('date', row.find('.date').val());
        formData.append('category', row.find('.category').val());
        formData.append('description', row.find('.description').val());
        formData.append('paid_to', row.find('.paid_to').val());
        formData.append('voucher', row.find('.voucher').val());
        formData.append('quantity', row.find('.quantity').val());
        formData.append('amount', row.find('.amount').val());
        formData.append('deduction', row.find('.deduction').val());

        let file = row.find('.upload')[0];
        if(file && file.files.length){
            formData.append('upload', file.files[0]);
        }

        $.ajax({
            url: id ? `/admin/inventory/${id}/update` : "{{ route('admin.inventory.store') }}",
            type:'POST',
            data:formData,
            processData:false,
            contentType:false,
            success:function(){
                if(!id) location.reload();
                else alert('Saved successfully');
            }
        });
    });

    // DELETE
    $(document).on('click','.removeRow',function(){
        let row = $(this).closest('tr');
        let id = row.data('id');

        if(id){
            if(confirm('Delete this item?')){
                $.post(`/admin/inventory/${id}/destroy`,
                    {_token:"{{ csrf_token() }}"},
                    function(){
                        row.remove();
                        reindex();
                    }
                );
            }
        } else {
            row.remove();
            reindex();
        }
    });

    function reindex(){
        $('#inventoryTable tbody tr').each(function(i){
            $(this).find('td:first').text(i+1);
        });
    }

});
</script>
@endpush

@endsection
