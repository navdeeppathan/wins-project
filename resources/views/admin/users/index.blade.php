@extends('layouts.admin')

@section('title', 'Create User')

@section('content')

<style>
    .gradient-bg {
        background:  #667eea ;
    }

    .card-elegant {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-elegant:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
    }

    .form-control-elegant {
        border: 2px solid #e8ecf1;
        border-radius: 12px;
        padding: 14px 20px;
        font-size: 15px;
        transition: all 0.3s ease;
        background-color: #f8f9fa;
    }

    .form-control-elegant:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
        background-color: #fff;
        transform: translateY(-2px);
    }

    .btn-gradient {
        background:  #667eea;
        border: none;
        border-radius: 12px;
        padding: 14px 30px;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
    }

    .btn-gradient::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s;
    }

    .btn-gradient:hover::before {
        left: 100%;
    }

    .header-elegant {
        background:  #667eea;
        color: white;
        padding: 10px 20px;
        border-radius: 20px 20px 0 0;
    }

    .header-elegant h5 {
        margin: 0;
        font-weight: 700;
        font-size: 1.4rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .table-elegant {
        margin: 0;
    }

    .table-elegant thead th {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: none;
        padding: 18px 20px;
        font-weight: 600;
        color: #495057;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 0.5px;
    }

    .table-elegant tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f1f3f5;
    }

    .table-elegant tbody tr:hover {
        background: linear-gradient(90deg, #f8f9ff 0%, #fff 100%);
        transform: scale(1.01);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .table-elegant tbody td {
        padding: 18px 20px;
        vertical-align: middle;
        border: none;
        color: #495057;
    }

    .badge-elegant {
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 500;
        font-size: 13px;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 800;
        background: #000000;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 30px;
        text-align: center;
    }

    .icon-wrapper {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-right: 15px;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .empty-state {
        padding: 60px 20px;
        text-align: center;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 4rem;
        color: #dee2e6;
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 2rem;
        }

        .icon-wrapper {
            display: none;
        }
    }
</style>

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
                                    <th>NAME OF THE PERSON</th>
                                    <th>STATE</th>
                                    <th>DATE OF JOINING</th>
                                    <th>DATE OF LEAVING</th>
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
                                            <div class="badge bg-light text-dark fw-semibold">
                                                {{ $loop->iteration }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                               
                                                <span class="fw-semibold">{{ $user->name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @if($user->state)
                                                <span class="badge bg-success bg-opacity-10 text-success">
                                                    {{ $user->state }}
                                                </span>
                                            @else
                                                <span class="text-muted fst-italic">Not provided</span>
                                            @endif
                                        </td>
                                        <td>
                                             
                                            
                                            <span class="badge bg-light text-dark">
                                                {{ $user->date_of_joining ? date('d M Y', strtotime($user->date_of_joining)) : '-' }}
                                            </span>


                                        </td>
                                        <td>
                                           
                                            <span class="badge bg-light text-dark">
                                                {{ $user->date_of_leaving ? date('d M Y', strtotime($user->date_of_leaving)) : '-' }}
                                            </span>

                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                          
                                                {{ $user->phone ?? '-' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                
                                                {{ $user->email }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">
                                                {{ $user->designation ?? '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">
                                                {{ $user->monthly_salary ?? '-' }}
                                            </span>
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
                                            <i class="fas fa-users-slash"></i>
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
