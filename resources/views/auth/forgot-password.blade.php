<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - School System</title>
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
        .forgot-card { 
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
            line-height: 1.5;
        }
        .form-label { 
            font-weight: 500; 
            color: #374151; 
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        .form-control { 
            border-radius: 10px; 
            border: 1px solid #e5e7eb;
            padding: 12px 16px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }
        .form-control:focus { 
            border-color: #4f46e5; 
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1); 
            outline: none;
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
        .back-link {
            color: #4f46e5;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
            font-size: 0.9rem;
        }
        .back-link:hover {
            color: #4338ca;
            text-decoration: underline;
        }
        .info-box {
            background: #eff6ff;
            border-left: 4px solid #4f46e5;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }
        .info-box p {
            margin: 0;
            color: #1e40af;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center">
        <div class="card forgot-card">
            <div class="card-header-custom">
                <div class="app-logo">
                    <i class="bi bi-key-fill"></i>
                </div>
                <h2 class="card-title">Forgot Password?</h2>
                <p class="card-subtitle">No worries! Enter your email and we'll send you<br>reset instructions.</p>
            </div>
            <div class="card-body-custom">
                @if(session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('status') }}
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

                <div class="info-box">
                    <p><i class="bi bi-info-circle me-2"></i>Enter the email address associated with your account and we'll send you a link to reset your password.</p>
                </div>

                <form action="{{ route('password.email') }}" method="post" novalidate>
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               placeholder="Enter your email" 
                               required 
                               value="{{ old('email') }}" 
                               autofocus>
                    </div>

                    <button type="submit" class="btn btn-primary mb-3">
                        <i class="bi bi-envelope me-2"></i>Send Reset Link
                    </button>

                    <div class="text-center">
                        <a href="{{ route('login') }}" class="back-link">
                            <i class="bi bi-arrow-left me-1"></i>Back to Login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
