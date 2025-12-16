@extends('layouts.admin')

@section('title','Billing')

@section('content')
<h3 class="mb-2">Recoveries – Project #{{ $project->id }} ({{ $project->nit_number }})</h3>
<p class="text-muted mb-3">Status: <strong>{{ ucfirst($project->status) }}</strong></p>

<div class="row">

{{-- Bill List + Items / Recoveries --}}
    <div class="col-md-12 mb-3">
        
            <div class="card mb-3">
               

                <div class="card-body">
                    
                    {{-- <form action="{{ route('admin.billing.items.store', $bill) }}" method="POST" class="row g-2 mb-3">
                        @csrf
                        <div class="col-md-2">
                            <select name="category" class="form-select form-select-sm" required>
                                <option value="material">Material</option>
                                <option value="wages">Wages</option>
                                <option value="logistic">Logistic</option>
                                <option value="maintenance">Maintenance</option>
                                <option value="t&p">T&P</option>
                                <option value="fee">Fee</option>
                                <option value="others">Others</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="description" placeholder="Description" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-md-2">
                            <input type="number" step="0.01" name="quantity" placeholder="Qty" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-md-2">
                            <input type="number" step="0.01" name="amount" placeholder="Amount" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-md-2">
                            <input type="number" step="0.01" name="deduction" placeholder="Deduction" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-sm btn-primary w-100">Add</button>
                        </div>
                    </form> --}}

                    
                    {{-- <table class="table table-sm table-bordered mb-3">
                        <thead class="table-light">
                            <tr>
                                <th>Cat</th>
                                <th>Description</th>
                                <th>Qty</th>
                                <th>Amount</th>
                                <th>Deduction</th>
                                <th>Net</th>
                                <th width="60">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bill->items as $item)
                                <tr>
                                    <td>{{ $item->category }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->amount,2) }}</td>
                                    <td>{{ number_format($item->deduction,2) }}</td>
                                    <td>{{ number_format($item->net_payable,2) }}</td>
                                    <td>
                                        <form action="{{ route('admin.billing.items.destroy', $item) }}" method="POST"
                                              onsubmit="return confirm('Delete item?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Del</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            @if($bill->items->isEmpty())
                                <tr><td colspan="7" class="text-center">No items.</td></tr>
                            @endif
                        </tbody>
                    </table> --}}

                    <form action="{{ route('admin.billing.recovery.store', $billing) }}"
                     method="POST">
                        @csrf
                        <div class="row g-2">
                            @php
                                $r = $bill->recovery ?? null;
                            @endphp
                           {{-- hidden base amounts --}}
                            <input type="hidden" id="tender_amount" value="{{ $project->tendered_amount }}">
                            <input type="hidden" id="gross_amount" value="{{ $billing->gross_amount }}">

                            <div class="col-md-6">
                                <label class="form-label">Security (2.5% of Tender)</label>
                                <input type="number" step="0.01" name="security"
                                    id="security"
                                    value="{{ $r->security ?? 0 }}"
                                    class="form-control form-control-sm" readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Income Tax (2% of Gross)</label>
                                <input type="number" step="0.01" name="income_tax"
                                    id="income_tax"
                                    value="{{ $r->income_tax ?? 0 }}"
                                    class="form-control form-control-sm" readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Labour Cess (1% of Gross)</label>
                                <input type="number" step="0.01" name="labour_cess"
                                    id="labour_cess"
                                    value="{{ $r->labour_cess ?? 0 }}"
                                    class="form-control form-control-sm" readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Water Charges (1% of Gross)</label>
                                <input type="number" step="0.01" name="water_charges"
                                    id="water_charges"
                                    value="{{ $r->water_charges ?? 0 }}"
                                    class="form-control form-control-sm" readonly>
                            </div>


                            <div class="col-md-6">
                                <label class="form-label">License Fee</label>
                               <input type="number" step="0.01" name="license_fee" id="license_fee"
                                     value="{{ $r->license_fee ?? 0 }}" class="form-control form-control-sm">
                            </div>
                           <div class="col-md-6">
                                <label class="form-label">CGST (9%)</label>
                                <input type="number" step="0.01" name="cgst"
                                    id="cgst"
                                    class="form-control form-control-sm"
                                    value="{{ $r->cgst ?? 0 }}"
                                    readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">UT / SGST (9%)</label>
                                <input type="number" step="0.01" name="sgst"
                                    id="sgst"
                                    class="form-control form-control-sm"
                                    value="{{ $r->sgst ?? 0 }}"
                                    readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Withheld 1</label>
                             <input type="number" step="0.01" name="withheld_1" id="withheld_1"
                                    value="{{ $r->withheld_1 ?? 0 }}" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Withheld 2</label>
                                <input type="number" step="0.01" name="withheld_2" id="withheld_2"
                                        value="{{ $r->withheld_2 ?? 0 }}" class="form-control form-control-sm">                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Recovery *</label>
                             <input type="number" step="0.01" name="recovery" id="recovery"
                                 value="{{ $r->recovery ?? 0 }}" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Total (auto)</label>
                                <input type="number" step="0.01"
                                    id="total_display"
                                    class="form-control form-control-sm"
                                    value="{{ $r->total ?? 0 }}"
                                    readonly>

                                <input type="hidden" name="total" id="total">
                            </div>

                            <div class="col-md-3 d-flex align-items-end">
                                <button class="btn btn-sm btn-warning w-100">Save Recoveries</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        
    </div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    let tender = parseFloat(document.getElementById('tender_amount').value) || 0;
    let gross  = parseFloat(document.getElementById('gross_amount').value) || 0;

    function calculateAll() {

        // auto calculations
        let security     = tender * 0.025;
        let incomeTax    = gross * 0.02;
        let labourCess   = gross * 0.01;
        let waterCharges = gross * 0.01;

        let taxable = gross / 1.18;
        let cgst = taxable * 0.09;
        let sgst = taxable * 0.09;

        // set auto fields
        document.getElementById('security').value      = security.toFixed(2);
        document.getElementById('income_tax').value    = incomeTax.toFixed(2);
        document.getElementById('labour_cess').value   = labourCess.toFixed(2);
        document.getElementById('water_charges').value = waterCharges.toFixed(2);
        document.getElementById('cgst').value           = cgst.toFixed(2);
        document.getElementById('sgst').value           = sgst.toFixed(2);

        // manual fields
        let licenseFee = parseFloat(document.getElementById('license_fee').value) || 0;
        let withheld1  = parseFloat(document.getElementById('withheld_1').value) || 0;
        let withheld2  = parseFloat(document.getElementById('withheld_2').value) || 0;
        let recovery   = parseFloat(document.getElementById('recovery').value) || 0;

        // TOTAL
        let total =
            security +
            incomeTax +
            labourCess +
            waterCharges +
            cgst +
            sgst +
            licenseFee +
            withheld1 +
            withheld2 +
            recovery;

        document.getElementById('total_display').value = total.toFixed(2);
        document.getElementById('total').value         = total.toFixed(2);
    }

    // initial load
    calculateAll();

    // recalc when manual fields change
    ['license_fee','withheld_1','withheld_2','recovery'].forEach(id => {
        document.getElementById(id).addEventListener('input', calculateAll);
    });

});
</script>
@endpush



<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Projects (Recoveries)</h3>

</div>

@if($recoveries->count() > 0)
<div class="table-responsive">
    <table id="example" class="table table-striped nowrap" style="width:100%">
        <thead >
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
        <tbody>
            @forelse($recoveries as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->security }}</td>
                    <td>{{ $p->income_tax }}</td>
                    <td>{{ $p->labour_cess }}</td>
                    <td>{{ $p->water_charges }}</td>
                    <td>{{ $p->license_fee }}</td>
                    <td>{{ $p->cgst }}</td>
                    <td>{{ $p->sgst }}</td>
                    <td>{{ $p->withheld_1 }}</td> 
                    <td>{{$p->withheld_2 }}</td>
                    <td>{{ $p->recovery }}</td>
                    <td>{{ $p->total }}</td>
                    <td>
                        <a href="{{ route('admin.security-deposits.create', [
                            'project' => $project->id,
                            'billing' => $billing->id,
                        ]) }}" class="btn btn-primary btn-sm">Add Security Deposit</a>
                    </td>
                    
                </tr>
            @empty
                <tr><td colspan="13" class="text-center">No Recoveries yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@else
    <div class="alert alert-warning text-center">
        Data is not available.
    </div>
@endif
    
</div>

<a href="{{ route('admin.projects.index') }}" class="btn btn-secondary mt-2">Back to Projects</a>
@endsection
