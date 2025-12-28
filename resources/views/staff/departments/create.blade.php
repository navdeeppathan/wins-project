@extends('layouts.staff')

@section('title','Create Department')

@section('content')
<style>
    .dept-title {
        font-weight: 600;
        color: #0d6efd;
    }
    .dept-form-card {
        border-radius: 8px;
        max-width: 600px;
        margin: auto;
    }
</style>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="dept-title">Add Department</h3>
        <a href="{{ route('departments.index') }}" class="btn btn-secondary btn-sm">Back</a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm dept-form-card">
        <div class="card-body">
            <form action="{{ route('departments.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label">Department Name</label>
                    {{-- <input type="text" name="name" value="{{ old('name') }}" class="form-control"> --}}
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" style="text-transform: uppercase;">
                    @error('name')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('departments.index') }}" class="btn btn-light">Cancel</a>
            </form>
        </div>
    </div>

</div>
@endsection
