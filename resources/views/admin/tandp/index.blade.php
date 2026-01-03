@extends('layouts.admin')

@section('title','T & P')

@section('content')
<h3 class="mb-3">Tools & Plants (T & P)</h3>

<div class="row">
<div class="col-md-12">
<div class="table-responsive">
    <table id="tpTable" class="table class-table nowrap" style="width:100%">
        <thead>

            <tr>
                <th>#</th>
                <th>Project *</th>
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
            @forelse($items as $index => $item)
                <tr data-id="{{ $item->id }}">
                    <td>{{ $index+1 }}</td>

                    <td>
                        <select class="form-select project_id">
                            <option value="">Select</option>
                            @foreach($projects as $p)
                                <option value="{{ $p->id }}" {{ $item->project_id==$p->id?'selected':'' }}>
                                    {{ $p->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>

                    <td><input type="date" class="form-control date" value="{{ $item->date }}"></td>
                    <td>
                        <select class="form-select category">
                            @php
                                $categories = ['Material','Wages','Logistic','Maintenance','T&P','Fee','Tours','Others'];
                                $selected = $item->category ?? 'T&P';
                            @endphp

                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ $selected == $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                    </td>

                    <td><input type="text" class="form-control description" value="{{ $item->description }}"></td>
                    <td><input type="text" class="form-control paid_to" value="{{ $item->paid_to }}"></td>
                    <td><input type="text" class="form-control voucher" value="{{ $item->voucher }}"></td>

                    <td><input type="number" step="0.01" class="form-control quantity" value="{{ $item->quantity }}"></td>
                    <td><input type="number" step="0.01" class="form-control amount" value="{{ $item->amount }}"></td>
                    <td><input type="number" step="0.01" class="form-control deduction" value="{{ $item->deduction }}"></td>

                    <td class="net_payable">{{ number_format($item->net_payable,2) }}</td>

                    <td>
                        @if($item->upload)
                            <a href="{{ asset($item->upload) }}" target="_blank" class="btn btn-sm btn-outline-primary mb-1">
                                View
                            </a>
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

                    <td>
                    <select class="form-select project_id">
                        <option value="">Select</option>
                        @foreach($projects as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                    </td>

                    <td><input type="date" class="form-control date" value="{{ date('Y-m-d') }}"></td>
                    <td>
                        <select class="form-select category">
                            <option value="Material">Material</option>
                            <option value="Wages">Wages</option>
                            <option value="Logistic">Logistic</option>
                            <option value="Maintenance">Maintenance</option>
                            <option value="T&P" selected>T&P</option>
                            <option value="Fee">Fee</option>
                            <option value="Tours">Tours</option>
                            <option value="Others">Others</option>
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
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<button id="addRow" class="btn btn-primary btn-sm mt-2">+ Add New Row</button>

</div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function(){

// ➕ ADD ROW
$('#addRow').click(function(){
    let index = $('#tpTable tbody tr').length + 1;

    let row = `
    <tr>
        <td>${index}</td>
        <td>
            <select class="form-select project_id">
                <option value="">Select</option>
                @foreach($projects as $p)
                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                @endforeach
            </select>
        </td>
        <td><input type="date" class="form-control date" value="{{ date('Y-m-d') }}"></td>
        <td>
    <select class="form-select category">
        <option value="Material">Material</option>
        <option value="Wages">Wages</option>
        <option value="Logistic">Logistic</option>
        <option value="Maintenance">Maintenance</option>
        <option value="T&P" selected>T&P</option>
        <option value="Fee">Fee</option>
        <option value="Tours">Tours</option>
        <option value="Others">Others</option>
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
    $('#tpTable tbody').append(row);
});


$(document).on('input','.amount,.deduction',function(){
    let row=$(this).closest('tr');
    let a=parseFloat(row.find('.amount').val())||0;
    let d=parseFloat(row.find('.deduction').val())||0;
    row.find('.net_payable').text((a-d).toFixed(2));
});


$(document).on('click','.saveRow',function(){
    let row=$(this).closest('tr');
    let id=row.data('id')||null;

    let fd=new FormData();
    fd.append('_token',"{{ csrf_token() }}");
    fd.append('project_id', row.find('.project_id').val());
    fd.append('date', row.find('.date').val());
    fd.append('category', row.find('.category').val());
    fd.append('description', row.find('.description').val());
    fd.append('paid_to', row.find('.paid_to').val());
    fd.append('voucher', row.find('.voucher').val());
    fd.append('quantity', row.find('.quantity').val());
    fd.append('amount', row.find('.amount').val());
    fd.append('deduction', row.find('.deduction').val());

    if(row.find('.upload')[0].files.length){
        fd.append('upload', row.find('.upload')[0].files[0]);
    }

    $.ajax({
        url: id ? `/admin/t-and-p/${id}/update` : "{{ route('admin.t-and-p.store') }}",
        type:'POST',
        data:fd,
        processData:false,
        contentType:false,
        success:function(){
            if(!id) location.reload();
            else alert('Updated successfully');
        }
    });
});

$(document).on('click','.removeRow',function(){
    let row=$(this).closest('tr');
    let id=row.data('id');

    if(id){
        if(confirm('Delete this entry?')){
            $.post(`/admin/t-and-p/${id}/destroy`,
                {_token:"{{ csrf_token() }}"},
                function(){ row.remove(); reindex(); }
            );
        }
    } else {
        row.remove();
        reindex();
    }
});

function reindex(){
    $('#tpTable tbody tr').each(function(i){
        $(this).find('td:first').text(i+1);
    });
}

});

new DataTable('#tpTable', {
        scrollX: true,
        scrollCollapse: true,
        responsive: false,
        autoWidth: false,
        

        /* 🔥 GUARANTEED ROW COLOR FIX */
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
