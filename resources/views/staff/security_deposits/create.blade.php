@extends('layouts.staff')

@section('title', 'Add Security Deposit')

@section('content')

<div class="container-fluid">
<h3 class="mb-2">Security Deposit – Project #{{ $project->name }}</h3>
<p class="text-muted mb-3">Status: <strong>{{ ucfirst($project->status) }}</strong></p>

    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <strong>Security Deposit Details</strong>
                </div>

              <form
                action="{{ route('staff.security-deposits.store', [
                    'project' => $project->id,
                    'billing' => $billing->id
                ]) }}"
                method="POST"
                enctype="multipart/form-data">


                    @csrf

                    <div class="card-body">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Instrument Type *</label>
                                <select name="instrument_type" class="form-select form-select-sm" required>
                                    <option value="">Select</option>
                                    <option value="FDR">FDR</option>
                                    <option value="BG">BG</option>
                                    <option value="DD">DD</option>
                                    <option value="Cheque">Challan</option>
                                    <option value="Cheque">Cash</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Instrument Number *</label>
                                <input type="text"
                                       name="instrument_number"
                                       class="form-control form-control-sm"
                                       required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Instrument Date *</label>
                                <input type="date"
                                       name="instrument_date"
                                       class="form-control form-control-sm"
                                       required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Amount *</label>
                                <input type="number"
                                       step="0.01"
                                       name="amount"
                                       class="form-control form-control-sm"
                                       required>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Upload (PDF / Image)</label>
                                <input type="file"
                                       name="upload"
                                       class="form-control form-control-sm">
                            </div>

                        </div>
                    </div>

                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-sm btn-primary">
                            Save Security Deposit
                        </button>
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-secondary">
                            Back
                        </a>
                    </div>

                </form>
            </div>

        </div>
    </div>


    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <h3>Projects (Security Deposits)</h3>

    </div>


</div>
@if ($securityDeposits->count() > 0)
<div class="table-responsive">
    <table id="securityDepositsTable" class="table class-table nowrap" style="width:100%">
        <thead >
            <tr>
                <th>#</th>
                <th>Instrument Type</th>
                <th>Instrument Number</th>
                <th>Instrument Date</th>
                <th>Amount</th>
                <th>Upload</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i=1;
            @endphp
            @forelse($securityDeposits as $p)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $p->instrument_type }}</td>
                    <td>{{ $p->instrument_number }}</td>
                    <td>{{ $p->instrument_date }}</td>
                    <td>{{ $p->amount }}</td>
                    <td>{{ $p->upload }}</td>
                    
                </tr>
            @php
                $i++;
            @endphp
            @empty
                <tr><td colspan="5" class="text-center">No Security Deposits yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
    @else
    <div class="alert alert-warning text-center">
        Data is not available.
    </div>
    @endif
@push('scripts')
<script>
     new DataTable('#securityDepositsTable', {
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
