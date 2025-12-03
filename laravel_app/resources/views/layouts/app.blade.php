<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .header { background-color: #0d6efd; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15); }
        .sidebar { width: 250px; min-height: 100vh; background-color: #ffffff; border-right: 1px solid #dee2e6; box-shadow: 2px 0 8px rgba(0, 0, 0, 0.05); }
        .list-group-item { border: none; padding: 12px 16px; font-size: 16px; color: #495057; border-radius: 6px; margin-bottom: 6px; }
        .list-group-item:hover, .list-group-item.active { background-color: #0d6efd; color: white !important; }
        a { text-decoration: none; color: inherit; }
        .content { flex-grow: 1; background-color: #eef1f4; padding: 25px; }
        li { list-style: none; }
    </style>
</head>
<body>
    <div class="header py-4 px-4 text-center text-light fw-bold position-relative">
        School System
        <form action="{{ route('logout') }}" method="POST" class="position-absolute end-0 me-4 top-50 translate-middle-y">
            @csrf
            <button type="submit" class="btn btn-dark">
                <i class="bi bi-box-arrow-left me-2"></i>Logout
            </button>
        </form>
    </div>

    <div class="d-flex">
        <div class="sidebar px-3 py-4">
            <ul class="list-group my-4">
                <li><a href="{{ route('students.index') }}" class="list-group-item {{ request()->routeIs('students.*') ? 'active' : '' }}">Students</a></li>
                <li><a href="{{ route('subjects.index') }}" class="list-group-item {{ request()->routeIs('subjects.*') ? 'active' : '' }}">Subjects</a></li>
                <li><a href="{{ route('grades.index') }}" class="list-group-item {{ request()->routeIs('grades.*') ? 'active' : '' }}">Grade</a></li>
            </ul>
        </div>

        <div class="content">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
