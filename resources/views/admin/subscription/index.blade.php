@extends('layouts.admin')
@section('title', 'Subscription Plans - DigiProject')

@section('content')
<style>
    .sub-hero {
        background: linear-gradient(135deg, #0d3b66 0%, #001e3d 100%);
        color: #fff;
        border-radius: 14px;
        padding: 28px 32px;
        margin-bottom: 28px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        position: relative;
        overflow: hidden;
    }
    .sub-hero::after {
        content: '';
        position: absolute;
        right: -30px;
        bottom: -30px;
        width: 180px;
        height: 180px;
        background: rgba(255, 255, 255, 0.04);
        border-radius: 50%;
    }
    .plan-card {
        border-radius: 14px;
        border: 2px solid #e9ecef;
        background: #fff;
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        position: relative;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .plan-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
        border-color: #0d6efd;
    }
    .plan-card.featured {
        border-color: #f59e0b;
        box-shadow: 0 8px 25px rgba(245, 158, 11, 0.15);
    }
    .plan-badge {
        position: absolute;
        top: 14px;
        right: 14px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 4px 10px;
        border-radius: 20px;
    }
    .plan-price-box {
        background: #f8fafc;
        border-radius: 10px;
        padding: 16px;
        margin: 16px 0;
        text-align: center;
    }
    .plan-price-main {
        font-size: 2rem;
        font-weight: 800;
        color: #1e293b;
        line-height: 1;
    }
    .plan-price-gst {
        font-size: 0.85rem;
        color: #64748b;
        margin-top: 4px;
    }
    .feature-list {
        list-style: none;
        padding: 0;
        margin: 0 0 20px 0;
        flex-grow: 1;
    }
    .feature-list li {
        font-size: 0.88rem;
        color: #475569;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .feature-list li i {
        color: #10b981;
        font-size: 1rem;
        flex-shrink: 0;
    }
    .qr-payment-box {
        background: #fdfdfd;
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
    }
    .qr-image-wrapper {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px;
        display: inline-block;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        max-width: 280px;
    }
    .qr-image-wrapper img {
        width: 100%;
        height: auto;
        border-radius: 8px;
    }
    .history-card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        background: #fff;
    }
    .history-table thead th {
        background: #0d6efd;
        color: #fff;
        font-weight: 600;
        font-size: 0.82rem;
        text-transform: uppercase;
        border: none;
        padding: 12px 10px;
    }
</style>

<div class="container-fluid px-0">

    {{-- Hero Section --}}
    <div class="sub-hero d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-shield-check fs-2 text-warning"></i>
                <h3 class="mb-0 fw-bold">Plan Purchase & Subscription Management</h3>
            </div>
            <p class="mb-0 mt-2 opacity-75">
                Centralise your data, summarise your workflow, and utilise your resources with DigiProject.
            </p>
        </div>
        <div>
            @if($activeSubscription)
                <span class="badge bg-success px-3 py-2 fs-6 shadow-sm">
                    <i class="bi bi-check-circle-fill me-1"></i> Active: {{ $activeSubscription->plan_name }} ({{ $activeSubscription->days_remaining }} days left)
                </span>
            @elseif($pendingSubscription)
                <span class="badge bg-warning text-dark px-3 py-2 fs-6 shadow-sm">
                    <i class="bi bi-clock-history me-1"></i> Payment Verification Pending
                </span>
            @else
                <span class="badge bg-danger px-3 py-2 fs-6 shadow-sm">
                    <i class="bi bi-exclamation-octagon-fill me-1"></i> No Active Subscription
                </span>
            @endif
        </div>
    </div>

    {{-- Flash Alerts --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5 align-middle"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-5 align-middle"></i>
            {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Active Subscription Status Card (If exists) --}}
    @if($activeSubscription)
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: linear-gradient(135deg, #e0f2fe 0%, #f0fdf4 100%); border-left: 5px solid #10b981 !important;">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="badge bg-success">ACTIVE PLAN</span>
                        <h4 class="fw-bold mb-0 text-dark">{{ $activeSubscription->plan_name }}</h4>
                    </div>
                    <p class="text-muted mb-2">
                        Activated on <strong>{{ $activeSubscription->start_date ? date('d-M-Y', strtotime($activeSubscription->start_date)) : '-' }}</strong> • 
                        Valid until <strong class="text-success">{{ $activeSubscription->expiry_date ? date('d-M-Y', strtotime($activeSubscription->expiry_date)) : '-' }}</strong>
                    </p>
                    <div class="small text-secondary">
                        <i class="bi bi-receipt me-1"></i> Txn: <code>{{ $activeSubscription->transaction_number }}</code> • 
                        Ref: <code>{{ $activeSubscription->reference_number }}</code> • 
                        Amount: <strong>₹ {{ number_format($activeSubscription->amount, 2) }}</strong>
                    </div>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="display-6 fw-bold text-success mb-0">{{ $activeSubscription->days_remaining }}</div>
                    <div class="text-muted small fw-semibold text-uppercase">Days Remaining</div>
                </div>
            </div>
        </div>
    </div>
    @elseif($pendingSubscription)
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: #fffbeb; border-left: 5px solid #f59e0b !important;">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-hourglass-split text-warning fs-1"></i>
                <div>
                    <h5 class="fw-bold text-dark mb-1">Payment Verification in Progress</h5>
                    <p class="text-muted mb-1">
                        You have submitted a payment of <strong>₹ {{ number_format($pendingSubscription->amount, 2) }}</strong> for the <strong>{{ $pendingSubscription->plan_name }}</strong>.
                    </p>
                    <div class="small text-muted">
                        Txn ID: <code>{{ $pendingSubscription->transaction_number }}</code> • Ref ID: <code>{{ $pendingSubscription->reference_number }}</code> • Submitted on {{ $pendingSubscription->created_at->format('d-M-Y h:i A') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Plans Grid --}}
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="fw-bold mb-1">Select Subscription Plan</h4>
                <p class="text-muted small mb-0">Choose the billing period that fits your organization.</p>
            </div>
        </div>

        <div class="row g-4">
            @foreach($plans as $plan)
            @php
                $isFeatured = $plan->slug === 'yearly';
                $badgeText = $plan->badge ?? ($plan->slug === 'yearly' ? 'Best Value' : ($plan->slug === 'half_yearly' ? 'Popular' : 'Standard'));
                $badgeBg = $plan->slug === 'yearly' ? 'bg-warning text-dark' : ($plan->slug === 'half_yearly' ? 'bg-primary text-white' : 'bg-secondary text-white');
            @endphp
            <div class="col-lg-4 col-md-6">
                <div class="plan-card p-4 {{ $isFeatured ? 'featured' : '' }}">
                    <span class="plan-badge {{ $badgeBg }}">{{ $badgeText }}</span>

                    <h4 class="fw-bold text-dark mb-1">{{ $plan->name }}</h4>
                    <p class="text-muted small mb-0">{{ $plan->description ?? 'Full access to DigiProject tools.' }}</p>

                    <div class="plan-price-box">
                        <div class="plan-price-main">
                            ₹ {{ number_format($plan->price, 0) }}
                        </div>
                        <div class="plan-price-gst">
                            + 18% GST = <strong>₹ {{ number_format($plan->total_price, 0) }}</strong>
                        </div>
                        <div class="text-muted small mt-1">
                            Validity: <strong>{{ $plan->duration_months }} Month{{ $plan->duration_months > 1 ? 's' : '' }}</strong>
                        </div>
                    </div>

                    <ul class="feature-list">
                        @if(is_array($plan->features))
                            @foreach($plan->features as $f)
                                <li><i class="bi bi-check-circle-fill"></i> {{ $f }}</li>
                            @endforeach
                        @else
                            <li><i class="bi bi-check-circle-fill"></i> Full Access to Project Management</li>
                            <li><i class="bi bi-check-circle-fill"></i> BOQ, Measurements & Rate Items</li>
                            <li><i class="bi bi-check-circle-fill"></i> Billing & Recoveries Automation</li>
                            <li><i class="bi bi-check-circle-fill"></i> Validity for {{ $plan->duration_months }} Month{{ $plan->duration_months > 1 ? 's' : '' }}</li>
                        @endif
                    </ul>

                    <button type="button"
                            class="btn {{ $isFeatured ? 'btn-warning text-dark fw-bold' : 'btn-primary' }} w-100 py-2 rounded-3 shadow-sm select-plan-btn"
                            data-plan-slug="{{ $plan->slug }}"
                            data-plan-name="{{ $plan->name }}"
                            data-plan-price="{{ number_format($plan->total_price, 2) }}"
                            data-plan-duration="{{ $plan->duration_months }}"
                            data-bs-toggle="modal"
                            data-bs-target="#paymentModal">
                        <i class="bi bi-qr-code-scan me-1"></i> Scan QR & Purchase
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Subscription History Table --}}
    <div class="card history-card shadow-sm mt-5">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2 text-primary"></i>My Payment & Subscription History</h5>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-hover history-table align-middle w-100">
                    <thead>
                        <tr>
                            <th class="text-center" width="50">#</th>
                            <th>Plan Name</th>
                            <th class="text-end">Amount</th>
                            <th>Txn ID</th>
                            <th>Ref No</th>
                            <th class="text-center">Payment Status</th>
                            <th class="text-center">Subscription Status</th>
                            <th>Validity Period</th>
                            <th class="text-center">Proof</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($history as $index => $item)
                        <tr>
                            <td class="text-center fw-bold text-muted">{{ $index + 1 }}</td>
                            <td class="fw-semibold text-dark">{{ $item->plan_name }}</td>
                            <td class="text-end fw-bold text-success">₹ {{ number_format($item->amount, 2) }}</td>
                            <td><code>{{ $item->transaction_number }}</code></td>
                            <td><code>{{ $item->reference_number }}</code></td>
                            <td class="text-center">
                                @if($item->payment_status === 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($item->payment_status === 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($item->subscription_status === 'active')
                                    <span class="badge bg-success">Active</span>
                                @elseif($item->subscription_status === 'expired')
                                    <span class="badge bg-secondary">Expired</span>
                                @elseif($item->subscription_status === 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td class="small">
                                @if($item->start_date && $item->expiry_date)
                                    {{ date('d/m/Y', strtotime($item->start_date)) }} to {{ date('d/m/Y', strtotime($item->expiry_date)) }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($item->payment_screenshot)
                                    <a href="{{ asset($item->payment_screenshot) }}" target="_blank" class="btn btn-sm btn-outline-primary" title="View Screenshot">
                                        <i class="bi bi-image"></i>
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="small text-muted">{{ $item->admin_notes ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-1 text-secondary"></i>
                                No previous subscription or payment records found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if(method_exists($history, 'links'))
                <div class="mt-3">
                    {{ $history->links() }}
                </div>
            @endif
        </div>
    </div>

</div>

{{-- Payment & QR Code Modal --}}
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form action="{{ route('subscription.store') }}" method="POST" enctype="multipart/form-data" class="modal-content rounded-4 border-0 shadow">
            @csrf
            <div class="modal-header bg-primary text-white rounded-top-4">
                <h5 class="modal-title fw-bold" id="paymentModalLabel">
                    <i class="bi bi-qr-code me-2"></i> Scan QR & Submit Payment Proof
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-4">
                    {{-- Left Column: QR Code Box --}}
                    <div class="col-md-5 text-center">
                        <div class="qr-payment-box">
                            <h6 class="fw-bold text-dark mb-2">Merchant QR Code</h6>
                            <div class="qr-image-wrapper mb-2">
                                <img src="{{ asset('QR2.jpg') }}" alt="DigiProject Bank of Baroda UPI QR Code">
                            </div>
                            <div class="small fw-semibold text-dark">UPI VPA:</div>
                            <div class="badge bg-light text-primary border px-2 py-1 user-select-all mb-2">
                                solut93503135@barodampay
                            </div>
                            <p class="small text-muted mb-0">
                                Scan with Google Pay, PhonePe, Paytm, BHIM, or any UPI app.
                            </p>
                        </div>
                    </div>

                    {{-- Right Column: Payment Form --}}
                    <div class="col-md-7">
                        <div class="p-3 bg-light rounded-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small">Selected Plan:</span>
                                <strong id="modalPlanName" class="text-primary fs-6">Yearly Plan</strong>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-1">
                                <span class="text-muted small">Payable Amount (incl. GST):</span>
                                <strong id="modalPlanPrice" class="text-success fs-5">₹ 70,800.00</strong>
                            </div>
                        </div>

                        {{-- Hidden Plan Input --}}
                        <input type="hidden" name="plan_slug" id="modalPlanSlug" value="yearly">

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Choose Plan</label>
                            <select id="modalPlanSelector" class="form-select form-select-sm">
                                @foreach($plans as $plan)
                                    <option value="{{ $plan->slug }}"
                                            data-name="{{ $plan->name }}"
                                            data-price="{{ number_format($plan->total_price, 2) }}">
                                        {{ $plan->name }} - ₹ {{ number_format($plan->total_price, 0) }} ({{ $plan->duration_months }} Mo)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">UPI Transaction ID / UTR Number <span class="text-danger">*</span></label>
                            <input type="text"
                                   name="transaction_number"
                                   class="form-control form-control-sm"
                                   placeholder="e.g. 423589123456"
                                   required>
                            <div class="form-text small">12-digit transaction ID or UTR from your payment app.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Reference / Order ID <span class="text-danger">*</span></label>
                            <input type="text"
                                   name="reference_number"
                                   class="form-control form-control-sm"
                                   placeholder="e.g. REF-{{ strtoupper(substr(md5(time()), 0, 8)) }}"
                                   value="REF-{{ strtoupper(substr(md5(time()), 0, 8)) }}"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Upload Payment Screenshot <span class="text-danger">*</span></label>
                            <input type="file"
                                   name="payment_screenshot"
                                   class="form-control form-control-sm"
                                   accept="image/*,application/pdf"
                                   required>
                            <div class="form-text small">Screenshot showing Successful Payment, Date & UTR (Max 6MB).</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light rounded-bottom-4">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success btn-sm px-4 fw-bold">
                    <i class="bi bi-send-check me-1"></i> Submit Payment Proof
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const planButtons = document.querySelectorAll('.select-plan-btn');
    const modalPlanSlug = document.getElementById('modalPlanSlug');
    const modalPlanName = document.getElementById('modalPlanName');
    const modalPlanPrice = document.getElementById('modalPlanPrice');
    const modalPlanSelector = document.getElementById('modalPlanSelector');

    function updateModalPlan(slug, name, price) {
        if (modalPlanSlug) modalPlanSlug.value = slug;
        if (modalPlanName) modalPlanName.textContent = name;
        if (modalPlanPrice) modalPlanPrice.textContent = '₹ ' + price;
        if (modalPlanSelector) modalPlanSelector.value = slug;
    }

    planButtons.forEach(button => {
        button.addEventListener('click', function() {
            const slug = this.getAttribute('data-plan-slug');
            const name = this.getAttribute('data-plan-name');
            const price = this.getAttribute('data-plan-price');
            updateModalPlan(slug, name, price);
        });
    });

    if (modalPlanSelector) {
        modalPlanSelector.addEventListener('change', function() {
            const selectedOpt = this.options[this.selectedIndex];
            const slug = this.value;
            const name = selectedOpt.getAttribute('data-name');
            const price = selectedOpt.getAttribute('data-price');
            updateModalPlan(slug, name, price);
        });
    }
});
</script>
@endpush
