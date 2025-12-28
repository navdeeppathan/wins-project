@extends('layouts.admin')

@section('title','Signup')



@section('content')

<div class="auth-wrapper">
  <div class="auth-card">

    <h2 class="welcome-text">Welcome 👋</h2>
    <p class="subtitle">Create your account to continue</p>

    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('register') }}">
      @csrf

      <!-- NAME -->
      <div class="mb-2">
        <input type="text" name="name" class="form-control"
               placeholder="Name of Agency" required value="{{ old('name') }}">
        @error('name') <div class="login-error">{{ $message }}</div> @enderror
      </div>

      <!-- GST -->
      <div class="mb-2">
        <input type="text" name="gst_number" class="form-control"
               placeholder="GST Number" maxlength="15"
               style="text-transform:uppercase" required
               value="{{ old('gst_number') }}">
        @error('gst_number') <div class="login-error">{{ $message }}</div> @enderror
      </div>

      <!-- AUTH PERSON -->
      <div class="mb-2">
        <input type="text" name="auth_person_name" class="form-control"
               placeholder="Authorized Person Name" required
               value="{{ old('auth_person_name') }}">
        @error('auth_person_name') <div class="login-error">{{ $message }}</div> @enderror
      </div>

      <!-- EMAIL -->
      <div class="mb-2">
        <input type="email" name="email" class="form-control"
               placeholder="Email Address" required value="{{ old('email') }}">
        @error('email') <div class="login-error">{{ $message }}</div> @enderror
      </div>

      <!-- PASSWORD -->
      <div class="mb-2 password-group">
        <input type="password" id="password" name="password"
               class="form-control" placeholder="Password" required>
        <i class="fas fa-eye toggle-password"
           onclick="togglePassword('password', this)"></i>
        @error('password') <div class="login-error">{{ $message }}</div> @enderror
      </div>

      <!-- CONFIRM PASSWORD -->
      <div class="mb-2 password-group">
        <input type="password" id="password_confirmation"
               name="password_confirmation"
               class="form-control" placeholder="Confirm Password" required>
        <i class="fas fa-eye toggle-password"
           onclick="togglePassword('password_confirmation', this)"></i>
      </div>

      <!-- BUTTON -->
      <button type="submit" id="register-btn">
        <span id="btn-text">Create Account</span>
        <span id="btn-loader"></span>
      </button>

      <div class="login-link">
        Already have an account?
        <a href="{{ route('login.form') }}">Login</a>
        <div class="small mt-2">
          © 2025 Developed by Solutions<br>
          (solutions1401@gmail.com)
        </div>
      </div>

    </form>

  </div>
</div>


<script>
  function togglePassword(id, icon) {
    const input = document.getElementById(id);

    if (input.type === "password") {
      input.type = "text";
      icon.classList.remove("fa-eye");
      icon.classList.add("fa-eye-slash");
    } else {
      input.type = "password";
      icon.classList.remove("fa-eye-slash");
      icon.classList.add("fa-eye");
    }
  }

  // Disable button + show loader on submit
  document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const btn = document.getElementById("register-btn");
    const btnText = document.getElementById("btn-text");
    const loader = document.getElementById("btn-loader");

    if (form) {
      form.addEventListener("submit", function () {
        btn.disabled = true;
        btnText.style.display = "none";
        loader.style.display = "inline-block";
      });
    }
  });
</script>


<style>
  .auth-wrapper {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #0f172a, #020617);
  padding: 20px;
}

.auth-card {
  width: 100%;
  max-width: 420px;
  background: #ffffff;
  border-radius: 16px;
  padding: 30px;
  box-shadow: 0 20px 60px rgba(0,0,0,0.35);
  animation: fadeUp 0.8s ease;
}

.welcome-text {
  font-size: 28px;
  font-weight: 700;
  margin-bottom: 4px;
  text-align: center;
}

.subtitle {
  font-size: 14px;
  color: #6b7280;
  text-align: center;
  margin-bottom: 22px;
}

.form-control {
  border-radius: 10px;
  padding: 12px 14px;
  font-size: 14px;
  border: 1px solid #e5e7eb;
}

.form-control:focus {
  border-color: #6366f1;
  box-shadow: 0 0 0 3px rgba(99,102,241,.15);
}

.password-group {
  position: relative;
}

.toggle-password {
  position: absolute;
  right: 14px;
  top: 50%;
  transform: translateY(-50%);
  cursor: pointer;
  color: #6b7280;
}

button#register-btn {
  width: 100%;
  margin-top: 12px;
  padding: 12px;
  border-radius: 10px;
  background: linear-gradient(135deg, #6366f1, #4f46e5);
  border: none;
  color: #fff;
  font-weight: 600;
  font-size: 15px;
  transition: all .3s ease;
}

button#register-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 30px rgba(99,102,241,.4);
}

.login-link {
  text-align: center;
  margin-top: 16px;
  font-size: 14px;
}

.login-link a {
  color: #4f46e5;
  font-weight: 600;
  text-decoration: none;
}

.login-error {
  font-size: 12px;
  color: #dc2626;
  margin-top: 4px;
}

#btn-loader {
  display: none;
  width: 18px;
  height: 18px;
  border: 2px solid #fff;
  border-top: 2px solid transparent;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

@keyframes fadeUp {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

</style>
@endsection
