@extends('layouts.admin')

@section('title','Tools & Plants')

@section('content')
<h3 class="mb-3">T & P (Tools & Plants Expenses)</h3>

<div class="row">
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-header bg-light">
                <strong>Add T & P Expense</strong>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.tandp.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- <div class="mb-2">
                        <label class="form-label">Project ID *</label>
                        <input type="number" name="project_id" class="form-control" required>
                    </div> --}}

                    <div class="mb-2">
                        <label class="form-label">Project*</label>
                        <select name="project_id" class="form-select">
                            <option value="">Select Project</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}"
                                    {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                    {{ $project->name ?? 'Project #'.$project->id }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Date *</label>
                        <input type="date" name="expense_date" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Category</label>
                        <input type="text" name="category" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Paid To</label>
                        <input type="text" name="paid_to" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Voucher No</label>
                        <input type="text" name="voucher_no" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Quantity</label>
                        <input type="number" step="0.01" name="quantity" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Amount *</label>
                        <input type="number" step="0.01" name="amount" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Deduction</label>
                        <input type="number" step="0.01" name="deduction" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Upload Voucher</label>
                        <input type="file" name="file" class="form-control">
                    </div>
                    <button class="btn btn-primary btn-sm">Save</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8 mb-3">
        <table class="table table-sm table-bordered">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Project</th>
                    <th>Date</th>
                    <th>Desc</th>
                    <th>Amount</th>
                    <th>Net</th>
                    <th>Voucher</th>
                    <th width="80">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $r)
                    <tr>
                        <td>{{ $r->id }}</td>
                        <td>{{ $r->project_id }}</td>
                        <td>{{ $r->expense_date }}</td>
                        <td>{{ $r->description }}</td>
                        <td>{{ number_format($r->amount,2) }}</td>
                        <td>{{ number_format($r->net_payable,2) }}</td>
                        <td>
                            @if($r->file)
                                <a href="{{ asset('storage/'.$r->file) }}" target="_blank">View</a>
                            @endif
                        </td>
                        <td>
                            {{-- add delete if needed --}}
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center">No T & P records.</td></tr>
                @endforelse
            </tbody>
        </table>

        {{ $records->links() }}
    </div>
</div>
@endsection
