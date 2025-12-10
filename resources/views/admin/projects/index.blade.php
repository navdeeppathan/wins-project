@extends('layouts.admin')

@section('title','Projects')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Projects (Bidding)</h3>
    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">+ Create Project</a>
</div>

<table class="table table-bordered table-sm align-middle">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>NIT No</th>
            <th>Department</th>
            <th>Location</th>
            <th>Estimated</th>
            <th>Date of Opening</th>
            <th>Status</th>
            <th width="160">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($projects as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->nit_number }}</td>
                <td>{{ $p->department }}</td>
                <td>{{ $p->location }}</td>
                <td>{{ number_format($p->estimated_amount,2) }}</td>
                <td>{{ $p->date_of_opening }}</td>
                <td><span class="badge bg-info">{{ ucfirst($p->status) }}</span></td>
                <td>
                    <a href="{{ route('admin.projects.edit', $p) }}" class="btn btn-sm btn-warning">Edit</a>
                    <a href="{{ route('admin.projects.billing.index', $p) }}" class="btn btn-sm btn-secondary">
                        Billing
                    </a>
                    <form action="{{ route('admin.projects.destroy', $p) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Delete this project?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Del</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="8" class="text-center">No projects yet.</td></tr>
        @endforelse
    </tbody>
</table>

{{ $projects->links() }}
@endsection
