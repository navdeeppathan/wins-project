@extends('layouts.admin')

@section('title','Billing')

@section('content')

<div class="card">
    <div class="card-body">
        <h5 class="mb-4">Recovery Details</h5>

        <div class="row g-3" id="recoveryForm" data-id="{{ $billing->id }}">

            <div class="col-md-3">
                <label>Security (2.5%)</label>
                <input type="number" class="form-control security" readonly
                       value="{{ $recoveries->first()->security ?? '' }}">
            </div>

            <div class="col-md-3">
                <label>Income Tax (2%)</label>
                <input type="number" class="form-control income_tax" readonly
                       value="{{ $recoveries->first()->income_tax ?? '' }}">
            </div>

            <div class="col-md-3">
                <label>Labour Cess (1%)</label>
                <input type="number" class="form-control labour_cess" readonly
                       value="{{ $recoveries->first()->labour_cess ?? '' }}">
            </div>

            <div class="col-md-3">
                <label>Water Charges (1%)</label>
                <input type="number" class="form-control water_charges" readonly
                       value="{{ $recoveries->first()->water_charges ?? '' }}">
            </div>

            <div class="col-md-3">
                <label>License Fee</label>
                <input type="number" class="form-control license_fee"
                       value="{{ $recoveries->first()->license_fee ?? '' }}">
            </div>

            <div class="col-md-3">
                <label>CGST</label>
                <input type="number" class="form-control cgst" readonly
                       value="{{ $recoveries->first()->cgst ?? '' }}">
            </div>

            <div class="col-md-3">
                <label>SGST</label>
                <input type="number" class="form-control sgst" readonly
                       value="{{ $recoveries->first()->sgst ?? '' }}">
            </div>

            <div class="col-md-3">
                <label>Withheld 1</label>
                <input type="number" class="form-control withheld_1"
                       value="{{ $recoveries->first()->withheld_1 ?? '' }}">
            </div>

            <div class="col-md-3">
                <label>Withheld 2</label>
                <input type="number" class="form-control withheld_2"
                       value="{{ $recoveries->first()->withheld_2 ?? '' }}">
            </div>

            <div class="col-md-3">
                <label>Recovery</label>
                <input type="number" class="form-control recovery"
                       value="{{ $recoveries->first()->recovery ?? '' }}">
            </div>

            <div class="col-md-3">
                <label>Total</label>
                <input type="number" class="form-control total" readonly
                       value="{{ $recoveries->first()->total ?? '' }}">
            </div>

            <div class="col-md-12 mt-3">
                <button class="btn btn-success btn-sm rounded-pill saveRecovery">
                    {{ $recoveries->count() ? 'Update' : 'Save' }}
                </button>

                {{-- <a href="{{ route('admin.security-deposits.create', [
                        'project' => $project->id,
                        'billing' => $billing->id
                    ]) }}" class="btn btn-primary ms-2">
                    Add Security Deposit
                </a> --}}
            </div>

        </div>
    </div>
</div>

<div class="mt-4">
    @include('admin.security_deposits.create')
</div>

<div class="mt-4">
    <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
</div>


@push('scripts')
<script>
const tender = {{ $project->tendered_amount }};
const gross  = {{ $billing->gross_amount }};

function calculateForm() {

    let security     = tender * 0.025;
    let incomeTax    = gross * 0.02;
    let labourCess   = gross * 0.01;
    let waterCharges = gross * 0.01;

    let taxable = gross / 1.18;
    let cgst = taxable * 0.09;
    let sgst = taxable * 0.09;

    $('.security').val(security.toFixed(2));
    $('.income_tax').val(incomeTax.toFixed(2));
    $('.labour_cess').val(labourCess.toFixed(2));
    $('.water_charges').val(waterCharges.toFixed(2));
    $('.cgst').val(cgst.toFixed(2));
    $('.sgst').val(sgst.toFixed(2));

    let total =
        security + incomeTax + labourCess + waterCharges + cgst + sgst +
        (+$('.license_fee').val() || 0) +
        (+$('.withheld_1').val() || 0) +
        (+$('.withheld_2').val() || 0) +
        (+$('.recovery').val() || 0);

    $('.total').val(total.toFixed(2));
}

$(document).on('input', '.license_fee, .withheld_1, .withheld_2, .recovery', function () {
    calculateForm();
});

// SAVE
$(document).on('click', '.saveRecovery', function () {

    let data = {
        _token: "{{ csrf_token() }}",
        security: $('.security').val(),
        income_tax: $('.income_tax').val(),
        labour_cess: $('.labour_cess').val(),
        water_charges: $('.water_charges').val(),
        license_fee: $('.license_fee').val(),
        cgst: $('.cgst').val(),
        sgst: $('.sgst').val(),
        withheld_1: $('.withheld_1').val(),
        withheld_2: $('.withheld_2').val(),
        recovery: $('.recovery').val(),
        total: $('.total').val(),
    };

    $.post("{{ route('admin.billing.recovery.store', $billing) }}", data, function () {
        alert('Recovery saved successfully');
        location.reload();
    });
});

// Initial calculation
calculateForm();
</script>
@endpush

@endsection
