@extends('layouts.superadmin')
@section('title', 'Subscription Management - Super Admin')

@section('content')
<style>
    .super-hero {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        color: #fff;
        border-radius: 14px;
        padding: 24px 28px;
        margin-bottom: 24px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
    }
    .status-tab {
        font-size: 0.88rem;
        font-weight: 600;
        padding: 8px 16px;
        border-radius: 8px;
        color: #475569;
        background: #f1f5f9;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .status-tab:hover {
        background: #e2e8f0;
        color: #1e293b;
    }
    .status-tab.active {
        background: #0d6efd;
        color: #fff;
    }
    .sub-table thead th {
        background: #0d6efd;
        color: #fff;
        font-weight: 600;
        font-size: 0.82rem;
        text-transform: uppercase;
        border: none;
        padding: 12px 10px;
    }
    .proof-thumbnail {
        width: 48px;
        height: 48px;
        border-radius: 6px;
        object-fit: cover;
        border: 1px solid #cbd5e1;
        cursor: pointer;
        transition: transform 0.2s ease;
    }
    .proof-thumbnail:hover {
        transform: scale(1.1);
    }
</style>

<div class="container-fluid px-0">

    {{-- Header Banner --}}
    <div class="super-hero d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-patch-check-fill text-warning fs-3"></i>
                <h3 class="mb-0 fw-bold">Plan Purchase & Subscription Requests</h3>
            </div>
            <p class="mb-0 mt-1 opacity-75 small">
                Verify user payments, approve/reject plans, and manage subscription validity periods.
            </p>
        </div>
        <div>
            @if($counts['pending'] > 0)
                <span class="badge bg-warning text-dark px-3 py-2 fs-6 shadow-sm">
                    <i class="bi bi-bell-fill me-1"></i> {{ $counts['pending'] }} Pending Verification
                </span>
            @else
                <span class="badge bg-success px-3 py-2 fs-6 shadow-sm">
                    <i class="bi bi-check2-all me-1"></i> All Verified
                </span>
            @endif
        </div>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5 align-middle"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Filter Tabs & Search Bar --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('superadmin.subscriptions.index', ['status' => 'all']) }}"
                       class="status-tab {{ $status === 'all' ? 'active' : '' }}">
                        All <span class="badge {{ $status === 'all' ? 'bg-light text-primary' : 'bg-secondary' }}">{{ $counts['all'] }}</span>
                    </a>
                    <a href="{{ route('superadmin.subscriptions.index', ['status' => 'pending']) }}"
                       class="status-tab {{ $status === 'pending' ? 'active' : '' }}">
                        Pending <span class="badge {{ $status === 'pending' ? 'bg-light text-warning' : 'bg-warning text-dark' }}">{{ $counts['pending'] }}</span>
                    </a>
                    <a href="{{ route('superadmin.subscriptions.index', ['status' => 'active']) }}"
                       class="status-tab {{ $status === 'active' ? 'active' : '' }}">
                        Active <span class="badge {{ $status === 'active' ? 'bg-light text-success' : 'bg-success' }}">{{ $counts['active'] }}</span>
                    </a>
                    <a href="{{ route('superadmin.subscriptions.index', ['status' => 'expired']) }}"
                       class="status-tab {{ $status === 'expired' ? 'active' : '' }}">
                        Expired <span class="badge {{ $status === 'expired' ? 'bg-light text-secondary' : 'bg-secondary' }}">{{ $counts['expired'] }}</span>
                    </a>
                    <a href="{{ route('superadmin.subscriptions.index', ['status' => 'rejected']) }}"
                       class="status-tab {{ $status === 'rejected' ? 'active' : '' }}">
                        Rejected <span class="badge {{ $status === 'rejected' ? 'bg-light text-danger' : 'bg-danger' }}">{{ $counts['rejected'] }}</span>
                    </a>
                </div>

                <form method="GET" action="{{ route('superadmin.subscriptions.index') }}" class="d-flex gap-2">
                    <input type="hidden" name="status" value="{{ $status }}">
                    <input type="text"
                           name="search"
                           value="{{ $search }}"
                           class="form-control form-control-sm"
                           placeholder="Search user, Txn ID, Ref..."
                           style="width: 240px;">
                    <button class="btn btn-primary btn-sm px-3">
                        <i class="bi bi-search"></i>
                    </button>
                    @if($search)
                        <a href="{{ route('superadmin.subscriptions.index', ['status' => $status]) }}" class="btn btn-outline-secondary btn-sm" title="Clear search">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    @endif
                </form>
            </div>
        </div>
    </div>

    {{-- Main Subscriptions Table --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-hover sub-table align-middle w-100">
                    <thead>
                        <tr>
                            <th class="text-center" width="50">#</th>
                            <th>User / Organization</th>
                            <th>Plan Details</th>
                            <th class="text-end">Amount</th>
                            <th>Txn ID & Ref No</th>
                            <th class="text-center">Proof</th>
                            <th class="text-center">Status</th>
                            <th>Validity Period</th>
                            <th class="text-center" width="160">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subscriptions as $index => $sub)
                        <tr>
                            <td class="text-center fw-bold text-muted">{{ $subscriptions->firstItem() + $index }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $sub->user->name ?? 'User #' . $sub->user_id }}</div>
                                <div class="small text-muted">{{ $sub->user->email ?? '-' }}</div>
                                @if(!empty($sub->user->phone))
                                    <div class="small text-secondary"><i class="bi bi-telephone me-1"></i>{{ $sub->user->phone }}</div>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary fw-bold">{{ $sub->plan_name }}</span>
                                <div class="small text-muted mt-1">Duration: <strong>{{ $sub->duration_months }} Month{{ $sub->duration_months > 1 ? 's' : '' }}</strong></div>
                            </td>
                            <td class="text-end fw-bold text-success">
                                ₹ {{ number_format($sub->amount, 2) }}
                            </td>
                            <td>
                                <div class="small">Txn: <code>{{ $sub->transaction_number }}</code></div>
                                <div class="small">Ref: <code>{{ $sub->reference_number }}</code></div>
                                <div class="text-muted" style="font-size: 0.72rem;">{{ $sub->created_at->format('d-M-Y h:i A') }}</div>
                            </td>
                            <td class="text-center">
                                @if($sub->payment_screenshot)
                                    <a href="{{ asset($sub->payment_screenshot) }}" target="_blank" title="View Full Payment Proof">
                                        <img src="{{ asset($sub->payment_screenshot) }}" alt="Proof" class="proof-thumbnail shadow-sm">
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($sub->payment_status === 'approved')
                                    @if($sub->isValid())
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Expired</span>
                                    @endif
                                @elseif($sub->payment_status === 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td class="small">
                                @if($sub->start_date && $sub->expiry_date)
                                    <div><strong>From:</strong> {{ date('d/m/Y', strtotime($sub->start_date)) }}</div>
                                    <div><strong>To:</strong> <span class="text-success fw-semibold">{{ date('d/m/Y', strtotime($sub->expiry_date)) }}</span></div>
                                    @if($sub->isValid())
                                        <div class="badge bg-success-subtle text-success mt-1">{{ $sub->days_remaining }} days left</div>
                                    @endif
                                @else
                                    <span class="text-muted">Not activated</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($sub->payment_status === 'pending')
                                    <div class="d-flex justify-content-center gap-1">
                                        <button type="button"
                                                class="btn btn-success btn-sm approve-btn"
                                                data-id="{{ $sub->id }}"
                                                data-user="{{ $sub->user->name ?? 'User' }}"
                                                data-plan="{{ $sub->plan_name }}"
                                                data-duration="{{ $sub->duration_months }}"
                                                data-amount="{{ number_format($sub->amount, 2) }}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#approveModal">
                                            <i class="bi bi-check-lg me-1"></i>Approve
                                        </button>
                                        <button type="button"
                                                class="btn btn-danger btn-sm reject-btn"
                                                data-id="{{ $sub->id }}"
                                                data-user="{{ $sub->user->name ?? 'User' }}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#rejectModal">
                                            <i class="bi bi-x-lg me-1"></i>Reject
                                        </button>
                                    </div>
                                @elseif($sub->payment_status === 'approved')
                                    <span class="badge bg-light text-success border">
                                        <i class="bi bi-check-circle me-1"></i>Approved
                                    </span>
                                @elseif($sub->payment_status === 'rejected')
                                    <span class="badge bg-light text-danger border" title="{{ $sub->admin_notes }}">
                                        <i class="bi bi-x-circle me-1"></i>Rejected
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                No subscription records found for the selected filter.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $subscriptions->links() }}
            </div>
        </div>
    </div>

</div>

{{-- Approve Modal --}}
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form id="approveForm" method="POST" action="" class="modal-content rounded-4 border-0 shadow">
            @csrf
            <div class="modal-header bg-success text-white rounded-top-4">
                <h5 class="modal-title fw-bold"><i class="bi bi-check-circle me-2"></i> Approve Subscription Plan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-success-subtle border-0 mb-3 small">
                    Approving this payment will activate the plan for <strong id="approveUserName"></strong> and calculate the expiry date automatically.
                </div>

                <div class="p-3 bg-light rounded-3 mb-3">
                    <div class="d-flex justify-content-between small mb-1">
                        <span class="text-muted">Plan:</span>
                        <strong id="approvePlanName" class="text-primary"></strong>
                    </div>
                    <div class="d-flex justify-content-between small mb-1">
                        <span class="text-muted">Duration:</span>
                        <strong id="approveDuration"></strong>
                    </div>
                    <div class="d-flex justify-content-between small">
                        <span class="text-muted">Amount Received:</span>
                        <strong id="approveAmount" class="text-success"></strong>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Subscription Start Date</label>
                    <input type="date"
                           name="start_date"
                           id="approveStartDate"
                           class="form-control form-control-sm"
                           value="{{ date('Y-m-d') }}">
                    <div class="form-text small">Expiry date will be calculated automatically (+1m, +6m, or +12m from start date).</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Admin Notes (Optional)</label>
                    <input type="text"
                           name="admin_notes"
                           class="form-control form-control-sm"
                           placeholder="e.g. Verified against bank statement">
                </div>
            </div>
            <div class="modal-footer bg-light rounded-bottom-4">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success btn-sm px-4 fw-bold">
                    <i class="bi bi-check-lg me-1"></i> Confirm & Activate Plan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Reject Modal --}}
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form id="rejectForm" method="POST" action="" class="modal-content rounded-4 border-0 shadow">
            @csrf
            <div class="modal-header bg-danger text-white rounded-top-4">
                <h5 class="modal-title fw-bold"><i class="bi bi-x-circle me-2"></i> Reject Payment Request</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <p class="small text-muted mb-3">
                    Rejecting payment request for <strong id="rejectUserName"></strong>. Please provide a clear reason so the user knows what went wrong.
                </p>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Rejection Reason <span class="text-danger">*</span></label>
                    <textarea name="admin_notes"
                              class="form-control form-control-sm"
                              rows="3"
                              placeholder="e.g. UTR number mismatch, Payment not credited to merchant account, Screenshot unreadable..."
                              required></textarea>
                </div>
            </div>
            <div class="modal-footer bg-light rounded-bottom-4">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger btn-sm px-4 fw-bold">
                    <i class="bi bi-x-lg me-1"></i> Reject Payment
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const approveButtons = document.querySelectorAll('.approve-btn');
    const approveForm = document.getElementById('approveForm');
    const approveUserName = document.getElementById('approveUserName');
    const approvePlanName = document.getElementById('approvePlanName');
    const approveDuration = document.getElementById('approveDuration');
    const approveAmount = document.getElementById('approveAmount');

    approveButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const user = this.getAttribute('data-user');
            const plan = this.getAttribute('data-plan');
            const duration = this.getAttribute('data-duration');
            const amount = this.getAttribute('data-amount');

            approveForm.action = '{{ url("superadmin/subscriptions") }}/' + id + '/approve';
            if (approveUserName) approveUserName.textContent = user;
            if (approvePlanName) approvePlanName.textContent = plan;
            if (approveDuration) approveDuration.textContent = duration + ' Month(s)';
            if (approveAmount) approveAmount.textContent = '₹ ' + amount;
        });
    });

    const rejectButtons = document.querySelectorAll('.reject-btn');
    const rejectForm = document.getElementById('rejectForm');
    const rejectUserName = document.getElementById('rejectUserName');

    rejectButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const user = this.getAttribute('data-user');

            rejectForm.action = '{{ url("superadmin/subscriptions") }}/' + id + '/reject';
            if (rejectUserName) rejectUserName.textContent = user;
        });
    });
});
</script>
@endpush
