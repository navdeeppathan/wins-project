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
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        {{-- <span class="stat-change positive">↑ 12.5%</span> --}}
                    </div>
                    <div class="stat-value">{{$totalProjects}}</div>
                    <div class="stat-label">Total Projects</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="stat-value">{{$totalAwarded}}</div>
                    <div class="stat-label">Total Awarded</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                        </div>
                    </div>
                    <div class="stat-value">{{$totalEmd}}</div>
                    <div class="stat-label">Total EMd</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/>
                            </svg>
                        </div>
                    </div>
                    <div class="stat-value">{{$totalVendors}}</div>
                    <div class="stat-label">Total Vendors</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="stat-value">{{$totalStaff}}</div>
                    <div class="stat-label">Total Staff</div>
                </div>
            </div>
            <div class="dashboard-section">
    <h4 class="section-title">Latest Projects</h4>

    <div class="table-responsive">
        <table class="table table-sm table-bordered" id="example">
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
                    <tr>
                        <td>{{ $project->id }}</td>
                        <td>{{ Str::limit($project->name, 50) }}</td>
                        <td>
                            <span class="badge bg-info">
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
</div>

<div class="dashboard-section">
    <h4 class="section-title">Top Vendors</h4>

    <table class="table table-sm table-bordered" id="example">
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
                    <td>{{ $vendor->name }}</td>
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

<div class="dashboard-section" >
    <h4 class="section-title">Top Inventory</h4>
    <table class="table table-sm table-bordered" id="example">
        <thead>
            <tr>
                <th>#</th>
                <th>Item</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @forelse($totalTopStock as $stock)
                <tr>
                    <td>{{ $stock->id }}</td>
                    <td>{{ $stock->description }}</td>
                    <td>{{ number_format($stock->amount ?? 0, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">No stock found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>


<script>
    new DataTable('#example', {
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
@stack('scripts')
@endsection

