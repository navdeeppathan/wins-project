@extends('layouts.admin')

@section('title','Projects')

@section('content')
<style>
.dashboard-section {
    margin-top: 30px;
}

.section-title {
    font-weight: 600;
    margin-bottom: 12px;
}
</style>

            <div class="page-header">
                <h1 class="page-title">Dashboard</h1>
                <p class="page-subtitle">Welcome back! Here's an overview of your email marketing performance.</p>
            </div>


           <div class="stats-grid">

    {{-- Total Projects in Bidding --}}
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-width="2" d="M12 4a4 4 0 100 8M4 20a8 8 0 0116 0"/>
                </svg>
            </div>
        </div>
        <div class="stat-value">{{ $totalBidding }}</div>
        <div class="stat-label">Projects in Bidding</div>
    </div>

    {{-- Total Awarded Projects --}}
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-width="2" d="M3 8l9 6 9-6M5 19h14V7H5z"/>
                </svg>
            </div>
        </div>
        <div class="stat-value">{{ $totalAwarded }}</div>
        <div class="stat-label">Awarded Projects</div>
    </div>

    {{-- Total Work Done --}}
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-width="2" d="M12 2l9 18-9-3-9 3z"/>
                </svg>
            </div>
        </div>
        <div class="stat-value">₹ {{ number_format($totalWorkDone ?? 0, 2) }}</div>
        <div class="stat-label">Total Work Done</div>
    </div>

    {{-- EMD Due in 1 Month --}}
    <div class="stat-card border-warning">
        <div class="stat-header">
            <div class="stat-icon text-warning">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0"/>
                </svg>
            </div>
        </div>
        <div class="stat-value">₹ {{ number_format($totalEmdDue ?? 0, 2) }}</div>
        <div class="stat-label">EMD Due (Next 30 Days)</div>
    </div>

    {{-- PG Due in 1 Month --}}
    <div class="stat-card border-danger">
        <div class="stat-header">
            <div class="stat-icon text-danger">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-width="2" d="M9 12h6M12 9v6"/>
                </svg>
            </div>
        </div>
        <div class="stat-value">₹ {{ number_format($totalPgDue ?? 0, 2) }}</div>
        <div class="stat-label">PG Due (Next 30 Days)</div>
    </div>

    {{-- Security Due in 1 Month --}}
    <div class="stat-card border-danger">
        <div class="stat-header">
            <div class="stat-icon text-danger">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-width="2" d="M12 2l7 4v6c0 5-3 9-7 10-4-1-7-5-7-10V6z"/>
                </svg>
            </div>
        </div>
        <div class="stat-value">₹ {{ number_format($totalSecurityDue ?? 0, 2) }}</div>
        <div class="stat-label">Security Due (Next 30 Days)</div>
    </div>

    {{-- Projects Completing Soon --}}
    <div class="stat-card border-info">
        <div class="stat-header">
            <div class="stat-icon text-info">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-width="2" d="M8 7V3m8 4V3M3 11h18"/>
                </svg>
            </div>
        </div>
        <div class="stat-value">{{ $projectsCompletingSoon }}</div>
        <div class="stat-label">Projects Completing Next Month</div>
    </div>

    {{-- Delayed Projects --}}
    <div class="stat-card border-danger">
        <div class="stat-header">
            <div class="stat-icon text-danger">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-width="2" d="M12 8v4m0 4h.01"/>
                </svg>
            </div>
        </div>
        <div class="stat-value">{{ $projectsDelayed }}</div>
        <div class="stat-label">Delayed Projects</div>
    </div>

    {{-- Total Vendors --}}
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-width="2" d="M3 10h18M7 15h1m4 0h1"/>
                </svg>
            </div>
        </div>
        <div class="stat-value">{{ $totalVendors }}</div>
        <div class="stat-label">Total Vendors</div>
    </div>

    {{-- Total Staff --}}
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-width="2" d="M5 20h14V8H5zM12 4v4"/>
                </svg>
            </div>
        </div>
        <div class="stat-value">{{ $totalStaff }}</div>
        <div class="stat-label">Total Staff</div>
    </div>

    {{-- Total Stock Value --}}
    <div class="stat-card border-success">
        <div class="stat-header">
            <div class="stat-icon text-success">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-width="2" d="M20 7l-8-4-8 4v10l8 4 8-4z"/>
                </svg>
            </div>
        </div>
        <div class="stat-value">₹ {{ number_format($totalStockValue ?? 0, 2) }}</div>
        <div class="stat-label">Stock Value (Stores)</div>
    </div>

</div>

{{-- ================= LATEST PROJECTS ================= --}}
{{-- <div class="dashboard-section">
    <h4 class="section-title">Latest Projects</h4>

    <div class="table-responsive">
        <table class="table table-sm table-bordered class-table" id="projectsTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Project Name</th>
                    <th>Status</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse($totalTopProjects as $project)
                    @php
                        $badge = match($project->status) {
                            'awarded' => 'success',
                            'pending' => 'warning',
                            'cancelled' => 'danger',
                            default => 'info'
                        };
                    @endphp
                    <tr>
                        <td>{{ $project->id }}</td>
                        <td>{{ Str::limit($project->name, 50) }}</td>
                        <td>
                            <span class="badge bg-{{ $badge }}">
                                {{ ucfirst($project->status) }}
                            </span>
                        </td>
                        <td>{{ number_format($project->estimated_amount ?? 0, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No projects found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div> --}}

{{-- ================= TOP VENDORS ================= --}}
{{-- <div class="dashboard-section">
    <h4 class="section-title">Top Vendors</h4>

    <div class="table-responsive">
        <table class="table table-sm table-bordered class-table" id="vendorsTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Vendor Name</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse($totalTopVendors as $vendor)
                    <tr>
                        <td>{{ $vendor->id }}</td>
                        <td>{{ $vendor->vendor_agency_name }}</td>
                        <td>{{ number_format($vendor->amount ?? 0, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No vendors found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div> --}}

{{-- ================= TOP INVENTORY ================= --}}
@if($totalInventory->count() > 0)

<div class="dashboard-section">
    <h4 class="section-title">Top Inventory</h4>

    <div class="table-responsive">
        <table class="table table-sm table-bordered class-table" id="inventoryTable">
            <thead >
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Item</th>
                    <th class="text-center">Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse($totalInventory as $stock)
                    <tr>
                        <td class="text-center">{{ $stock->id }}</td>
                        <td class="text-center">{{ $stock->description }}</td>
                        <td class="text-center">{{ number_format($stock->amount ?? 0, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No inventory found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
{{-- @else --}}
    {{-- <div class="alert alert-warning text-center">
        Data is not available. Start Your Projects.
    </div> --}}
@endif

@endsection

@push('scripts')
<script>
    function initStyledDataTable(selector) {
        if ($.fn.DataTable.isDataTable(selector)) {
            $(selector).DataTable().destroy();
        }

        new DataTable(selector, {
            scrollX: true,
            autoWidth: false,
            createdRow: function (row, data, index) {
                const bg = index % 2 === 0 ? '#D7E2F2' : '#B4C5E6';
                $('td', row).css('background-color', bg);
            },
            rowCallback: function (row, data, index) {
                const base = index % 2 === 0 ? '#D7E2F2' : '#B4C5E6';
                $(row)
                    .hover(
                        () => $('td', row).css('background-color', '#eef2ff'),
                        () => $('td', row).css('background-color', base)
                    );
            }
        });
    }

    $(document).ready(function () {
        initStyledDataTable('#projectsTable');
        initStyledDataTable('#vendorsTable');
        initStyledDataTable('#inventoryTable');
    });
</script>
@endpush

