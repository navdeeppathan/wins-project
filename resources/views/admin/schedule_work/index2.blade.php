@extends('layouts.admin')

@section('title','Schedule of Work')

@section('content')
<div class="container">
    <h4 class="mb-3">Schedule of Work</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Add Form -->
    <div class="card mb-4">
        <div class="card-header">Add Work Item</div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.schedule-work.store') }}">
                @csrf
                <div class="row g-3">

                    <input type="hidden" name="project_id" value="{{ $project->id }}">

                    <div class="col-md-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="2" required></textarea>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Quantity</label>
                        <input type="number" step="0.01" name="quantity" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Unit</label>
                        <input type="text" name="unit" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Rate</label>
                        <input type="number" step="0.01" name="rate" class="form-control" required>
                    </div>

                    <div class="col-md-2 align-self-end">
                        <button class="btn btn-primary w-100">Add</button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-header">Work List</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Unit</th>
                        <th>Rate</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($works as $work)
                        <tr>
                            <td>{{ $work->id }}</td>
                            <td>{{ $work->description }}</td>
                            <td>{{ $work->quantity }}</td>
                            <td>{{ $work->unit }}</td>
                            <td>₹ {{ number_format($work->rate, 2) }}</td>
                            <td>₹ {{ number_format($work->amount, 2) }}</td>
                            <td>
                                <a href="{{ route('admin.schedule-work.edit', $work) }}"
                                   class="btn btn-sm btn-warning">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No records found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection


