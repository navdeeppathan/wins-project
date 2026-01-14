@extends('layouts.admin')

@section('title', 'User Management')

@section('content')

<div class="container-fluid py-4">

    {{-- PAGE TITLE --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="page-title">User Management</h2>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i>Create User
        </a>
    </div>

    <div class="card">
        <div class="card-body">

            @if($users->count() > 0)
                <div class="table-responsive">
                    <table id="example" class="table table-bordered table-striped nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name of User</th>
                                <th>DOJ</th>
                                <th>DOL</th>
                                <th>State</th>
                                <th>Contact Number</th>
                                <th>Email ID</th>
                                <th>Designation</th>
                                <th>Monthly Salary</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($users as $index => $user)
                                <tr>
                                    {{-- 1 --}}
                                    <td>{{ $index + 1 }}</td>

                                    {{-- 2 --}}
                                    <td>{{ $user->name }}</td>

                                    {{-- 3 DOJ --}}
                                    <td>
                                        {{ $user->date_of_joining
                                            ? date('d M Y', strtotime($user->date_of_joining))
                                            : '-' }}
                                    </td>

                                    {{-- 4 DOL --}}
                                    <td>
                                        {{ $user->date_of_leaving
                                            ? date('d M Y', strtotime($user->date_of_leaving))
                                            : '-' }}
                                    </td>

                                    {{-- 5 STATE --}}
                                    <td>{{ $user->state ?? 'Not provided' }}</td>

                                    {{-- 6 CONTACT --}}
                                    <td>{{ $user->phone ?? '-' }}</td>

                                    {{-- 7 EMAIL --}}
                                    <td>{{ $user->email }}</td>

                                    {{-- 8 DESIGNATION --}}
                                    <td>{{ $user->designation ?? '-' }}</td>

                                    {{-- 9 SALARY --}}
                                    <td>{{ $user->monthly_salary ?? '-' }}</td>

                                    {{-- 10 ACTION --}}
                                    <td>
                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                           class="btn btn-sm btn-warning">Edit</a>

                                        <a href="{{ route('admin.users.details.index', $user->id) }}"
                                           class="btn btn-sm btn-primary">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center p-4">
                    <h5>No Users Found</h5>
                </div>
            @endif

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#example').DataTable({
            responsive: true,
            autoWidth: false,
            pageLength: 10
        });
    });
</script>
@endpush
