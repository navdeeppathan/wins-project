@extends('layouts.admin')

@section('title','Departments')

@section('content')
<style>
    .dept-title {
        font-weight: 600;
        color: #0d6efd;
    }
    .dept-card {
        border-radius: 8px;
    }
    .dept-table thead {
        background: #0d6efd;
        color: #fff;
    }
    .dept-table tbody tr:hover {
        background: #f1f1f1;
    }
    .action-btns .btn {
        margin-right: 5px;
    }
</style>

<div class="container py-4">

    {{-- Header & Button --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="dept-title">Departments</h3>
        <a href="{{ route('departments.create') }}" class="btn btn-primary btn-sm">
            + Add Department
        </a>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Table --}}
    <div class="card dept-card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered dept-table text-center">
                <thead>
                    <tr>
                        <th width="80">ID</th>
                        <th>Name</th>
                        <th width="150">User ID</th>
                        <th width="180">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($departments as $dept)
                    <tr>
                        <td>{{ $dept->id }}</td>
                        <td>{{ $dept->name }}</td>
                        <td>{{ $dept->user_id ?? '-' }}</td>
                        <td class="action-btns">
                            <a href="{{ route('departments.edit', $dept->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('departments.destroy', $dept->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete this department?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-muted py-3">No departments found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
