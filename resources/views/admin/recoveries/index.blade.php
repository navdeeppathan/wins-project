@extends('layouts.admin')

@section('title','Billing')

@section('content')
<style>
    /* 🔥 Allow full width inputs */
    #recoveryTable input.form-control,
    #recoveryTable select.form-select {
        min-width: 180px;
        width: 100%;
    }

    /* 🔥 Paid To & Narration extra wide */
    #recoveryTable td:nth-child(3) input,
    #recoveryTable td:nth-child(5) input {
        min-width: 250px;
    }

    /* 🔥 Disable text cutting */
    #recoveryTable input,
    #recoveryTable select {
        white-space: nowrap;
        overflow-x: auto;
    }

    /* 🔥 Horizontal scroll inside input */
    #recoveryTable input {
        text-overflow: clip;
    }

    /* Optional: show scrollbar only when needed */
    #recoveryTable input::-webkit-scrollbar {
        height: 6px;
    }
</style>

<div class="table-responsive">
<table class="table table-bordered class-table nowrap" id="recoveryTable" style="width:100%">
    <thead class="">
        <tr>
            <th>#</th>
            <th>Security (2.5%)</th>
            <th>Income Tax (2%)</th>
            <th>Labour Cess (1%)</th>
            <th>Water Charges (1%)</th>
            <th>License Fee</th>
            <th>CGST</th>
            <th>SGST</th>
            <th>Withheld 1</th>
            <th>Withheld 2</th>
            <th>Recovery</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody id="recoveryBody">
    @forelse($recoveries as $index => $r)
        <tr data-id="{{ $billing->id }}">
            <td>{{ $index+1 }}</td>

            <td><input type="number" class="form-control form-control-sm security" value="{{ $r->security }}" readonly></td>
            <td><input type="number" class="form-control form-control-sm income_tax" value="{{ $r->income_tax }}" readonly></td>
            <td><input type="number" class="form-control form-control-sm labour_cess" value="{{ $r->labour_cess }}" readonly></td>
            <td><input type="number" class="form-control form-control-sm water_charges" value="{{ $r->water_charges }}" readonly></td>

            <td><input type="number" class="form-control form-control-sm license_fee" value="{{ $r->license_fee }}"></td>

            <td><input type="number" class="form-control form-control-sm cgst" value="{{ $r->cgst }}" readonly></td>
            <td><input type="number" class="form-control form-control-sm sgst" value="{{ $r->sgst }}" readonly></td>

            <td><input type="number" class="form-control form-control-sm withheld_1" value="{{ $r->withheld_1 }}"></td>
            <td><input type="number" class="form-control form-control-sm withheld_2" value="{{ $r->withheld_2 }}"></td>

            <td><input type="number" class="form-control form-control-sm recovery" value="{{ $r->recovery }}"></td>

            <td>
                <input type="number" class="form-control form-control-sm total" value="{{ $r->total }}" readonly>
            </td>

            <td>
                <button class="btn btn-sm btn-success saveRecovery">Save</button>
                <a href="{{ route('admin.security-deposits.create', [
                            'project' => $project->id,
                            'billing' => $billing->id,
                        ]) }}" class="btn btn-primary btn-sm">Add Security Deposit</a>
            </td>
        </tr>
    @empty
        {{-- Empty row --}}
        <tr data-id="{{ $billing->id }}">
            <td>1</td>

            <td><input class="form-control form-control-sm security" readonly></td>
            <td><input class="form-control form-control-sm income_tax" readonly></td>
            <td><input class="form-control form-control-sm labour_cess" readonly></td>
            <td><input class="form-control form-control-sm water_charges" readonly></td>

            <td><input class="form-control form-control-sm license_fee"></td>
            <td><input class="form-control form-control-sm cgst" readonly></td>
            <td><input class="form-control form-control-sm sgst" readonly></td>

            <td><input class="form-control form-control-sm withheld_1"></td>
            <td><input class="form-control form-control-sm withheld_2"></td>
            <td><input class="form-control form-control-sm recovery"></td>

            <td><input class="form-control form-control-sm total" readonly></td>
            <td><button class="btn btn-sm btn-success saveRecovery">Save</button></td>
        </tr>
    @endforelse
    </tbody>
</table>
</div>

<button id="addRecoveryRow"
        class="btn btn-sm btn-primary mt-2">
    + Add More Recovery
</button>


@push('scripts')
<script>
const tender = {{ $project->tendered_amount }};
const gross  = {{ $billing->gross_amount }};

function calculateRow(row) {
    let security     = tender * 0.025;
    let incomeTax    = gross * 0.02;
    let labourCess   = gross * 0.01;
    let waterCharges = gross * 0.01;

    let taxable = gross / 1.18;
    let cgst = taxable * 0.09;
    let sgst = taxable * 0.09;

    row.find('.security').val(security.toFixed(2));
    row.find('.income_tax').val(incomeTax.toFixed(2));
    row.find('.labour_cess').val(labourCess.toFixed(2));
    row.find('.water_charges').val(waterCharges.toFixed(2));
    row.find('.cgst').val(cgst.toFixed(2));
    row.find('.sgst').val(sgst.toFixed(2));

    let total =
        security + incomeTax + labourCess + waterCharges + cgst + sgst +
        (+row.find('.license_fee').val() || 0) +
        (+row.find('.withheld_1').val() || 0) +
        (+row.find('.withheld_2').val() || 0) +
        (+row.find('.recovery').val() || 0);

    row.find('.total').val(total.toFixed(2));
}

$(document).on('input', '.license_fee, .withheld_1, .withheld_2, .recovery', function () {
    calculateRow($(this).closest('tr'));
});

// SAVE ROW
$(document).on('click', '.saveRecovery', function () {
    let row = $(this).closest('tr');

    let data = {
        _token: "{{ csrf_token() }}",
        security: row.find('.security').val(),
        income_tax: row.find('.income_tax').val(),
        labour_cess: row.find('.labour_cess').val(),
        water_charges: row.find('.water_charges').val(),
        license_fee: row.find('.license_fee').val(),
        cgst: row.find('.cgst').val(),
        sgst: row.find('.sgst').val(),
        withheld_1: row.find('.withheld_1').val(),
        withheld_2: row.find('.withheld_2').val(),
        recovery: row.find('.recovery').val(),
        total: row.find('.total').val(),
    };

    $.post("{{ route('admin.billing.recovery.store', $billing) }}", data, function () {
        window.location.reload();
        alert('Recovery saved successfully');
    });
});

// initial calc
$('#recoveryTable tbody tr').each(function(){
    calculateRow($(this));
});
</script>
<script>
$('#addRecoveryRow').on('click', function () {

    let index = $('#recoveryBody tr').length + 1;

    let row = `
    <tr data-id="{{ $billing->id }}">
        <td>${index}</td>

        <td><input class="form-control form-control-sm security" readonly></td>
        <td><input class="form-control form-control-sm income_tax" readonly></td>
        <td><input class="form-control form-control-sm labour_cess" readonly></td>
        <td><input class="form-control form-control-sm water_charges" readonly></td>

        <td><input class="form-control form-control-sm license_fee"></td>

        <td><input class="form-control form-control-sm cgst" readonly></td>
        <td><input class="form-control form-control-sm sgst" readonly></td>

        <td><input class="form-control form-control-sm withheld_1"></td>
        <td><input class="form-control form-control-sm withheld_2"></td>

        <td><input class="form-control form-control-sm recovery"></td>

        <td><input class="form-control form-control-sm total" readonly></td>

        <td>
            <button class="btn btn-sm btn-success saveRecovery">
                Save
            </button>
        </td>
    </tr>`;

    $('#recoveryBody').append(row);

    // Auto calculate new row
    calculateRow($('#recoveryBody tr:last'));
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
