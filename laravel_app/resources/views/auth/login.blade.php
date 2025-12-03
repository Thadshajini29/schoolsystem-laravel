<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); }
        .card-title { font-weight: 600; color: #0d6efd; }
        .form-label { font-weight: 500; color: #444; }
        .form-control { border-radius: 8px; border: 1px solid #ced4da; }
        .form-control:focus { border-color: #0d6efd; box-shadow: 0 0 4px rgba(13, 110, 253, 0.3); }
        .btn-primary { background-color: #0d6efd; border-color: #0d6efd; border-radius: 8px; font-weight: 500; padding: 10px 0; }
        .btn-primary:hover { background-color: #0b5ed7; border-color: #0a58ca; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Login Page</h2>
                        <form action="{{ route('login') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="user_name" class="form-label">User Name</label>
                                <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Enter your user name" required value="{{ old('user_name') }}">
                                @error('user_name')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                                @error('password')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
