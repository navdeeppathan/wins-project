@extends('layouts.admin')

@section('title', 'Create User')

@section('content')


<div class="container-fluid py-4">

    {{-- ================= PAGE TITLE ================= --}}
   <div class="d-flex align-items-center justify-content-between flex-wrap">
     <h2 class="page-title">User Management</h2>
     <button class="btn btn-primary">
       <a href="{{ route('admin.users.create') }}" class="text-white text-decoration-none"><i class="fas fa-plus-circle me-2"></i>Create User</a>
     </button>
   </div>




    {{-- ================= USERS LIST ================= --}}
    <div class="row">
        <div class="col-12">

            <div class="card card-elegant ">
                {{-- <div class="header-elegant">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <div class="d-flex align-items-center">

                            <h5>Registered Users</h5>
                        </div>
                        <span class="badge badge-elegant bg-white text-primary">
                            {{ $users->count() }} Total Users
                        </span>
                    </div>
                </div> --}}

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="example" class="table class-table nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NAME OF THE USER</th>
                                    <th>DOJ</th>
                                    <th>DOL</th>
                                    <th>STATE</th>
                                    <th>CONTACT NUMBER</th>
                                    <th>EMAIL ID</th>
                                    <th>DESIGNATION</th>
                                    <th>MONTHLY SALARY </th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>
                                                {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            {{ $user->name }}

                                        </td>
                                        <td>
                                            @if($user->state)
                                                    {{ $user->state }}
                                            @else
                                                <span class="text-muted fst-italic">Not provided</span>
                                            @endif
                                        </td>
                                        <td>



                                                {{ $user->date_of_joining ? date('d M Y', strtotime($user->date_of_joining)) : '-' }}



                                        </td>
                                        <td>

                                                {{ $user->date_of_leaving ? date('d M Y', strtotime($user->date_of_leaving)) : '-' }}


                                        </td>
                                        <td>

                                                {{ $user->phone ?? '-' }}
                                        </td>
                                        <td>


                                                {{ $user->email }}

                                        </td>
                                        <td>
                                                {{ $user->designation ?? '-' }}
                                        </td>
                                        <td>
                                                {{ $user->monthly_salary ?? '-' }}
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                {{-- <a href="{{ route('superadmin.users.edit', $user->id) }}" class="btn btn-sm btn-primary me-2">
                                                    <i class="fas fa-edit"></i>
                                                </a> --}}
                                                {{-- <form action="{{ route('superadmin.users.destroy', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form> --}}

                                                <a href="{{ route('admin.users.details.index', $user->id) }}"
                                                    class="btn btn-sm btn-primary me-2">
                                                    View
                                                </a>


                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="empty-state">
                                            <h5 class="mt-3 mb-2">No Users Found</h5>
                                            <p class="text-muted mb-0">Start by creating your first user account above.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>

</div>

@endsection
