@extends('layouts.admin')
@section('title', 'Analysis of Rates - Estimates')

@section('content')
<style>
    .aor-header {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: #fff;
        border-radius: 12px;
        padding: 22px 26px;
        margin-bottom: 24px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }
    .aor-header h3 {
        font-weight: 700;
        margin-bottom: 4px;
        font-size: 1.5rem;
    }
    .aor-header p {
        margin: 0;
        opacity: 0.85;
        font-size: 0.9rem;
    }
    .aor-table-card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        background: #fff;
    }
    .aor-table thead th {
        background: #0d6efd;
        color: #fff;
        font-weight: 600;
        font-size: 0.84rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
        vertical-align: middle;
        padding: 12px 10px;
    }
    .rate-final-badge {
        font-size: 0.9rem;
        font-weight: 700;
        color: #198754;
    }
    .code-badge {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 4px;
        background: #e7f1ff;
        color: #0d6efd;
    }
</style>

<div class="container-fluid px-0">

    {{-- Header Banner --}}
    <div class="aor-header d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-calculator-fill fs-3"></i>
                <h3 class="mb-0">Analysis of Rates (DAR)</h3>
            </div>
            <p>Derive detailed unit rates based on Material, Labour, Machinery, Overheads & Taxes.</p>
        </div>
        <div>
            <button class="btn btn-light text-primary fw-semibold px-3 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#addAorModal">
                <i class="bi bi-plus-circle-fill me-1"></i> Analysis Item
            </button>
        </div>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Main Table Card --}}
    <div class="card aor-table-card shadow-sm">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table id="aorTable" class="table table-hover aor-table align-middle w-100">
                    <thead>
                        <tr>
                            <th class="text-center" width="50">#</th>
                            <th width="100">Item Code</th>
                            <th>Description of Item</th>
                            <th class="text-center" width="70">Unit</th>
                            <th class="text-end">Material (₹)</th>
                            <th class="text-end">Labour (₹)</th>
                            <th class="text-end">Carriage / Mach (₹)</th>
                            <th class="text-end">Total Rate (₹)</th>
                            <th class="text-center" width="80">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $index => $item)
                        <tr>
                            <td class="text-center fw-bold text-muted">{{ $index + 1 }}</td>
                            <td><span class="code-badge">{{ $item->item_code ?? 'ITEM' }}</span></td>
                            <td class="fw-semibold">{{ $item->description }}</td>
                            <td class="text-center">{{ $item->unit ?? 'SQM' }}</td>
                            <td class="text-end">₹ {{ number_format($item->material_cost, 2) }}</td>
                            <td class="text-end">₹ {{ number_format($item->labour_cost, 2) }}</td>
                            <td class="text-end">₹ {{ number_format(($item->carriage_cost ?? 0) + ($item->machinery_cost ?? 0), 2) }}</td>
                            <td class="text-end rate-final-badge">₹ {{ number_format($item->total_rate, 2) }}</td>
                            <td class="text-center">
                                <form action="{{ route('admin.analysis-of-rates.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this item?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- Add Modal --}}
<div class="modal fade" id="addAorModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('admin.analysis-of-rates.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-plus-circle me-1"></i> Add Rate Analysis</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Item Code / DSR No</label>
                    <input type="text" name="item_code" class="form-control" placeholder="e.g. 2.1, 4.1.3">
                </div>
                <div class="col-md-5">
                    <label class="form-label fw-semibold">Description of Item *</label>
                    <input type="text" name="description" class="form-control" required placeholder="e.g. Earth work in excavation">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Unit</label>
                    <input type="text" name="unit" class="form-control" value="CUM" placeholder="CUM / SQM / METRE">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Material Cost (₹)</label>
                    <input type="number" step="0.01" name="material_cost" class="form-control aor-calc" value="0.00">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Labour Cost (₹)</label>
                    <input type="number" step="0.01" name="labour_cost" class="form-control aor-calc" value="0.00">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Carriage (₹)</label>
                    <input type="number" step="0.01" name="carriage_cost" class="form-control aor-calc" value="0.00">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Machinery (₹)</label>
                    <input type="number" step="0.01" name="machinery_cost" class="form-control aor-calc" value="0.00">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Water Charges (%)</label>
                    <input type="number" step="0.01" name="water_charges_percent" class="form-control aor-calc" value="1.00">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Contractor Profit (%)</label>
                    <input type="number" step="0.01" name="contractor_profit_percent" class="form-control aor-calc" value="15.00">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">GST (%)</label>
                    <input type="number" step="0.01" name="gst_percent" class="form-control aor-calc" value="18.00">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Remarks</label>
                    <input type="text" name="remarks" class="form-control" placeholder="Optional notes or references">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Save Analysis</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    if ($('#aorTable').length) {
        $('#aorTable').DataTable({
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
            responsive: true,
            language: {
                emptyTable: "No Analysis of Rate items defined yet. Click '+ Analysis Item' above to create one."
            }
        });
    }
});
</script>
@endpush
