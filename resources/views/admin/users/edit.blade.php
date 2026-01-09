@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')

<div class="container-fluid py-4">

    <div class="row justify-content-center mb-5">
        <div class="col-lg-7 col-xl-12">

            <div class="card card-elegant">
                <div class="card-body p-4 p-md-5">

                    <h5>Edit User Account</h5>
                    <br>

                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            {{-- Name --}}
                            <div class="mb-4 col-md-12">
                                <label class="form-label fw-semibold text-muted mb-2">
                                    Name of the Person
                                </label>
                                <input type="text"
                                    name="name"
                                    class="form-control form-control-elegant"
                                    value="{{ old('name', $user->name) }}"
                                    required>
                            </div>

                            {{-- State --}}
                            <div class="col-md-3 mb-3">
                                <label class="form-label">State *</label>
                                <select name="state" class="form-select form-control-elegant" required>
                                    <option value="">Select State</option>
                                    @foreach($states as $state)
                                        <option value="{{ $state->name }}"
                                            {{ old('state', $user->state) == $state->name ? 'selected' : '' }}>
                                            {{ $state->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Designation --}}
                            <div class="mb-4 col-md-3">
                                <label class="form-label fw-semibold text-muted mb-2">
                                    Designation
                                </label>
                                <input type="text"
                                    name="designation"
                                    class="form-control form-control-elegant"
                                    value="{{ old('designation', $user->designation) }}">
                            </div>

                            {{-- Date of Joining --}}
                            <div class="mb-4 col-md-3">
                                <label class="form-label fw-semibold text-muted mb-2">
                                    Date of Joining
                                </label>
                                <input type="date"
                                    name="date_of_joining"
                                    class="form-control form-control-elegant"
                                    value="{{ old('date_of_joining', $user->date_of_joining) }}"
                                    required>
                            </div>

                            {{-- Date of Leaving --}}
                            <div class="mb-4 col-md-3">
                                <label class="form-label fw-semibold text-muted mb-2">
                                    Date of Leaving
                                </label>
                                <input type="date"
                                    name="date_of_leaving"
                                    class="form-control form-control-elegant"
                                    value="{{ old('date_of_leaving', $user->date_of_leaving) }}">
                            </div>

                            {{-- Monthly Salary --}}
                            <div class="mb-4 col-md-3">
                                <label class="form-label fw-semibold text-muted mb-2">
                                    Monthly Salary
                                </label>
                                <input type="text"
                                    name="monthly_salary"
                                    class="form-control form-control-elegant"
                                    value="{{ old('monthly_salary', $user->monthly_salary) }}">
                            </div>

                            {{-- Phone --}}
                            <div class="mb-4 col-md-3">
                                <label class="form-label fw-semibold text-muted mb-2">
                                    Contact Number
                                </label>
                                <input type="text"
                                    id="phone"
                                    name="phone"
                                    class="form-control form-control-elegant"
                                    value="{{ old('phone', $user->phone) }}"
                                    required>
                            </div>

                            {{-- Email --}}
                            <div class="mb-4 col-md-3">
                                <label class="form-label fw-semibold text-muted mb-2">
                                    Email Address
                                </label>
                                <input type="email"
                                    name="email"
                                    class="form-control form-control-elegant"
                                    value="{{ old('email', $user->email) }}"
                                    required>
                            </div>

                            {{-- Password --}}
                            <div class="mb-4 col-md-3">
                                <label class="form-label fw-semibold text-muted mb-2">
                                    New Password
                                </label>

                                <div class="position-relative">
                                    <input type="password"
                                        id="password"
                                        name="password"
                                        class="form-control form-control-elegant pe-5"
                                        placeholder="Leave blank to keep existing">

                                    <i class="fas fa-eye password-toggle"
                                       onclick="togglePassword('password', this)"></i>
                                </div>
                            </div>
                            <style>
                                .password-toggle {
                                    position: absolute;
                                    top: 50%;
                                    right: 12px;
                                    transform: translateY(-50%);
                                    cursor: pointer;
                                    color: #6c757d;
                                    font-size: 1rem;
                                }

                                .password-toggle:hover {
                                    color: #000;
                                }

                            </style>

                        </div>

                        {{-- Update Button --}}
                        <div class="d-flex align-items-center justify-content-end">
                            <button type="submit"
                                id="updateUserBtn"
                                class="btn btn-primary text-white">
                                <span class="btn-text">UPDATE ACCOUNT</span>
                            </button>
                        </div>

                    </form>

                </div>
            </div>

            <div class="d-flex align-items-center justify-content-between mt-2">
                <div class="small mt-2">
                    © 2025 Developed by Solutions (solutions1401@gmail.com)
                </div>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    Back
                </a>
            </div>

        </div>
    </div>

</div>

{{-- PASSWORD TOGGLE --}}
<script>
function togglePassword(id, icon) {
    const input = document.getElementById(id);
    if (input.type === "password") {
        input.type = "text";
        icon.classList.replace("fa-eye", "fa-eye-slash");
    } else {
        input.type = "password";
        icon.classList.replace("fa-eye-slash", "fa-eye");
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const btn = document.getElementById("updateUserBtn");
    const btnText = btn.querySelector(".btn-text");

    form.addEventListener("submit", function () {
        btn.disabled = true;
        btnText.innerHTML =
            '<i class="fas fa-spinner fa-spin me-2"></i> Updating...';
    });
});
</script>

@endsection
