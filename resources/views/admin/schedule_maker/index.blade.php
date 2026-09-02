@extends('layouts.admin')
@section('title', 'Schedule Maker - Estimates')

@section('content')
<style>
    .estimate-page-header {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: #fff;
        border-radius: 12px;
        padding: 22px 26px;
        margin-bottom: 24px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }
    .estimate-page-header h3 {
        font-weight: 700;
        margin-bottom: 4px;
        font-size: 1.5rem;
    }
    .estimate-page-header p {
        margin: 0;
        opacity: 0.85;
        font-size: 0.9rem;
    }
    .kpi-card {
        border-radius: 10px;
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: transform 0.2s ease;
        background: #fff;
    }
    .kpi-card:hover {
        transform: translateY(-2px);
    }
    .kpi-card .card-body {
        padding: 16px 20px;
    }
    .kpi-title {
        font-size: 0.78rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
        margin-bottom: 4px;
    }
    .kpi-val {
        font-size: 1.35rem;
        font-weight: 700;
        color: #212529;
        margin: 0;
    }
    .kpi-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    .schedule-table-card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        background: #fff;
    }
    .schedule-table thead th {
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
    .project-name-cell {
        max-width: 340px;
    }
    .project-title-text {
        font-weight: 600;
        color: #1e3c72;
        display: block;
        margin-bottom: 4px;
        line-height: 1.35;
    }
    .nit-badge {
        font-size: 0.72rem;
        font-weight: 500;
        padding: 2px 8px;
        border-radius: 4px;
        background: #e9ecef;
        color: #495057;
        display: inline-block;
    }
    .action-btn-group .btn {
        font-size: 0.78rem;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 6px;
        margin: 2px;
        transition: all 0.2s ease;
    }
    .btn-sow {
        background: #0d6efd;
        color: #fff;
        border: none;
    }
    .btn-sow:hover {
        background: #0b5ed7;
        color: #fff;
    }
    .btn-mb {
        background: #198754;
        color: #fff;
        border: none;
    }
    .btn-mb:hover {
        background: #157347;
        color: #fff;
    }
    .btn-inv {
        background: #6f42c1;
        color: #fff;
        border: none;
    }
    .btn-inv:hover {
        background: #59359a;
        color: #fff;
    }
    .dept-badge {
        font-size: 0.75rem;
        background: #e7f1ff;
        color: #0d6efd;
        border-radius: 6px;
        padding: 3px 8px;
        font-weight: 500;
        display: inline-block;
    }
    .state-badge {
        font-size: 0.75rem;
        background: #f8f9fa;
        color: #6c757d;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        padding: 2px 7px;
        display: inline-block;
    }
    .filter-card {
        border-radius: 10px;
        background: #fff;
        border: 1px solid #e9ecef;
        padding: 14px 20px;
        margin-bottom: 20px;
    }
</style>

<div class="container-fluid px-0">

    {{-- Header Banner --}}
    <div class="estimate-page-header d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-calendar2-range-fill fs-3"></i>
                <h3 class="mb-0">Schedule Maker</h3>
            </div>
            <p>Prepare, itemize and manage project work schedules, measurements & contingency inventories.</p>
        </div>
        <div>
            <span class="badge bg-light text-dark px-3 py-2 fs-6 shadow-sm">
                <i class="bi bi-folder-check me-1 text-primary"></i> {{ $projects->count() }} Projects
            </span>
        </div>
    </div>

    {{-- KPI Summary Cards --}}
    @php
        $totalEst = $projects->sum('estimated_amount');
        $totalEmd = $projects->sum('emd_amount');
        $deptCount = $projects->pluck('department')->unique()->filter()->count();
    @endphp
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card kpi-card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="kpi-title">Total Projects</div>
                        <div class="kpi-val text-primary">{{ number_format($projects->count()) }}</div>
                    </div>
                    <div class="kpi-icon bg-primary-subtle text-primary">
                        <i class="bi bi-briefcase-fill"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card kpi-card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="kpi-title">Total Estimated Amt</div>
                        <div class="kpi-val text-success">₹ {{ number_format($totalEst, 2) }}</div>
                    </div>
                    <div class="kpi-icon bg-success-subtle text-success">
                        <i class="bi bi-currency-rupee"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card kpi-card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="kpi-title">Total EMD Amt</div>
                        <div class="kpi-val text-warning">₹ {{ number_format($totalEmd, 2) }}</div>
                    </div>
                    <div class="kpi-icon bg-warning-subtle text-warning">
                        <i class="bi bi-shield-lock-fill"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card kpi-card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="kpi-title">Departments</div>
                        <div class="kpi-val text-info">{{ $deptCount }}</div>
                    </div>
                    <div class="kpi-icon bg-info-subtle text-info">
                        <i class="bi bi-building"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Bar --}}
    @php
        use Carbon\Carbon;
        $startFY = 2011;
        $today = Carbon::today();
        $currentFY = $today->month >= 4 ? $today->year : $today->year - 1;
    @endphp
    <div class="filter-card shadow-sm">
        <form method="GET" action="{{ route('admin.schedule-maker.index') }}" class="row align-items-center g-3">
            <div class="col-auto">
                <label class="form-label mb-0 fw-semibold text-muted small">
                    <i class="bi bi-funnel me-1"></i>Filter by Financial Year:
                </label>
            </div>
            <div class="col-md-3 col-sm-6">
                <select name="fy" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">All Financial Years</option>
                    @for ($fy = $startFY; $fy <= $currentFY; $fy++)
                        @php $label = $fy . '-' . ($fy + 1); @endphp
                        <option value="{{ $fy }}" {{ request('fy') == $fy ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endfor
                </select>
            </div>
            @if(request('fy'))
            <div class="col-auto">
                <a href="{{ route('admin.schedule-maker.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-x-circle me-1"></i>Reset Filter
                </a>
            </div>
            @endif
        </form>
    </div>

    {{-- Main Table --}}
    @if($projects->count() > 0)
    <div class="card schedule-table-card shadow-sm">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table id="scheduleMakerTable" class="table table-hover schedule-table align-middle w-100">
                    <thead>
                        <tr>
                            <th class="text-center" width="50">#</th>
                            <th>Project & NIT</th>
                            <th>Location / Dept</th>
                            <th class="text-end">Estimate Amt</th>
                            <th class="text-end">EMD Amt</th>
                            <th class="text-center">Opening Date</th>
                            <th class="text-center" width="250">Schedule Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach($projects as $p)
                        <tr>
                            <td class="text-center fw-bold text-muted">{{ $i }}</td>
                            <td class="project-name-cell">
                                <span class="project-title-text">{{ $p->name }}</span>
                                @if($p->nit_number)
                                    <span class="nit-badge"><i class="bi bi-file-earmark-text me-1"></i>{{ $p->nit_number }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex flex-column gap-1">
                                    <span class="dept-badge">{{ $p->departments->name ?? '-' }}</span>
                                    <span class="state-badge"><i class="bi bi-geo-alt me-1"></i>{{ $p->state->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="text-end fw-semibold text-success">
                                ₹ {{ number_format($p->estimated_amount, 2) }}
                            </td>
                            <td class="text-end fw-semibold text-muted">
                                ₹ {{ number_format($p->emd_amount ?? 0, 2) }}
                            </td>
                            <td class="text-center small text-muted">
                                @if($p->date_of_opening)
                                    <i class="bi bi-calendar3 me-1"></i>{{ date('d-m-Y', strtotime($p->date_of_opening)) }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="action-btn-group d-flex justify-content-center flex-wrap">
                                    <a href="{{ route('admin.projects.schedule-work', $p) }}"
                                       class="btn btn-sow"
                                       title="Schedule of Work">
                                        <i class="bi bi-card-checklist me-1"></i>+ SOW
                                    </a>
                                    <a href="{{ route('admin.projects.schedule-work.mbindex', $p) }}"
                                       class="btn btn-mb"
                                       title="Measurement Book">
                                        <i class="bi bi-rulers me-1"></i>+ MB
                                    </a>
                                    <a href="{{ route('admin.projects.schedule-work.inventoryindex', $p) }}"
                                       class="btn btn-inv"
                                       title="Contingency Inventory">
                                        <i class="bi bi-boxes me-1"></i>+ Inv
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @php $i++; @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
        <div class="card shadow-sm border-0 text-center py-5">
            <div class="card-body">
                <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                <h5 class="fw-bold">No Projects Found</h5>
                <p class="text-muted">No projects found for the selected financial year.</p>
            </div>
        </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    if ($('#scheduleMakerTable').length) {
        $('#scheduleMakerTable').DataTable({
            pageLength: 5,
            lengthMenu: [5, 10, 25, 50, 100],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search schedule...",
                lengthMenu: "Show _MENU_ entries"
            },
            order: [[0, 'asc']]
        });
    }
});
</script>
@endpush
