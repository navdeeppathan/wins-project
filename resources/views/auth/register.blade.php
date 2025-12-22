{{-- <!DOCTYPE html>
<html>
<head>
    <title>Create Admin</title>
</head>
<body style="font-family: Arial; background:#f9f9f9; padding:20px;">
    <h2>Register Admin</h2>

    @if(session('error')) <p style="color:red">{{ session('error') }}</p> @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <p>
            <label>Name</label><br>
            <input type="text" name="name" required>
        </p>
        <p>
            <label>Email</label><br>
            <input type="email" name="email" required>
        </p>
        <p>
            <label>Password</label><br>
            <input type="password" name="password" required>
        </p>
        <p>
            <label>Confirm Password</label><br>
            <input type="password" name="password_confirmation" required>
        </p>
        <button type="submit">Create Admin</button>
    </form>
</body>
</html> --}}

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Register - Wins</title>

    <!-- Bootstrap + Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />

    <style>
      * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
      }

      body {
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        background: #FFFFFF;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 15px;
        position: relative;
        overflow-x: hidden;
      }

      /* Floating Crown Animation */
      .floating-shapes {
        position: fixed;
        width: 100%;
        height: 100%;
        z-index: 1;
        pointer-events: none;
      }

      .shape {
        position: absolute;
        opacity: 0.1;
        animation: float 15s infinite ease-in-out;
      }

      .shape:nth-child(1) {
        top: 10%;
        left: 5%;
        font-size: 80px;
      }

      .shape:nth-child(2) {
        top: 70%;
        right: 10%;
        font-size: 90px;
        animation-delay: 2s;
      }

      .shape:nth-child(3) {
        bottom: 15%;
        left: 20%;
        font-size: 100px;
        animation-delay: 4s;
      }

      @keyframes float {
        0%,
        100% {
          transform: translateY(0) rotate(0);
        }
        50% {
          transform: translateY(-20px) rotate(10deg);
        }
      }

      /* Auth Box */
      .auth-container {
        width: 100%;
        max-width: 1100px;
        background: rgba(255, 255, 255, 0.872);
        border-radius: 28px;
        overflow: hidden;
        display: flex;
        box-shadow: 0 18px 45px rgba(0, 0, 0, 0.35);
        z-index: 2;
        animation: fadeUp 0.6s ease-out;
      }

      @keyframes fadeUp {
        from {
          opacity: 0;
          transform: translateY(30px);
        }
        to {
          opacity: 1;
        }
      }

      /* Left Panel */
      .left-panel {
        flex: 1;
        background: linear-gradient(135deg, #2d3561 0%, #1a1f3a 100%);
        padding: 60px 30px;
        color: #fff;
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: center;
        gap: 20px;
      }

      .brand-logo {
        background: #fff;
        border-radius: 50%;
        height: 90px;
        width: 90px;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: auto;
        box-shadow: 0 10px 20px rgba(255, 255, 255, 0.3);
        animation: bounce 2s infinite;
      }

      @keyframes bounce {
        50% {
          transform: translateY(-8px);
        }
      }

      .crown-icon {
        font-size: 38px;
        color: #c76d8e;
      }

      .learn-more-btn {
        border: none;
        padding: 12px 35px;
        border-radius: 30px;
        color: #fff;
        font-weight: 500;
        background: linear-gradient(135deg, #c76d8e 0%, #a85672 100%);
        box-shadow: 0 8px 18px rgba(199, 109, 142, 0.4);
        transition: 0.3s;
        margin-top: 12px;
      }

      .learn-more-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(199, 109, 142, 0.6);
      }

      /* Right Panel */
      .right-panel {
        flex: 1.1;
        padding: 30px 45px;
      }

      .welcome-text {
        font-size: 32px;
        font-weight: bold;
        color: #2d3561;
      }

      .subtitle {
        color: #666;
        margin-bottom: 30px;
      }

      .form-control {
        padding: 14px 20px;
        border-radius: 50px;
        border: 2px solid #e2e2e2;
        background: #f9f9f9;
        transition: 0.3s;
      }

      .form-control:focus {
        border-color: #c76d8e;
        box-shadow: 0 0 0 3px rgba(199, 109, 142, 0.1);
        background: #fff;
      }

      .password-group {
        position: relative;
      }

      .toggle-password {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #999;
      }

      .toggle-password:hover {
        color: #666;
      }

      .login-error {
        color: red;
        font-size: 13px;
        margin-top: 6px;
      }

      /* Submit Button */
      #register-btn {
        width: 100%;
        padding: 14px;
        border: none;
        border-radius: 50px;
        color: white;
        font-weight: 600;
        font-size: 16px;
        background: linear-gradient(135deg, #c76d8e 0%, #a85672 100%);
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin-top: 8px;
        transition: 0.3s;
      }

      #btn-loader {
        width: 18px;
        height: 18px;
        border: 3px solid #fff;
        border-top: 3px solid transparent;
        border-radius: 50%;
        display: none;
        animation: spin 0.7s linear infinite;
      }

      @keyframes spin {
        to {
          transform: rotate(360deg);
        }
      }

      .close-btn {
        position: absolute;
        top: 20px;
        right: 15px;
        border: none;
        background: #eee;
        height: 35px;
        width: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 16px;
      }

      .close-btn:hover {
        background: #ddd;
        transform: rotate(90deg);
      }

      /* 🔥 Mobile Responsive */
      @media (max-width: 768px) {
        .auth-container {
          flex-direction: column;
          border-radius: 18px;
        }

        .left-panel {
          padding: 40px 20px;
        }

        .right-panel {
          padding: 40px 25px;
        }

        .welcome-text {
          font-size: 26px;
          text-align: center;
        }

        .subtitle {
          text-align: center;
        }

        .close-btn {
          right: 10px;
          top: 10px;
        }

        .form-control {
          border-radius: 12px;
        }

        #register-btn {
          border-radius: 12px;
        }
      }

      .login-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }

        .login-link a {
            color: #c76d8e;
            text-decoration: none;
            font-weight: bold;
        }

        .bg-slider {
    position: relative;
    overflow: hidden;
    background-size: cover !important;
    background-position: center !important;
    animation: bgChange 25s infinite linear;
}

/* 5 images × 5 seconds = 25 seconds total loop */
@keyframes bgChange {
    0%   { background-image: url('/s1.jpg'); }
    20%  { background-image: url('/s1.jpg'); }

    20.01% { background-image: url('/s2.jpg'); }
    40%    { background-image: url('/s2.jpg'); }

    40.01% { background-image: url('/s3.jpg'); }
    60%    { background-image: url('/s3.jpg'); }

    60.01% { background-image: url('/s4.jpg'); }
    80%    { background-image: url('/s4.jpg'); }

   
}
    </style>
  </head>

  <body style="background: url('/bgimg.jpg') no-repeat center center/cover;">
    <!-- Floating Crown Background -->
    <div class="floating-shapes">
      <div class="shape"><i class="fas fa-crown"></i></div>
      <div class="shape"><i class="fas fa-crown"></i></div>
      <div class="shape"><i class="fas fa-crown"></i></div>
    </div>

    <div class="auth-container">
      <!-- Back Button -->
      <button class="close-btn" onclick="window.history.back()">
        <i class="fas fa-times"></i>
      </button>

      <!-- LEFT PANEL -->
      <div class="left-panel bg-slider">
        <div class="brand-logo">
          <i class="fas fa-crown crown-icon"></i>
        </div>

        <h1 class="brand-name">Wins</h1>
        <p class="brand-description">The best way to manage your projects.</p>

        {{-- <button class="learn-more-btn">Learn More</button> --}}
      </div>

      <!-- RIGHT PANEL -->
      <div class="right-panel">
        <h2 class="welcome-text">Welcome</h2>
        <p class="subtitle">Signup to continue</p>

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
            <input
              type="text"
              name="name"
              required
              class="form-control"
              placeholder="Name of Agency"
              value="{{ old('name') }}"
            />
            @error('name')
            <div class="login-error">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-2">
              <input
                  type="text"
                  name="gst_number"
                  class="form-control"
                  placeholder="Enter GST Number"
                  required
                  maxlength="15"
                  style="text-transform: uppercase;"
                  value="{{ old('gst_number') }}"
              />
              @error('gst_number')
                  <div class="login-error">{{ $message }}</div>
              @enderror
          </div>

          <div class="mb-2">
            <input
              type="text"
              name="auth_person_name"
              required
              class="form-control"
              placeholder="Name of Authorized Person"
              value="{{ old('auth_person_name') }}"
            />
            @error('auth_person_name')
            <div class="login-error">{{ $message }}</div>
            @enderror
          </div>

          <!-- EMAIL -->
          <div class="mb-2">
            <input
              type="email"
              name="email"
              value="{{ old('email') }}"
              class="form-control"
              placeholder="Email"
              required

            />
            @error('email')
            <div class="login-error">{{ $message }}</div>
            @enderror
          </div>

          <!-- PASSWORD -->
          <div class="mb-2 password-group">
            <input
              type="password"
              name="password"
              id="password"
              class="form-control"
              placeholder="Password"
              required

            />
            <i
              class="fas fa-eye toggle-password"
              onclick="togglePassword('password', this)"
            ></i>
            @error('password')
            <div class="login-error">{{ $message }}</div>
            @enderror
          </div>

          <!-- CONFIRM PASSWORD -->
          <div class="mb-2 password-group">
            <input
              type="password"
              name="password_confirmation"
              id="password_confirmation"
              class="form-control"
              placeholder="Confirm Password"
              required

            />
            <i
              class="fas fa-eye toggle-password"
              onclick="togglePassword('password_confirmation', this)"
            ></i>
          </div>

          <!-- SUBMIT BUTTON -->
          <button type="submit" id="register-btn">
            <span id="btn-text">Get Started</span>
            <span id="btn-loader"></span>
          </button>
          <div class="login-link">
                    Already have an account?
                    <a href="{{ route('login.form') }}">Login</a>
                </div>
        </form>
      </div>
    </div>

    <script>
      function togglePassword(id, icon) {
        const input = document.getElementById(id);
        input.type = input.type === "password" ? "text" : "password";
        icon.classList.toggle("fa-eye");
        icon.classList.toggle("fa-eye-slash");
      }

      const registerForm = document.querySelector("form");
      registerForm.addEventListener("submit", () => {
        const btn = document.getElementById("register-btn");
        btn.disabled = true;
        document.getElementById("btn-text").style.opacity = 0;
        document.getElementById("btn-loader").style.display = "inline-block";
      });
    </script>
  </body>
</html>


