@extends('layouts.admin')

@section('title','Basic Rates')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Basic Rates</h3>


    <button class="btn btn-success" id="addBtn">
        + Add Basic Rate
    </button>

    


</div>

<div id="addSection" class="card mb-4" style="display:none;">
        <div class="card-header">
            <h5 class="mb-0">Add Basic Rate</h5>
        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('admin.rate-items.store') }}">
                @csrf

                <div class="row">

                    <div class="col-md-3 mb-3">
                        <label class="fw-bold">Rate Type</label>
                        <select name="rate_types" class="form-select" required>
                            <option value="">Select</option>
                            <option value="DSR">DSR</option>
                            <option value="NSR">NSR</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="fw-bold">Department</label>
                        <select name="department" class="form-select" required>
                            <option value="">Select</option>
                            <option value="CIVIL">CIVIL</option>
                            <option value="ELECTRICAL">ELECTRICAL</option>
                            <option value="HORTICULTURE">HORTICULTURE</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="fw-bold">Category</label>
                        <select name="category_name" class="form-select" required>
                            <option value="">Select</option>
                            <option value="HIRE CHARGES OF PLANTS & MACHINERY">
                                HIRE CHARGES OF PLANTS & MACHINERY
                            </option>
                            <option value="LABOUR">LABOUR</option>
                            <option value="MATERIALS">MATERIALS</option>
                            <option value="CARRIAGE">CARRIAGE</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="fw-bold">Code No</label>
                        <input type="text"
                            name="code_no"
                            class="form-control"
                            required>
                    </div>

                    <div class="col-md-8 mb-3">
                        <label class="fw-bold">Description</label>
                        <textarea name="description"
                                rows="4"
                                class="form-control"
                                required></textarea>
                    </div>

                    <div class="col-md-2 mb-3">
                        <label class="fw-bold">Unit</label>
                        <input type="text"
                            name="unit"
                            class="form-control"
                            required>
                    </div>

                    <div class="col-md-2 mb-3">
                        <label class="fw-bold">Basic Rate</label>
                        <input type="number"
                            step="0.01"
                            name="basic_rate"
                            class="form-control"
                            required>
                    </div>

                    {{-- <div class="col-md-3 mb-3">
                        <label class="fw-bold">Effective Date</label>
                        <input type="date"
                            name="effective_date"
                            class="form-control">
                    </div> --}}

                </div>

                <button type="submit" class="btn btn-success">
                    Save
                </button>

                <button type="button"
                        class="btn btn-secondary"
                        id="cancelAddBtn">
                    Cancel
                </button>

            </form>

        </div>
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
            <label class="fw-bold">Department</label>
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
                    <th>Department</th>
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

</div>




@endsection

@push('scripts')

<script>

new DataTable('#rateTable', {

    scrollX: true,
    scrollCollapse: true,
    responsive: false,
    autoWidth: true,

    pageLength: 10,

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

$('#addBtn').click(function(){

    $('#addSection').slideDown();

    $('html, body').animate({
        scrollTop: $('#addSection').offset().top - 80
    }, 500);

});

$('#cancelAddBtn').click(function(){

    $('#addSection').slideUp();

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
