@extends('layouts.superadmin')

@section('title', 'Create User')

@section('content')

<style>
    .gradient-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        font-size: 2.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
    <h2 class="page-title">User Management</h2>

    {{-- ================= CREATE USER CARD ================= --}}
    <div class="row justify-content-center mb-5">
        <div class="col-lg-7 col-xl-12">

            <div class="card card-elegant">
                <div class="header-elegant">
                    <div class="d-flex align-items-center">
                        <div class="icon-wrapper">
                            <i class="fas fa-user-plus fa-lg"></i>
                        </div>
                        <h5>Create New Account</h5>
                    </div>
                </div>

                <div class="card-body  p-4 p-md-5">
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                    <div class="row">
                        <div class="mb-4 col-md-6">
                            <label class="form-label fw-semibold text-muted mb-2">
                                <i class="fas fa-building me-2"></i>Agency Name
                            </label>
                            <input type="text"
                                   name="name"
                                   class="form-control form-control-elegant"
                                   placeholder="Enter agency name"
                                   value="{{ old('name') }}"
                                   required>
                        </div>

                        <div class="mb-4 col-md-6">
                            <label class="form-label fw-semibold text-muted mb-2">
                                <i class="fas fa-file-invoice me-2"></i>GST Number
                            </label>
                            <input type="text"
                                   name="gst_number"
                                   class="form-control form-control-elegant"
                                   placeholder="Enter GST number (optional)"
                                   value="{{ old('gst_number') }}">
                        </div>

                        <div class="mb-4 col-md-6">
                            <label class="form-label fw-semibold text-muted mb-2">
                                <i class="fas fa-user-tie me-2"></i>Authorized Person
                            </label>
                            <input type="text"
                                   name="auth_person_name"
                                   class="form-control form-control-elegant"
                                   placeholder="Enter authorized person name"
                                   value="{{ old('auth_person_name') }}"
                                   required>
                        </div>

                        <div class="mb-4 col-md-6">
                            <label class="form-label fw-semibold text-muted mb-2">
                                <i class="fas fa-envelope me-2"></i>Email Address
                            </label>
                            <input type="email"
                                   name="email"
                                   class="form-control form-control-elegant"
                                   placeholder="Enter email address"
                                   value="{{ old('email') }}"
                                   required>
                        </div>

                        <div class="mb-4 col-md-6">
                            <label class="form-label fw-semibold text-muted mb-2">
                                <i class="fas fa-lock me-2"></i>Password
                            </label>
                            <input type="password"
                                   name="password"
                                   class="form-control form-control-elegant"
                                   placeholder="Enter secure password"
                                   required>
                        </div>

                        <div class="mb-5 col-md-6">
                            <label class="form-label fw-semibold text-muted mb-2">
                                <i class="fas fa-check-circle me-2"></i>Confirm Password
                            </label>
                            <input type="password"
                                   name="password_confirmation"
                                   class="form-control form-control-elegant"
                                   placeholder="Re-enter password"
                                   required>
                        </div>
                    </div>

                       <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-gradient btn-lg text-white">
                                <i class="fas fa-plus-circle me-2"></i>CREATE ACCOUNT
                            </button>
                        </div>

                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    

</div>

@endsection