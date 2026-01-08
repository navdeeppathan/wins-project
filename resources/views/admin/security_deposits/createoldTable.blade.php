@extends('layouts.admin')

@section('title', 'Add Security Deposit')

@section('content')

<style>
    /* 🔥 Allow full width inputs */
    #securityTable input.form-control,
    #securityTable select.form-select {
        min-width: 180px;
        width: 100%;
    }

    /* 🔥 Paid To & Narration extra wide */
    #securityTable td:nth-child(3) input,
    #securityTable td:nth-child(5) input {
        min-width: 250px;
    }

    /* 🔥 Disable text cutting */
    #securityTable input,
    #securityTable select {
        white-space: nowrap;
        overflow-x: auto;
    }

    /* 🔥 Horizontal scroll inside input */
    #securityTable input {
        text-overflow: clip;
    }

    /* Optional: show scrollbar only when needed */
    #securityTable input::-webkit-scrollbar {
        height: 6px;
    }
</style>
<div class="table-responsive">
<table class="table table-bordered nowrap class-table" id="securityTable" style="width:100%">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Instrument Type</th>
            <th>Instrument Number</th>
            <th>Instrument Date</th>
            <th>Amount</th>
            <th>Upload</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody id="securityBody">
    @forelse($securityDeposits as $index => $p)
        <tr>
            <td>{{ $index+1 }}</td>

            <td>
                <select class="form-select form-select-sm instrument_type">
                    <option value="">Select</option>
                    <option value="FDR" {{ $p->instrument_type=='FDR'?'selected':'' }}>FDR</option>
                    <option value="BG" {{ $p->instrument_type=='BG'?'selected':'' }}>BG</option>
                    <option value="DD" {{ $p->instrument_type=='DD'?'selected':'' }}>DD</option>
                    <option value="CHALLAN" {{ $p->instrument_type=='CHALLAN'?'selected':'' }}>CHALLAN</option>
                    <option value="CASH" {{ $p->instrument_type=='CASH'?'selected':'' }}>CASH</option>
                </select>
            </td>

            <td><input class="form-control form-control-sm instrument_number" value="{{ $p->instrument_number }}"></td>
           <td>
                <input type="date"
                    class="form-control form-control-sm instrument_date"
                    value="{{ $p->instrument_date ? \Carbon\Carbon::parse($p->instrument_date)->format('Y-m-d') : '' }}">
            </td>

            <td><input type="number" step="0.01" class="form-control form-control-sm amount" value="{{ $p->amount }}"></td>

            <td>
                @if($p->upload)
                    <a href="{{ Storage::url($p->upload) }}"
                    target="_blank"
                    class="btn btn-sm btn-outline-primary mb-1">
                        View
                    </a>
                @endif

                <input type="file" class="form-control form-control-sm upload">
            </td>


            <td>
                <button class="btn btn-sm btn-success saveSecurity">
                    Save
                </button>
            </td>
        </tr>
    @empty
        <tr>
            <td>1</td>
            <td>
                <select class="form-select form-select-sm instrument_type">
                    <option value="">Select</option>
                    <option value="FDR">FDR</option>
                    <option value="BG">BG</option>
                    <option value="DD">DD</option>
                    <option value="CHALLAN">CHALLAN</option>
                    <option value="CASH">CASH</option>
                </select>
            </td>
            <td><input class="form-control form-control-sm instrument_number"></td>
            <td><input type="date" class="form-control form-control-sm instrument_date"></td>
            <td><input type="number" step="0.01" class="form-control form-control-sm amount"></td>
            <td><input type="file" class="form-control form-control-sm upload"></td>
            <td><button class="btn btn-sm btn-success saveSecurity">Save</button></td>
        </tr>
    @endforelse
    </tbody>
</table>
</div>

<button id="addSecurityRow" class="btn btn-sm btn-primary mt-2">
    + Add More Security Deposit
</button>

@push('scripts')
<script>
let securityTable = $('#securityTable').DataTable({
    scrollX: true,
    responsive: false,
    autoWidth: false
});

// ADD MORE ROW
$('#addSecurityRow').on('click', function () {

    let index = securityTable.rows().count() + 1;

    securityTable.row.add([
        index,

        `<select class="form-select form-select-sm instrument_type">
            <option value="">Select</option>
            <option value="FDR">FDR</option>
            <option value="BG">BG</option>
            <option value="DD">DD</option>
            <option value="CHALLAN">CHALLAN</option>
            <option value="CASH">CASH</option>
        </select>`,

        `<input class="form-control form-control-sm instrument_number">`,
        `<input type="date" class="form-control form-control-sm instrument_date">`,
        `<input type="number" step="0.01" class="form-control form-control-sm amount">`,
        `<input type="file" class="form-control form-control-sm upload">`,
        `<button class="btn btn-sm btn-success saveSecurity">Save</button>`
    ]).draw(false);
});

// SAVE ROW
$(document).on('click', '.saveSecurity', function () {

    let row = $(this).closest('tr');

    let formData = new FormData();
    formData.append('_token', "{{ csrf_token() }}");
    formData.append('instrument_type', row.find('.instrument_type').val());
    formData.append('instrument_number', row.find('.instrument_number').val());
    formData.append('instrument_date', row.find('.instrument_date').val());
    formData.append('amount', row.find('.amount').val());

    let file = row.find('.upload')[0];
    if (file && file.files.length) {
        formData.append('upload', file.files[0]);
    }

    $.ajax({
        url: "{{ route('admin.security-deposits.store', [$project->id, $billing->id]) }}",
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function () {
            alert('Security Deposit saved');
        }
    });
});
</script>

<script>
    new DataTable('#recoveryTable', {
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

@endsection

