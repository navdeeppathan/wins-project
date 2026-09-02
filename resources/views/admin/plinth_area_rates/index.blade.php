@extends('layouts.admin')
@section('title', 'Plinth Area Rates - Estimates')

@section('content')
<style>
    .par-header {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: #fff;
        border-radius: 12px;
        padding: 22px 26px;
        margin-bottom: 24px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }
    .par-header h3 {
        font-weight: 700;
        margin-bottom: 4px;
        font-size: 1.5rem;
    }
    .par-header p {
        margin: 0;
        opacity: 0.85;
        font-size: 0.9rem;
    }
    .par-table-card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        background: #fff;
    }
    .par-table thead th {
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
    .rate-badge {
        font-size: 0.85rem;
        font-weight: 700;
        color: #198754;
    }
</style>

<div class="container-fluid px-0">

    {{-- Header Banner --}}
    <div class="par-header d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-building-gear fs-3"></i>
                <h3 class="mb-0">Plinth Area Rates (PAR)</h3>
            </div>
            <p>Standard built-up area rates for preliminary architectural cost estimations.</p>
        </div>
        <div>
            <button class="btn btn-light text-primary fw-semibold px-3 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#addParModal">
                <i class="bi bi-plus-circle-fill me-1"></i> Plinth Area Rate
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
    <div class="card par-table-card shadow-sm">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table id="parTable" class="table table-hover par-table align-middle w-100">
                    <thead>
                        <tr>
                            <th class="text-center" width="50">#</th>
                            <th>Category</th>
                            <th>Building Type / Structure</th>
                            <th class="text-center">Storeys</th>
                            <th class="text-center">Unit</th>
                            <th class="text-end">Basic Rate (₹)</th>
                            <th class="text-center">Cost Index</th>
                            <th class="text-end">Effective Rate (₹)</th>
                            <th>Remarks</th>
                            <th class="text-center" width="80">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rates as $index => $rate)
                        <tr>
                            <td class="text-center fw-bold text-muted">{{ $index + 1 }}</td>
                            <td><span class="badge bg-primary-subtle text-primary">{{ $rate->category ?? 'General' }}</span></td>
                            <td class="fw-semibold">{{ $rate->building_type }}</td>
                            <td class="text-center">{{ $rate->no_of_storeys ?? '-' }}</td>
                            <td class="text-center">{{ $rate->unit ?? 'SQM' }}</td>
                            <td class="text-end fw-semibold">₹ {{ number_format($rate->basic_rate, 2) }}</td>
                            <td class="text-center">{{ number_format($rate->cost_index, 0) }}%</td>
                            <td class="text-end rate-badge">₹ {{ number_format($rate->effective_rate, 2) }}</td>
                            <td class="text-muted small">{{ $rate->remarks ?? '-' }}</td>
                            <td class="text-center">
                                <form action="{{ route('admin.plinth-area-rates.destroy', $rate->id) }}" method="POST" onsubmit="return confirm('Delete this rate?')">
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
<div class="modal fade" id="addParModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('admin.plinth-area-rates.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-plus-circle me-1"></i> Add Plinth Area Rate</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Category</label>
                    <input type="text" name="category" class="form-control" placeholder="e.g. Residential, Office, Hospital">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Building Type *</label>
                    <input type="text" name="building_type" class="form-control" required placeholder="e.g. RCC Framed Structure">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">No. of Storeys</label>
                    <input type="text" name="no_of_storeys" class="form-control" placeholder="e.g. G+1, G+3, Multi-Storeyed">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Unit</label>
                    <input type="text" name="unit" class="form-control" value="SQM" placeholder="SQM / SQFT">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Basic Rate (₹) *</label>
                    <input type="number" step="0.01" name="basic_rate" class="form-control" required placeholder="0.00">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Cost Index (%)</label>
                    <input type="number" step="0.01" name="cost_index" class="form-control" value="100.00" placeholder="100">
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Remarks</label>
                    <input type="text" name="remarks" class="form-control" placeholder="Optional notes or specifications">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Save Rate</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    if ($('#parTable').length) {
        $('#parTable').DataTable({
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
            responsive: true,
            language: {
                emptyTable: "No Plinth Area Rates defined yet. Click '+ Plinth Area Rate' above to add one."
            }
        });
    }
});
</script>
@endpush
