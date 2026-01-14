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
                                    <th class="text-center">#</th>
                                    <th class="text-center">NAME OF THE USER</th>
                                    <th class="text-center">DOJ</th>
                                    <th class="text-center">DOL</th>
                                    <th class="text-center">STATE</th>
                                    <th class="text-center">CONTACT NUMBER</th>
                                    <th class="text-center">EMAIL ID</th>
                                    <th class="text-center">DESIGNATION</th>
                                    <th class="text-center">MONTHLY SALARY </th>
                                    <th class="text-center">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($users->count() > 0)
                                @php $serial = 1; @endphp
                                    @foreach($users as $user)
                                        <tr>
                                            <td class="text-center">
                                                    {{ $serial++ }}
                                            </td>
                                            <td class="text-center">
                                                {{ $user->name }}

                                            </td>
                                            <td class="text-center">
                                                @if($user->state)
                                                        {{ $user->state }}
                                                @else
                                                    <span class="text-muted fst-italic">Not provided</span>
                                                @endif
                                            </td>
                                            <td class="text-center">



                                                    {{ $user->date_of_joining ? date('d M Y', strtotime($user->date_of_joining)) : '-' }}



                                            </td>
                                            <td class="text-center">

                                                    {{ $user->date_of_leaving ? date('d M Y', strtotime($user->date_of_leaving)) : '-' }}


                                            </td>
                                            <td class="text-center">

                                                    {{ $user->phone ?? '-' }}
                                            </td>
                                            <td class="text-center">


                                                    {{ $user->email }}

                                            </td>
                                            <td class="text-center">
                                                    {{ $user->designation ?? '-' }}
                                            </td>
                                            <td class="text-center">
                                                    {{ $user->monthly_salary ?? '-' }}
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex align-items-center">
                                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning me-2">
                                                    Edit
                                                    </a>
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
                                @else
                                    <tr>
                                        <td colspan="10" class="text-center">No Data Found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>

</div>

@endsection
