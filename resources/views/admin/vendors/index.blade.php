@extends('layouts.admin')

@section('title','Vendor Expenses')

@section('content')
<h3 class="mb-3">Vendor Expenses</h3>

<div class="row">
<div class="col-md-12">

<table id="vendorTable" class="table table-sm table-bordered">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Category</th>
            <th>Description</th>
            <th>Delivered To</th>
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
    @forelse($vendors as $index => $v)
        <tr data-id="{{ $v->id }}">
            <td>{{ $index+1 }}</td>

            <td><input type="date" class="form-control date" value="{{ $v->date }}"></td>

            <td>
                <select class="form-select category">
                    @foreach(['Material','Wages','Logistic','Maintenance','T&P','Fee','Tours','Others'] as $cat)
                        <option value="{{ $cat }}" {{ $v->category == $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>
            </td>

            <td><input type="text" class="form-control description" value="{{ $v->description }}"></td>
            <td><input type="text" class="form-control delivered_to" value="{{ $v->delivered_to }}"></td>
            <td><input type="text" class="form-control voucher" value="{{ $v->voucher }}"></td>

            <td><input type="number" step="0.01" class="form-control quantity" value="{{ $v->quantity }}"></td>
            <td><input type="number" step="0.01" class="form-control amount" value="{{ $v->amount }}"></td>
            <td><input type="number" step="0.01" class="form-control deduction" value="{{ $v->deduction }}"></td>

            <td class="net_payable">{{ number_format($v->net_payable,2) }}</td>

            <td>
                @if($v->upload)
                    <a href="{{ asset($v->upload) }}" target="_blank"
                       class="btn btn-outline-primary btn-sm mb-1">View</a>
                @endif
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
            <td><input type="date" class="form-control date" value="{{ date('Y-m-d') }}"></td>
            <td>
                <select class="form-select category">
                    @foreach(['Material','Wages','Logistic','Maintenance','T&P','Fee','Tours','Others'] as $cat)
                        <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="text" class="form-control description"></td>
            <td><input type="text" class="form-control delivered_to"></td>
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

<button id="addRow" class="btn btn-primary btn-sm mt-2">
    + Add New Row
</button>

</div>
</div>

@push('scripts')
<script>
$(document).ready(function(){

    // ADD ROW
    $('#addRow').click(function(){
        let index = $('#vendorTable tbody tr').length + 1;

        let row = `
        <tr>
            <td>${index}</td>
            <td><input type="date" class="form-control date" value="{{ date('Y-m-d') }}"></td>
            <td>
                <select class="form-select category">
                    @foreach(['Material','Wages','Logistic','Maintenance','T&P','Fee','Tours','Others'] as $cat)
                        <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="text" class="form-control description"></td>
            <td><input type="text" class="form-control delivered_to"></td>
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
        $('#vendorTable tbody').append(row);
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
        formData.append('date', row.find('.date').val());
        formData.append('category', row.find('.category').val());
        formData.append('description', row.find('.description').val());
        formData.append('delivered_to', row.find('.delivered_to').val());
        formData.append('voucher', row.find('.voucher').val());
        formData.append('quantity', row.find('.quantity').val());
        formData.append('amount', row.find('.amount').val());
        formData.append('deduction', row.find('.deduction').val());

        let file = row.find('.upload')[0];
        if(file && file.files.length){
            formData.append('upload', file.files[0]);
        }

        $.ajax({
            url: id ? `/admin/vendors/${id}/update` : "{{ route('admin.vendors.store') }}",
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
            if(confirm('Delete this entry?')){
                $.post(`/admin/vendors/${id}/destroy`,
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
        $('#vendorTable tbody tr').each(function(i){
            $(this).find('td:first').text(i+1);
        });
    }

});
</script>
@endpush

@endsection
