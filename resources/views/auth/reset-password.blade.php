<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
            background: url('/bgimg.jpg') no-repeat center center/cover;
        }

        /* Floating crowns */
        .floating-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .shape {
            position: absolute;
            opacity: 0.1;
            animation: float 15s infinite ease-in-out;
        }

        .shape:nth-child(1) { top: 10%; left: 10%; font-size: 100px; }
        .shape:nth-child(2) { top: 60%; right: 10%; font-size: 80px; animation-delay: 2s; }
        .shape:nth-child(3) { bottom: 20%; left: 15%; font-size: 90px; animation-delay: 4s; }

        @keyframes float {
            0%,100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(10deg); }
        }

        /* Glass card */
        .auth-card {
            position: relative;
            z-index: 2;
            background: rgba(255, 255, 255, 0.88);
            border-radius: 30px;
            padding: 40px 35px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 30px 60px rgba(0,0,0,0.3);
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h4 {
            font-weight: 700;
            color: #2d3561;
        }

        .form-control {
            border-radius: 50px;
            padding: 15px 20px;
            border: 2px solid #e0e0e0;
            background: #f8f9fa;
        }

        .form-control:focus {
            border-color: #c76d8e;
            box-shadow: 0 0 0 3px rgba(199,109,142,0.15);
            background: #fff;
        }

        .btn-reset {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            background: linear-gradient(135deg,#c76d8e,#a85672);
            color: #fff;
        }

        .btn-reset:hover {
            opacity: 0.95;
        }

        .back-link {
            color: #c76d8e;
            text-decoration: none;
            font-weight: 600;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<!-- Floating shapes -->
<div class="floating-shapes">
    <div class="shape"><i class="fas fa-crown"></i></div>
    <div class="shape"><i class="fas fa-crown"></i></div>
    <div class="shape"><i class="fas fa-crown"></i></div>
</div>

<div class="auth-card">

    <h4 class="text-center mb-2">Reset Password</h4>
    <p class="text-center text-muted mb-4">
        Enter your new password below
    </p>

    {{-- Errors --}}
    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <div class="mb-3">
            <input
                type="password"
                name="password"
                class="form-control"
                placeholder="New Password"
                required>
        </div>

        <div class="mb-3">
            <input
                type="password"
                name="password_confirmation"
                class="form-control"
                placeholder="Confirm Password"
                required>
        </div>

        <button type="submit" class="btn-reset">
            Reset Password
        </button>
    </form>

    <div class="text-center mt-4">
        <a href="{{ route('login.form') }}" class="back-link">
            ← Back to Login
        </a>
    </div>

</div>

</body>
</html>
