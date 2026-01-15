
@extends('layouts.superadmin')

@section('title', 'Create User')

@section('content')

<div class="container-fluid py-4">


    {{-- PAGE TITLE --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="page-title">User Management</h2>
    </div>

    <div class="card">
        <div class="card-body">

            @if($users->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped nowrap w-100 example class-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name of User</th>
                                <th>DOJ</th>
                                <th>DOL</th>
                                <th>State</th>
                                <th>Contact Number</th>
                                <th>Email ID</th>
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

                                    <td>
                                        {{ $user->date_of_joining
                                            ? date('d M Y', strtotime($user->date_of_joining))
                                            : '-' }}
                                    </td>
                                    <td>
                                        {{ $user->date_of_leaving
                                            ? date('d M Y', strtotime($user->date_of_leaving))
                                            : '-' }}
                                    </td>
                                    <td>{{ $user->state ?? 'Not provided' }}</td>
                                    <td>{{ $user->phone ?? '-' }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        {{-- <a href="{{ route('superadmin.users.allprojects', $user->id) }}"
                                           class="btn btn-sm btn-primary">Projects</a>  --}}
                                        <div class="d-flex justify-between gap-2" >
                                            <a href="{{ route('superadmin.users.allusers', $user->id) }}"
                                            class="btn btn-sm btn-primary">All Users</a>
                                            <a href="{{ route('superadmin.users.transactions', $user->id) }}"
                                                class="btn btn-sm btn-success">
                                                Transactions
                                            </a>
                                        </div>
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

