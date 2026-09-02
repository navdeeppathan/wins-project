@extends('layouts.admin')

@section('title','Basic Rates')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Basic Rates</h3>
</div>

<form method="GET" action="{{ route('admin.rate-items.index') }}" class="mb-3">
    <div class="row">

        <div class="col-md-3">
            <label class="fw-bold">Rate Type</label>
            <select name="rate_types" class="form-select">
                <option value="">Select</option>
                <option value="DSR" {{ request('rate_types')=='DSR' ? 'selected':'' }}>DSR</option>
                <option value="NSR" {{ request('rate_types')=='NSR' ? 'selected':'' }}>NSR</option>
            </select>
        </div>

        <div class="col-md-3">
            <label class="fw-bold">Section</label>
            <select name="department" class="form-select">
                <option value="">Select</option>
                <option value="CIVIL" {{ request('department')=='CIVIL' ? 'selected':'' }}>CIVIL</option>
                <option value="ELECTRICAL" {{ request('department')=='ELECTRICAL' ? 'selected':'' }}>ELECTRICAL</option>
                <option value="HORTICULTURE" {{ request('department')=='HORTICULTURE' ? 'selected':'' }}>HORTICULTURE</option>
            </select>
        </div>

        <div class="col-md-3">
            <label class="fw-bold">Category</label>
            <select name="category_name" class="form-select">
                <option value="">Select</option>
                <option value="HIRE CHARGES OF PLANTS & MACHINERY">HIRE CHARGES OF PLANTS & MACHINERY</option>
                <option value="LABOUR">LABOUR</option>
                <option value="MATERIALS">MATERIALS</option>
                <option value="CARRIAGE">CARRIAGE</option>
            </select>
        </div>

        <div class="col-md-3">
            <label class="fw-bold">Code No</label>
            <input type="text"
                   name="code_no"
                   value="{{ request('code_no') }}"
                   class="form-control">
        </div>

    </div>

    <div class="mt-3">
        <button class="btn btn-primary">
            Search
        </button>

        <a href="{{ route('admin.rate-items.index') }}"
           class="btn btn-secondary">
            Reset
        </a>
    </div>
</form>






<div class="card">
    <div class="card-body">


    <div class="table-responsive">

        <table id="rateTable"
               class="table table-bordered class-table nowrap"
               style="width:100%">

            <thead>
                <tr>
                    <th>#</th>
                    <th>Rate Type</th>
                    <th>Section</th>
                    <th>Category</th>
                    <th>Code No</th>
                    <th>Description</th>
                    <th>Unit</th>
                    <th>Basic Rate</th>
                    {{-- <th>Effective Date</th> --}}
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                @foreach($rateItems as $item)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $item->rate_types }}</td>

                    <td>{{ $item->department }}</td>

                    <td>{{ $item->category_name }}</td>

                    <td>{{ $item->code_no }}</td>

                    <td>{{ $item->description }}</td>

                    <td>{{ $item->unit }}</td>

                    {{-- <td>
                        {{ number_format($item->basic_rate,2) }}
                    </td> --}}
                    <td width="180">
                        <input type="number"
                            step="0.01"
                            class="form-control"
                            id="rate_{{ $item->id }}"
                            value="{{ $item->basic_rate }}">
                    </td>

                    {{-- <td>
                        {{ $item->effective_date
                            ? date('d-m-Y', strtotime($item->effective_date))
                            : '-' }}
                    </td> --}}

                    <td>
                        <button
                            class="btn btn-success btn-sm saveRateBtn"
                            data-id="{{ $item->id }}">
                            Save
                        </button>
                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

    <div class="d-flex align-items-center justify-content-end mt-3">
        <button type="button" id="addRowBtn" class="btn btn-primary btn-sm">+ New Row</button>
    </div>

</div>
</div>

@endsection

@push('scripts')

<script>

let table = new DataTable('#rateTable', {

    scrollX: true,
    scrollCollapse: true,
    responsive: false,
    autoWidth: true,

    pageLength: 5,
    lengthMenu: [5, 10, 25, 50, 100],

    createdRow: function(row, data, index) {

        let bg = (index % 2 === 0)
            ? '#D7E2F2'
            : '#B4C5E6';

        $('td', row).css('background-color', bg);
    },

    rowCallback: function(row, data, index) {

        let bg = (index % 2 === 0)
            ? '#D7E2F2'
            : '#B4C5E6';

        $(row).off('mouseenter mouseleave').hover(
            () => $('td', row).css('background-color', '#e9ecff'),
            () => $('td', row).css('background-color', bg)
        );
    }
});

$('#addRowBtn').click(function(){
    let index = $('#rateTable tbody tr').length + 1;

    let row = `
    <tr class="new-rate-row">
        <td>${index}</td>
        <td>
            <select class="form-select new_rate_types">
                <option value="">Select</option>
                <option value="DSR">DSR</option>
                <option value="NSR">NSR</option>
            </select>
        </td>
        <td>
            <select class="form-select new_department">
                <option value="">Select</option>
                <option value="CIVIL">CIVIL</option>
                <option value="ELECTRICAL">ELECTRICAL</option>
                <option value="HORTICULTURE">HORTICULTURE</option>
            </select>
        </td>
        <td>
            <select class="form-select new_category_name">
                <option value="">Select</option>
                <option value="HIRE CHARGES OF PLANTS & MACHINERY">HIRE CHARGES OF PLANTS & MACHINERY</option>
                <option value="LABOUR">LABOUR</option>
                <option value="MATERIALS">MATERIALS</option>
                <option value="CARRIAGE">CARRIAGE</option>
            </select>
        </td>
        <td>
            <input type="text" class="form-control new_code_no" placeholder="Code No">
        </td>
        <td>
            <textarea class="form-control new_description" rows="2" placeholder="Description"></textarea>
        </td>
        <td>
            <input type="text" class="form-control new_unit" placeholder="Unit">
        </td>
        <td width="180">
            <input type="number" step="0.01" class="form-control new_basic_rate" placeholder="0.00">
        </td>
        <td>
            <button type="button" class="btn btn-success btn-sm saveNewRateBtn">Save</button>
            <button type="button" class="btn btn-danger btn-sm cancelNewRowBtn">❌</button>
        </td>
    </tr>`;

    $('#rateTable tbody').append(row);
});

$(document).on('click', '.cancelNewRowBtn', function () {
    $(this).closest('tr').remove();
});

$(document).on('click', '.saveNewRateBtn', function () {
    let row = $(this).closest('tr');

    let rate_types = row.find('.new_rate_types').val();
    let department = row.find('.new_department').val();
    let category_name = row.find('.new_category_name').val();
    let code_no = row.find('.new_code_no').val();
    let description = row.find('.new_description').val();
    let unit = row.find('.new_unit').val();
    let basic_rate = row.find('.new_basic_rate').val();

    if (!rate_types || !department || !category_name || !code_no || !description || !unit || !basic_rate) {
        alert('Please fill all required fields.');
        return;
    }

    let btn = $(this);
    btn.prop('disabled', true).text('Saving...');

    $.ajax({
        url: "{{ route('admin.rate-items.store') }}",
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            rate_types: rate_types,
            department: department,
            category_name: category_name,
            code_no: code_no,
            description: description,
            unit: unit,
            basic_rate: basic_rate
        },
        success: function (res) {
            location.reload();
        },
        error: function (xhr) {
            btn.prop('disabled', false).text('Save');
            let msg = 'Failed to save rate item.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                msg = xhr.responseJSON.message;
            }
            alert(msg);
        }
    });
});

$(document).on('click','.saveRateBtn',function(){

    let id = $(this).data('id');

    $.ajax({

        url: '/admin/rate-items/update-rate/' + id,

        type: 'POST',

        data: {
            _token: '{{ csrf_token() }}',
            basic_rate: $('#rate_'+id).val()
        },

        success: function(res){

            alert(res.message);

            location.reload();
        }
    });

});
</script>

@endpush
