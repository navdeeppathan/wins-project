{{-- <!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body style="font-family: Arial; background: #f4f4f4; padding:20px;">
    <h2>Login</h2>

    @if(session('error')) <p style="color:red">{{ session('error') }}</p> @endif
    @if(session('success')) <p style="color:green">{{ session('success') }}</p> @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <p>
            <label>Email</label><br>
            <input type="email" name="email" required>
        </p>
        <p>
            <label>Password</label><br>
            <input type="password" name="password" required>
        </p>
        <button type="submit">Login</button>
    </form>
</body>
</html> --}}


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KING</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* --- your full UI CSS unchanged --- */
        * {margin:0; padding:0; box-sizing:border-box;}
        body {
            font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background:#FFFFFF;
            min-height:100vh; display:flex; align-items:center;
            justify-content:center; padding:20px; position:relative;
            overflow-x:hidden;
        }
        .floating-shapes{position:fixed; top:0; left:0; width:100%; height:100%; pointer-events:none; z-index:1;}
        .shape{position:absolute; opacity:0.1; animation:float 15s infinite ease-in-out;}
        .shape:nth-child(1){top:10%; left:10%; font-size:100px; animation-delay:0s;}
        .shape:nth-child(2){top:60%; right:10%; font-size:80px; animation-delay:2s;}
        .shape:nth-child(3){bottom:20%; left:15%; font-size:90px; animation-delay:4s;}
        @keyframes float{0%,100%{transform:translateY(0) rotate(0deg);}50%{transform:translateY(-20px) rotate(10deg);}}
        .auth-container{display:flex; max-width:1000px; width:100%; background:rgba(255, 255, 255, 0.872); border-radius:30px; overflow:hidden; box-shadow:0 30px 60px rgba(0,0,0,0.3); position:relative; z-index:2; animation:slideUp 0.6s ease-out;}
        @keyframes slideUp{from{opacity:0; transform:translateY(30px);}to{opacity:1; transform:translateY(0);}}
        .left-panel{flex:1; background:linear-gradient(135deg,#2d3561 0%, #1a1f3a 100%); padding:60px 40px; display:flex; flex-direction:column; justify-content:center; align-items:center; color:white; position:relative; overflow:hidden;}
        .left-panel::before{content:''; position:absolute; top:-50%; right:-50%; width:200%; height:200%; background:radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); animation:pulse 8s infinite;}
        @keyframes pulse{0%,100%{transform:scale(1); opacity:0.5;}50%{transform:scale(1.1); opacity:0.3;}}
        .brand-logo{width:80px; height:80px; background:white; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:30px; box-shadow:0 10px 30px rgba(0,0,0,0.3); animation:bounce 2s infinite; position:relative; z-index:1;}
        @keyframes bounce{0%,100%{transform:translateY(0);}50%{transform:translateY(-10px);}}
        .crown-icon{font-size:40px; color:#c76d8e;}
        .brand-name{font-size:36px; font-weight:bold; margin-bottom:20px; position:relative; z-index:1;}
        .brand-description{text-align:center; opacity:0.9; line-height:1.8; margin-bottom:30px; position:relative; z-index:1;}
        .learn-more-btn{background:linear-gradient(135deg,#c76d8e 0%, #a85672 100%); color:white; padding:12px 40px; border:none; border-radius:50px; cursor:pointer; font-size:16px; transition:all 0.3s; box-shadow:0 5px 15px rgba(199,109,142,0.4); position:relative; z-index:1;}
        .learn-more-btn:hover{transform:translateY(-2px); box-shadow:0 8px 20px rgba(199,109,142,0.6);}
        .right-panel{flex:1; padding:60px 50px; display:flex; flex-direction:column; justify-content:center;}
        .close-btn{position:absolute; top:20px; right:20px; width:35px; height:35px; background:#f0f0f0; border:none; border-radius:50%; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:all 0.3s; z-index:10;}
        .close-btn:hover{background:#e0e0e0; transform:rotate(90deg);}
        .welcome-text{font-size:32px; font-weight:bold; color:#2d3561; margin-bottom:10px;}
        .subtitle{color:#666; margin-bottom:30px;}
        .form-group{margin-bottom:25px;}
        .form-control{width:100%; padding:15px 20px; border:2px solid #e0e0e0; border-radius:50px; font-size:15px; transition:all 0.3s; background:#f8f9fa;}
        .form-control:focus{outline:none; border-color:#c76d8e; background:white; box-shadow:0 0 0 3px rgba(199,109,142,0.1);}
        .login-error{color:red; font-size:14px; margin-top:5px;}
        .password-group{position:relative;}
        .toggle-password{position:absolute; right:20px; top:50%; transform:translateY(-50%); cursor:pointer; color:#999; transition:color 0.3s;}
        .toggle-password:hover{color:#666;}
        .remember-forgot{display:flex; justify-content:space-between; align-items:center; margin-bottom:25px; font-size:14px;}
        .forgot-link{color:#999; text-decoration:none;}
        .login-btn{width:100%; padding:15px; background:linear-gradient(135deg,#c76d8e 0%, #a85672 100%); color:white; border:none; border-radius:50px; font-size:16px; font-weight:600; cursor:pointer;}
        .register-link{text-align:center; margin-top:25px; color:#666;}
        .login-btn {
                position: relative;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
        }

        .btn-loader {
                display: none;
                width: 18px;
                height: 18px;
                border: 3px solid #ffffff;
                border-top: 3px solid transparent;
                border-radius: 50%;
                animation: spin 0.7s linear infinite;
        }

        @keyframes spin {
                to { transform: rotate(360deg); }
        }

        .login-btn.loading .btn-text {
                opacity: 0;
        }

        .login-btn.loading .btn-loader {
                display: inline-block;
        }

          
        @media (max-width: 768px) {

            body {
                padding: 0;
                background: linear-gradient(135deg, #764ba2 0%, #c76d8e 100%);
            }

            .auth-container {
                flex-direction: column;
                max-width: 100%;
                width: 100%;
                border-radius: 0;
                height: 100vh;
                overflow-y: auto;
            }

            /* Hide the left panel completely on mobile */
            .left-panel {
                display: none;
            }

            /* Add a curved decorative top section like screenshot */
            .right-panel {
                width: 100%;
                padding: 40px 30px;
                position: relative;
                background: white;
                border-radius: 30px 30px 0 0;
                margin-top: -40px;
                z-index: 10;
            }

            .right-panel::before {
                content: "";
                width: 100%;
                height: 120px;
                background: #2d3561;
                position: absolute;
                top: -120px;
                left: 0;
                border-radius: 0 0 50% 50%;
            }

            /* Pink round logo holder like sample */
            .right-panel::after {
                content: "";
                width: 70px;
                height: 70px;
                background: #c76d8e;
                border-radius: 50%;
                position: absolute;
                top: -35px;
                left: 50%;
                transform: translateX(-50%);
                box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            }

            /* Remove big desktop font on mobile */
            .welcome-text {
                font-size: 26px;
                text-align: center;
                margin-top: 40px;
            }

            .subtitle {
                text-align: center;
                margin-bottom: 20px;
            }

            .form-group {
                margin-bottom: 18px;
            }

            .form-control {
                border-radius: 12px;
                padding: 14px 18px;
                font-size: 14px;
            }

            .remember-forgot {
                margin-top: 5px;
                margin-bottom: 20px;
                font-size: 13px;
            }

            .login-btn {
                border-radius: 12px;
                padding: 14px;
                font-size: 16px;
            }

            .close-btn {
                top: 15px;
                right: 15px;
                z-index: 20;
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
        /* Background Slider Animation */
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

    <!-- Floating Background Shapes -->
    <div class="floating-shapes">
        <div class="shape"><i class="fas fa-crown"></i></div>
        <div class="shape"><i class="fas fa-crown"></i></div>
        <div class="shape"><i class="fas fa-crown"></i></div>
    </div>

   <div class="auth-container"  >


        <button class="close-btn" onclick="window.history.back()">
            <i class="fas fa-times"></i>
        </button>

        <!-- LEFT PANEL -->
       <div class="left-panel bg-slider">
            <div class="brand-logo">
                <i class="fas fa-crown crown-icon"></i>
            </div>
            <div class="brand-name">Wins</div>
            <p class="brand-description">
                The best way to manage your expenses.
            </p>
        </div>


        <!-- RIGHT PANEL (LOGIN FORM) -->
        <div class="right-panel" >
            <h2 class="welcome-text">Welcome Back!</h2>
            <p class="subtitle">Sign in to continue</p>

            {{-- SUCCESS / ERROR MESSAGES --}}
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- EMAIL --}}
                <div class="form-group">
                    <input type="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           class="form-control" 
                           placeholder="Email">
                    
                    @error('email')
                        <div class="login-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- PASSWORD --}}
                <div class="form-group password-group">
                    <input type="password" 
                           name="password" 
                           id="password" 
                           class="form-control" 
                           placeholder="Password">

                    <i class="fas fa-eye toggle-password" onclick="togglePassword()"></i>

                    @error('password')
                        <div class="login-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- REMEMBER --}}
                <div class="remember-forgot">
                    <label>
                        <input type="checkbox" name="remember">
                        Remember me
                    </label>
                </div>

                {{-- LOGIN BUTTON --}}
               <button type="submit" class="login-btn" id="loginBtn">
                    <span class="btn-text">Login</span>
                    <span class="btn-loader"></span>
                </button>
  <div class="login-link">
                    Create a new account?
                    <a href="{{ route('register') }}">Register</a>
                </div>

            </form>
        </div>
    </div>

   <script>
    function togglePassword() {
        const field = document.getElementById('password');
        const icon = document.querySelector('.toggle-password');

        if (field.type === "password") {
            field.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            field.type = "password";
            icon.classList.add("fa-eye");
            icon.classList.remove("fa-eye-slash");
        }
    }

    // 🚀 Show loader on form submit
    const loginForm = document.querySelector("form");
    const loginBtn = document.getElementById("loginBtn");

    loginForm.addEventListener("submit", function () {
        loginBtn.classList.add("loading");
        loginBtn.disabled = true;
    });
</script>


</body>
</html>
