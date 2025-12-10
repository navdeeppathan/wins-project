@extends('layouts.admin')

@section('title','Billing')

@section('content')
<h3 class="mb-2">Billing – Project #{{ $project->id }} ({{ $project->nit_number }})</h3>
<p class="text-muted mb-3">Status: <strong>{{ ucfirst($project->status) }}</strong></p>

<div class="row">
    {{-- Create Bill --}}
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-header bg-light">
                <strong>Create Bill</strong>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.projects.billing.store', $project) }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label">Bill No *</label>
                        <input type="text" name="bill_number" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Bill Date *</label>
                        <input type="date" name="bill_date" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Type *</label>
                        <select name="bill_type" class="form-select" required>
                            <option value="running">Running</option>
                            <option value="final">Final</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">MB No *</label>
                        <input type="text" name="mb_number" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Page No *</label>
                        <input type="text" name="page_number" class="form-control" required>
                    </div>
                    <button class="btn btn-primary btn-sm mt-1">Create Bill</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Bill List + Items / Recoveries --}}
    <div class="col-md-8 mb-3">
        @forelse($billings as $bill)
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Bill #{{ $bill->bill_number }}</strong>
                        <span class="badge bg-secondary">{{ ucfirst($bill->bill_type) }}</span>
                        <small class="ms-2 text-muted">Date: {{ $bill->bill_date }}</small>
                    </div>
                    <div>
                        <span class="badge bg-info">Gross: {{ number_format($bill->gross_amount,2) }}</span>
                        <span class="badge bg-warning text-dark">Recovery: {{ number_format($bill->total_recovery,2) }}</span>
                        <span class="badge bg-success">Net: {{ number_format($bill->net_payable,2) }}</span>
                        @if($bill->status !== 'approved')
                            <form action="{{ route('admin.billing.approve', $bill) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-success">Approve</button>
                            </form>
                        @else
                            <span class="badge bg-success ms-1">Approved</span>
                        @endif
                        <form action="{{ route('admin.billing.destroy', $bill) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Delete this bill?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Del</button>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    {{-- Add Item --}}
                    <form action="{{ route('admin.billing.items.store', $bill) }}" method="POST" class="row g-2 mb-3">
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
                    </form>

                    {{-- Items Table --}}
                    <table class="table table-sm table-bordered mb-3">
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
                    </table>

                    {{-- Recoveries Form --}}
                    <form action="{{ route('admin.billing.recovery.store', $bill) }}" method="POST">
                        @csrf
                        <div class="row g-2">
                            @php
                                $r = $bill->recovery ?? null;
                            @endphp
                            <div class="col-md-3">
                                <label class="form-label">Security</label>
                                <input type="number" step="0.01" name="security" value="{{ $r->security ?? 0 }}" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Income Tax</label>
                                <input type="number" step="0.01" name="income_tax" value="{{ $r->income_tax ?? 0 }}" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Labour Cess</label>
                                <input type="number" step="0.01" name="labour_cess" value="{{ $r->labour_cess ?? 0 }}" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Water Charges</label>
                                <input type="number" step="0.01" name="water_charges" value="{{ $r->water_charges ?? 0 }}" class="form-control form-control-sm">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">License Fee</label>
                                <input type="number" step="0.01" name="license_fee" value="{{ $r->license_fee ?? 0 }}" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">CGST</label>
                                <input type="number" step="0.01" name="cgst" value="{{ $r->cgst ?? 0 }}" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">SGST</label>
                                <input type="number" step="0.01" name="sgst" value="{{ $r->sgst ?? 0 }}" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Withheld 1</label>
                                <input type="number" step="0.01" name="withheld_1" value="{{ $r->withheld_1 ?? 0 }}" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Withheld 2</label>
                                <input type="number" step="0.01" name="withheld_2" value="{{ $r->withheld_2 ?? 0 }}" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Total (auto)</label>
                                <input type="number" step="0.01" class="form-control form-control-sm" value="{{ $r->total ?? 0 }}" disabled>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button class="btn btn-sm btn-warning w-100">Save Recoveries</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        @empty
            <p>No bills yet for this project.</p>
        @endforelse
    </div>
</div>

<a href="{{ route('admin.projects.index') }}" class="btn btn-secondary mt-2">Back to Projects</a>
@endsection
