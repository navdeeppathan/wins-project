@extends('layouts.superadmin')
@section('title', 'Plan Pricing & Features Management - Super Admin')

@section('content')
<style>
    .plans-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #fff;
        border-radius: 14px;
        padding: 24px 28px;
        margin-bottom: 24px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
    }
    .plans-table thead th {
        background: #0d6efd;
        color: #fff;
        font-weight: 600;
        font-size: 0.82rem;
        text-transform: uppercase;
        border: none;
        padding: 12px 10px;
    }
    .original-price-strike {
        text-decoration: line-through;
        color: #94a3b8;
        font-size: 0.8rem;
    }
    .feature-pill {
        display: inline-block;
        font-size: 0.74rem;
        background: #f1f5f9;
        color: #334155;
        border-radius: 4px;
        padding: 2px 7px;
        margin: 2px;
        border: 1px solid #e2e8f0;
    }
</style>

<div class="container-fluid px-0">

    {{-- Hero Banner --}}
    <div class="plans-hero d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-tags-fill text-warning fs-3"></i>
                <h3 class="mb-0 fw-bold">Subscription Plans & Pricing Management</h3>
            </div>
            <p class="mb-0 mt-1 opacity-75 small">
                Add, edit, or customize subscription packages, base prices, discounts, GST rates, and feature checklists.
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('superadmin.subscriptions.index') }}" class="btn btn-outline-light btn-sm px-3">
                <i class="bi bi-clock-history me-1"></i> View Purchase Requests
            </a>
            <button class="btn btn-warning text-dark fw-bold btn-sm px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#createPlanModal">
                <i class="bi bi-plus-circle-fill me-1"></i> Create Plan
            </button>
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

    {{-- Plans List Card --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-grid-fill me-2 text-primary"></i>All Configured Plans ({{ $plans->count() }})</h5>
            <span class="small text-muted">Active plans appear on the user checkout page.</span>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-hover plans-table align-middle w-100">
                    <thead>
                        <tr>
                            <th class="text-center" width="50">#</th>
                            <th>Plan Name & Badge</th>
                            <th class="text-center">Duration</th>
                            <th class="text-end">Original Price</th>
                            <th class="text-end">Base Price</th>
                            <th class="text-center">GST Rate</th>
                            <th class="text-end">Total Price</th>
                            <th>Features Checklist</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" width="140">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($plans as $index => $plan)
                        <tr>
                            <td class="text-center fw-bold text-muted">{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <strong class="text-dark">{{ $plan->name }}</strong>
                                    @if($plan->badge)
                                        <span class="badge bg-warning text-dark" style="font-size: 0.7rem;">{{ $plan->badge }}</span>
                                    @endif
                                </div>
                                <div class="small text-muted">Slug: <code>{{ $plan->slug }}</code></div>
                                <div class="small text-secondary mt-1">{{ Str::limit($plan->description, 60) }}</div>
                            </td>
                            <td class="text-center fw-semibold">
                                {{ $plan->duration_months }} Month{{ $plan->duration_months > 1 ? 's' : '' }}
                            </td>
                            <td class="text-end">
                                @if($plan->original_price && $plan->original_price > $plan->price)
                                    <span class="original-price-strike">₹ {{ number_format($plan->original_price, 2) }}</span>
                                    <div class="small text-success fw-semibold">
                                        Save {{ round((($plan->original_price - $plan->price) / $plan->original_price) * 100) }}%
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-end fw-bold text-dark">
                                ₹ {{ number_format($plan->price, 2) }}
                            </td>
                            <td class="text-center text-muted small">
                                {{ number_format($plan->gst_percent, 0) }}%
                            </td>
                            <td class="text-end fw-bold text-success fs-6">
                                ₹ {{ number_format($plan->total_price, 2) }}
                            </td>
                            <td>
                                @if(is_array($plan->features) && count($plan->features) > 0)
                                    <div style="max-width: 260px;">
                                        @foreach(array_slice($plan->features, 0, 3) as $feat)
                                            <span class="feature-pill"><i class="bi bi-check me-1 text-success"></i>{{ Str::limit($feat, 28) }}</span>
                                        @endforeach
                                        @if(count($plan->features) > 3)
                                            <span class="badge bg-light text-muted border" style="font-size: 0.68rem;">+{{ count($plan->features) - 3 }} more</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-muted small">No features defined</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <form action="{{ route('superadmin.plans.toggle-status', $plan->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm p-0 border-0" title="Click to toggle status">
                                        @if($plan->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </button>
                                </form>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <button type="button"
                                            class="btn btn-outline-primary btn-sm edit-plan-btn"
                                            data-id="{{ $plan->id }}"
                                            data-name="{{ $plan->name }}"
                                            data-slug="{{ $plan->slug }}"
                                            data-badge="{{ $plan->badge }}"
                                            data-duration="{{ $plan->duration_months }}"
                                            data-original-price="{{ $plan->original_price }}"
                                            data-price="{{ $plan->price }}"
                                            data-gst="{{ $plan->gst_percent }}"
                                            data-description="{{ $plan->description }}"
                                            data-features="{{ is_array($plan->features) ? implode("\n", $plan->features) : '' }}"
                                            data-is-active="{{ $plan->is_active ? '1' : '0' }}"
                                            data-sort-order="{{ $plan->sort_order }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editPlanModal"
                                            title="Edit Plan">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <form action="{{ route('superadmin.plans.destroy', $plan->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this plan?');"
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete Plan">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                No subscription plans found. Click <strong>"Create Plan"</strong> to add one.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- Create Plan Modal --}}
<div class="modal fade" id="createPlanModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form action="{{ route('superadmin.plans.store') }}" method="POST" class="modal-content rounded-4 border-0 shadow">
            @csrf
            <div class="modal-header bg-primary text-white rounded-top-4">
                <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2"></i> Create New Subscription Plan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Plan Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control form-control-sm" placeholder="e.g. Quarterly Plan, Enterprise Plan" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">Slug (Optional)</label>
                    <input type="text" name="slug" class="form-control form-control-sm" placeholder="e.g. quarterly">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">Badge / Highlight</label>
                    <input type="text" name="badge" class="form-control form-control-sm" placeholder="e.g. Most Popular, Special Offer">
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold small">Duration (Months) <span class="text-danger">*</span></label>
                    <input type="number" name="duration_months" class="form-control form-control-sm" min="1" max="60" value="1" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">Original Price (₹)</label>
                    <input type="number" step="0.01" name="original_price" class="form-control form-control-sm" placeholder="e.g. 7000.00">
                    <div class="form-text small">Strikethrough discount price.</div>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">Offer / Base Price (₹) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" name="price" id="createBasePrice" class="form-control form-control-sm" placeholder="5900.00" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">GST Rate (%)</label>
                    <input type="number" step="0.01" name="gst_percent" id="createGst" class="form-control form-control-sm" value="18.00">
                </div>

                <div class="col-12">
                    <div class="p-2 bg-light rounded text-end small">
                        Calculated Total Price (Payable): <strong id="createCalcTotal" class="text-success fs-6">₹ 0.00</strong>
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold small">Description</label>
                    <input type="text" name="description" class="form-control form-control-sm" placeholder="Brief tagline or description">
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold small">Plan Features List (One feature per line) <span class="text-danger">*</span></label>
                    <textarea name="features" rows="5" class="form-control form-control-sm" placeholder="Full Access to Project Management&#10;Bill of Quantity (BOQ) & Measurements&#10;Basic Rates & Schedule Maker&#10;Priority Technical Support" required></textarea>
                    <div class="form-text small">Each line will become a bullet point with a green checkmark icon.</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control form-control-sm" value="1">
                </div>
                <div class="col-md-6 d-flex align-items-center mt-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="createIsActive" checked value="1">
                        <label class="form-check-label fw-semibold small" for="createIsActive">Active (Show on Checkout)</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light rounded-bottom-4">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold">
                    <i class="bi bi-check-circle me-1"></i> Save Plan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Plan Modal --}}
<div class="modal fade" id="editPlanModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form id="editPlanForm" method="POST" action="" class="modal-content rounded-4 border-0 shadow">
            @csrf
            @method('PUT')
            <div class="modal-header bg-primary text-white rounded-top-4">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i> Edit Subscription Plan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Plan Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="editName" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">Slug <span class="text-danger">*</span></label>
                    <input type="text" name="slug" id="editSlug" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">Badge / Highlight</label>
                    <input type="text" name="badge" id="editBadge" class="form-control form-control-sm">
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold small">Duration (Months) <span class="text-danger">*</span></label>
                    <input type="number" name="duration_months" id="editDuration" class="form-control form-control-sm" min="1" max="60" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">Original Price (₹)</label>
                    <input type="number" step="0.01" name="original_price" id="editOriginalPrice" class="form-control form-control-sm">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">Base Price (₹) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" name="price" id="editBasePrice" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">GST Rate (%)</label>
                    <input type="number" step="0.01" name="gst_percent" id="editGst" class="form-control form-control-sm">
                </div>

                <div class="col-12">
                    <div class="p-2 bg-light rounded text-end small">
                        Calculated Total Price (Payable): <strong id="editCalcTotal" class="text-success fs-6">₹ 0.00</strong>
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold small">Description</label>
                    <input type="text" name="description" id="editDescription" class="form-control form-control-sm">
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold small">Plan Features List (One feature per line) <span class="text-danger">*</span></label>
                    <textarea name="features" id="editFeatures" rows="6" class="form-control form-control-sm" required></textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Sort Order</label>
                    <input type="number" name="sort_order" id="editSortOrder" class="form-control form-control-sm">
                </div>
                <div class="col-md-6 d-flex align-items-center mt-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="editIsActive" value="1">
                        <label class="form-check-label fw-semibold small" for="editIsActive">Active (Show on Checkout)</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light rounded-bottom-4">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold">
                    <i class="bi bi-save me-1"></i> Update Plan Details
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto calculate total for Create
    const createBase = document.getElementById('createBasePrice');
    const createGst = document.getElementById('createGst');
    const createTotal = document.getElementById('createCalcTotal');

    function calcCreateTotal() {
        const base = parseFloat(createBase.value) || 0;
        const gst = parseFloat(createGst.value) || 0;
        const total = base + (base * (gst / 100));
        createTotal.textContent = '₹ ' + total.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }
    if (createBase && createGst) {
        createBase.addEventListener('input', calcCreateTotal);
        createGst.addEventListener('input', calcCreateTotal);
    }

    // Auto calculate total for Edit
    const editBase = document.getElementById('editBasePrice');
    const editGst = document.getElementById('editGst');
    const editTotal = document.getElementById('editCalcTotal');

    function calcEditTotal() {
        const base = parseFloat(editBase.value) || 0;
        const gst = parseFloat(editGst.value) || 0;
        const total = base + (base * (gst / 100));
        editTotal.textContent = '₹ ' + total.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }
    if (editBase && editGst) {
        editBase.addEventListener('input', calcEditTotal);
        editGst.addEventListener('input', calcEditTotal);
    }

    // Edit modal populator
    const editButtons = document.querySelectorAll('.edit-plan-btn');
    const editForm = document.getElementById('editPlanForm');

    editButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            editForm.action = '{{ url("superadmin/plans") }}/' + id;

            document.getElementById('editName').value = this.getAttribute('data-name') || '';
            document.getElementById('editSlug').value = this.getAttribute('data-slug') || '';
            document.getElementById('editBadge').value = this.getAttribute('data-badge') || '';
            document.getElementById('editDuration').value = this.getAttribute('data-duration') || 1;
            document.getElementById('editOriginalPrice').value = this.getAttribute('data-original-price') || '';
            document.getElementById('editBasePrice').value = this.getAttribute('data-price') || '';
            document.getElementById('editGst').value = this.getAttribute('data-gst') || 18;
            document.getElementById('editDescription').value = this.getAttribute('data-description') || '';
            document.getElementById('editFeatures').value = this.getAttribute('data-features') || '';
            document.getElementById('editSortOrder').value = this.getAttribute('data-sort-order') || 1;
            document.getElementById('editIsActive').checked = this.getAttribute('data-is-active') === '1';

            calcEditTotal();
        });
    });
});
</script>
@endpush
