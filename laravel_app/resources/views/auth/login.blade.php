<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - School System</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { 
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card { 
            border: none; 
            border-radius: 20px; 
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            background: rgba(255, 255, 255, 0.98);
            overflow: hidden;
            width: 100%;
            max-width: 450px;
        }
        .card-header-custom {
            background: transparent;
            padding: 3rem 2rem 1rem;
            text-align: center;
            border: none;
        }
        .card-body-custom {
            padding: 1rem 2.5rem 3rem;
        }
        .app-logo {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            margin-bottom: 1.5rem;
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
        }
        .card-title { 
            font-weight: 700; 
            color: #1f2937;
            font-size: 24px;
            margin-bottom: 0.5rem;
        }
        .card-subtitle {
            color: #6b7280;
            font-size: 14px;
        }
        .form-label { 
            font-weight: 500; 
            color: #374151; 
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        .password-wrapper {
            position: relative;
        }
        .form-control { 
            border-radius: 10px; 
            border: 1px solid #e5e7eb;
            padding: 12px 16px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }
        .password-wrapper .form-control {
            padding-right: 45px;
        }
        .form-control:focus { 
            border-color: #4f46e5; 
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1); 
            outline: none;
        }
        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6b7280;
            cursor: pointer;
            padding: 4px 8px;
            font-size: 18px;
            transition: color 0.2s;
            z-index: 10;
        }
        .password-toggle:hover {
            color: #4f46e5;
        }
        .btn-primary { 
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            border: none;
            border-radius: 10px; 
            font-weight: 600; 
            padding: 14px 20px;
            font-size: 1rem;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
        }
        .btn-primary:hover { 
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
            background: linear-gradient(135deg, #4338ca 0%, #6d28d9 100%);
        }
        .btn-primary:active {
            transform: translateY(0);
        }
        .btn-outline-primary {
            border: 2px solid #4f46e5;
            color: #4f46e5;
            background: transparent;
            border-radius: 10px;
            font-weight: 600;
            padding: 12px 20px;
            font-size: 1rem;
            width: 100%;
            transition: all 0.3s ease;
        }
        .btn-outline-primary:hover {
            background: #4f46e5;
            color: white;
            transform: translateY(-1px);
        }
        .register-link, .forgot-link {
            color: #4f46e5;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
            font-size: 0.9rem;
        }
        .register-link:hover, .forgot-link:hover {
            color: #4338ca;
            text-decoration: underline;
        }
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            color: #9ca3af;
            margin: 1.5rem 0;
            font-size: 0.85rem;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e5e7eb;
        }
        .divider:not(:empty)::before {
            margin-right: .75em;
        }
        .divider:not(:empty)::after {
            margin-left: .75em;
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center">
        <div class="card login-card">
            <div class="card-header-custom">
                <div class="app-logo">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-mortarboard-fill" viewBox="0 0 16 16">
                        <path d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917l-7.5-3.5Z"/>
                        <path d="M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .294.605l4.5 1.8a.5.5 0 0 0 .372 0l4.5-1.8a.5.5 0 0 0 .294-.605l-.5-1.7a.5.5 0 0 0-.656-.327L8 10.466 4.176 9.032Z"/>
                    </svg>
                </div>
                <h2 class="card-title">Welcome Back</h2>
                <p class="card-subtitle">Please enter your details to sign in.</p>
            </div>
            <div class="card-body-custom">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                         <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="post" novalidate>
                    @csrf
                    <div class="mb-4">
                        <label for="user_name" class="form-label">Username</label>
                        <input type="text" 
                               name="user_name" 
                               id="user_name" 
                               class="form-control @error('user_name') is-invalid @enderror" 
                               placeholder="Enter your username" 
                               required 
                               value="{{ old('user_name') }}" 
                               autofocus>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="password-wrapper">
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   placeholder="Enter your password" 
                                   required>
                            <button type="button" 
                                    class="password-toggle" 
                                    onclick="togglePassword('password')"
                                    aria-label="Toggle password visibility">
                                <i class="bi bi-eye" id="password-icon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="text-end mb-4">
                        <a href="{{ route('password.request') }}" class="forgot-link">
                            <i class="bi bi-question-circle me-1"></i>Forgot Password?
                        </a>
                    </div>

                    <button type="submit" class="btn btn-primary mb-3">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                    </button>

                    <a href="{{ route('register') }}" class="btn btn-outline-primary">
                        <i class="bi bi-person-plus me-2"></i>Create New Account
                    </a>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword(inputId) {
            const passwordInput = document.getElementById(inputId);
            const icon = document.getElementById(inputId + '-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
    </script>
</body>
</html>
