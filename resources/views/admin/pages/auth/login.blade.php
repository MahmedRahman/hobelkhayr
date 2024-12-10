@include('admin.includes.head')

<body class="bg-light">
    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-card">
                <div class="login-header">
                    <img src="https://img.icons8.com/color/96/000000/helping--v1.png" alt="HobelKhayr Logo">
                    <h1>Welcome Back!</h1>
                    <p>Sign in to your admin account</p>
                </div>

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{route('login.post')}}">
                    @csrf
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   name="email" 
                                   placeholder="Enter your email"
                                   value="{{ old('email') }}"
                                   required>
                        </div>
                        @error('email')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   name="password" 
                                   placeholder="Enter your password"
                                   required>
                        </div>
                        @error('password')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i> Sign In
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Custom CSS -->
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            margin: 0;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
        }

        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 40px;
            animation: slideUp 0.5s ease-out;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header img {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
        }

        .login-header h1 {
            color: #2d3748;
            font-size: 24px;
            font-weight: 600;
            margin: 0;
        }

        .login-header p {
            color: #718096;
            margin-top: 8px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .input-group {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .input-group-text {
            background-color: white;
            border: 1px solid #e2e8f0;
            border-right: none;
            color: #4a5568;
            padding: 12px 15px;
        }

        .form-control {
            border: 1px solid #e2e8f0;
            border-left: none;
            padding: 12px 15px;
            height: auto;
            font-size: 16px;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #4299e1;
        }

        .error-message {
            color: #e53e3e;
            font-size: 14px;
            margin-top: 5px;
            padding-left: 15px;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 12px;
            background: linear-gradient(to right, #4a90e2, #357abd);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(74, 144, 226, 0.3);
        }

        .alert {
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .alert-danger {
            background-color: #fff5f5;
            border-color: #feb2b2;
            color: #c53030;
        }

        .alert ul {
            margin: 0;
            padding-left: 20px;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive adjustments */
        @media (max-width: 480px) {
            .login-card {
                padding: 30px 20px;
            }
        }
    </style>

    <!-- Add Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    @include('admin.includes.footer')
</body>
</html>