{{-- @extends('layouts.admin')

@section('title', 'Add Security Deposit')

@section('content') --}}

<div class="card">
    <div class="card-body">
        <h5 class="mb-4">Security Deposit Details</h5>

        @php
            $sd = $securityDeposits->first();
        @endphp

        <div class="row g-3" id="securityForm">

            <div class="col-md-4">
                <label>Instrument Type</label>
                <select class="form-select instrument_type">
                    <option value="">Select</option>
                    <option value="FDR" {{ ($sd->instrument_type ?? '')=='FDR'?'selected':'' }}>FDR</option>
                    <option value="BG" {{ ($sd->instrument_type ?? '')=='BG'?'selected':'' }}>BG</option>
                    <option value="DD" {{ ($sd->instrument_type ?? '')=='DD'?'selected':'' }}>DD</option>
                    <option value="CHALLAN" {{ ($sd->instrument_type ?? '')=='CHALLAN'?'selected':'' }}>CHALLAN</option>
                    <option value="FROM_BILL" {{ ($sd->instrument_type ?? '')=='FROM_BILL'?'selected':'' }}>FROM BILL</option>
                </select>
            </div>

            <div class="col-md-4">
                <label>Instrument Number</label>
                <input class="form-control instrument_number"
                       value="{{ $sd->instrument_number ?? '' }}">
            </div>

            <div class="col-md-4">
                <label>Instrument Date</label>
                <input type="date" class="form-control instrument_date"
                       value="{{ isset($sd->instrument_date) ? \Carbon\Carbon::parse($sd->instrument_date)->format('Y-m-d') : '' }}">
            </div>

            <div class="col-md-4">
                <label>Amount</label>
                <input type="number" step="0.01" class="form-control amount"
                       value="{{ $sd->amount ?? '' }}">
            </div>

            <div class="col-md-4">
                <label>Upload</label>

                @if(isset($sd->upload))
                    <div class="mb-1">
                        <a href="{{ Storage::url($sd->upload) }}"
                           target="_blank"
                           class="btn btn-sm btn-outline-primary">
                            View Uploaded File
                        </a>
                    </div>
                @endif

                <input type="file" class="form-control upload">
            </div>

            <div class="col-md-12 mt-3">
                <button class="btn btn-success btn-sm rounded-pill saveSecurity">
                    {{ $sd ? 'Update' : 'Save' }}
                </button>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).on('click', '.saveSecurity', function () {

    let formData = new FormData();
    formData.append('_token', "{{ csrf_token() }}");
    formData.append('instrument_type', $('.instrument_type').val());
    formData.append('instrument_number', $('.instrument_number').val());
    formData.append('instrument_date', $('.instrument_date').val());
    formData.append('amount', $('.amount').val());

    let file = $('.upload')[0];
    if (file && file.files.length) {
        formData.append('upload', file.files[0]);
    }

    $.ajax({
        url: "{{ route('admin.security-deposits.store', [$project->id, $billing->id]) }}",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function () {
            alert('Security Deposit saved successfully');
            location.reload();
        }
    });
});
</script>
@endpush


{{-- @endsection --}}
