<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --dark-color: #5a5c69;
            --light-color: #f8f9fc;
            --sidebar-width: 250px;
        }
        
        body { 
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            color: #5a5c69;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        }

        .sidebar-brand {
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-brand i {
            font-size: 1.5rem;
            margin-right: 10px;
        }

        .nav-item {
            position: relative;
            margin-bottom: 5px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            color: rgba(255,255,255,0.8);
            font-weight: 500;
            transition: all 0.2s;
        }

        .nav-link:hover, .nav-link.active {
            color: white;
            background-color: rgba(255,255,255,0.1);
            border-left: 4px solid white;
        }

        .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Main Content Styles */
        .main-content {
            margin-left: var(--sidebar-width);
            transition: all 0.3s ease;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Topbar Styles */
        .topbar {
            height: 70px;
            background-color: white;
            box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 0 2rem;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        /* Content Wrapper */
        .content-wrapper {
            padding: 1.5rem;
            flex-grow: 1;
        }

        /* Card Styles */
        .card {
            border: none;
            border-radius: 0.35rem;
            box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15);
            margin-bottom: 1.5rem;
        }

        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
            padding: 1rem 1.25rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        /* Button Styles */
        .btn {
            border-radius: 0.35rem;
            padding: 0.375rem 0.75rem;
            font-weight: 500;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2653d4;
        }

        /* Image Preview Styles */
        .image-preview-container {
            position: relative;
            display: inline-block;
            margin-top: 10px;
        }

        .image-preview {
            max-width: 200px;
            max-height: 200px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            object-fit: cover;
        }

        .remove-preview {
            position: absolute;
            top: -10px;
            right: -10px;
            background: var(--danger-color);
            color: white;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            transition: all 0.3s;
        }

        .remove-preview:hover {
            transform: scale(1.1);
        }

        /* Modal Enhancements */
        .modal-content {
            border-radius: 0.5rem;
            border: none;
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            color: white;
            border-bottom: none;
            padding: 1.25rem 1.5rem;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        .modal-body {
            padding: 1.5rem;
            max-height: calc(100vh - 200px);
            overflow-y: auto;
        }

        .modal-footer {
            border-top: 1px solid #e3e6f0;
            background-color: #f8f9fc;
        }

        /* Button Group Improvements */
        .btn-group .btn {
            margin: 0 2px;
        }

        /* Table Enhancements */
        .table-hover tbody tr:hover {
            background-color: #f8f9fc;
            transition: background-color 0.2s;
        }

        /* Loading Spinner */
        .spinner-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .spinner-overlay.active {
            display: flex;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-mortarboard-fill"></i>
            <span>School System</span>
        </div>

        <ul class="nav flex-column mt-3">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
            @if(Auth::user()->isAdmin() || Auth::user()->isTeacher() || Auth::user()->isStaff())
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('students.*') ? 'active' : '' }}" href="{{ route('students.index') }}">
                        <i class="bi bi-people-fill"></i>
                        <span>Students</span>
                    </a>
                </li>
            @endif

            @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('grades.*') ? 'active' : '' }}" href="{{ route('grades.index') }}">
                        <i class="bi bi-bookmark-fill"></i>
                        <span>Grades</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('subjects.*') ? 'active' : '' }}" href="{{ route('subjects.index') }}">
                        <i class="bi bi-book-fill"></i>
                        <span>Subjects</span>
                    </a>
                </li>
            @endif
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <nav class="topbar">
            <div class="dropdown">
                <div class="user-profile dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="d-none d-lg-inline text-gray-600 small me-2">{{ Auth::user()->user_name ?? 'Guest' }}</span>
                    <div class="user-avatar">
                        {{ substr(Auth::user()->user_name ?? 'G', 0, 1) }}
                    </div>
                </div>
                <ul class="dropdown-menu dropdown-menu-end shadow animated--grow-in">
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="bi bi-box-arrow-right me-2 text-gray-400"></i>
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="content-wrapper">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Loading Spinner -->
    <div class="spinner-overlay" id="loadingSpinner">
        <div class="spinner-border text-light" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Image Preview Functionality
        function setupImagePreview(inputId, previewContainerId) {
            const input = document.getElementById(inputId);
            if (!input) return;

            input.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        let container = document.getElementById(previewContainerId);
                        if (!container) {
                            container = document.createElement('div');
                            container.id = previewContainerId;
                            container.className = 'image-preview-container fade-in';
                            input.parentElement.appendChild(container);
                        }
                        
                        container.innerHTML = `
                            <img src="${event.target.result}" alt="Preview" class="image-preview">
                            <span class="remove-preview" onclick="removePreview('${inputId}', '${previewContainerId}')">
                                <i class="bi bi-x"></i>
                            </span>
                        `;
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        function removePreview(inputId, previewContainerId) {
            const input = document.getElementById(inputId);
            const container = document.getElementById(previewContainerId);
            if (input) input.value = '';
            if (container) container.remove();
        }

        // Initialize image preview on page load
        document.addEventListener('DOMContentLoaded', function() {
            setupImagePreview('image', 'imagePreview');
        });

        // AJAX Form Submission
        function submitFormAjax(formId, successCallback) {
            const form = document.getElementById(formId);
            if (!form) return;

            $(form).on('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const url = $(this).attr('action');
                const method = $(this).attr('method');

                // Show loading
                $('#loadingSpinner').addClass('active');

                $.ajax({
                    url: url,
                    method: method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#loadingSpinner').removeClass('active');
                        if (successCallback) successCallback(response);
                        
                        // Close modal if open
                        $('.modal').modal('hide');

                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Operation completed successfully.',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            // Reload table or redirect
                            window.location.reload();
                        });
                    },
                    error: function(xhr) {
                        $('#loadingSpinner').removeClass('active');
                        let errors = '';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                errors += value[0] + '<br>';
                            });
                        } else {
                            errors = 'An error occurred. Please try again.';
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            html: errors
                        });
                    }
                });
            });
        }

        // Show notification (Legacy support wrapper)
        function showNotification(message, type = 'success') {
            Swal.fire({
                icon: type,
                title: type.charAt(0).toUpperCase() + type.slice(1) + '!',
                text: message,
                timer: 3000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        }

        // Load content in modal via AJAX
        function loadModalContent(url, modalId) {
            $('#loadingSpinner').addClass('active');
            
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    $('#loadingSpinner').removeClass('active');
                    $(modalId).find('.modal-body').html(response);
                    $(modalId).modal('show');
                    
                    // Re-initialize image preview for dynamically loaded forms
                    setupImagePreview('image', 'imagePreview');
                },
                error: function() {
                    $('#loadingSpinner').removeClass('active');
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Failed to load content. Please try again.'
                    });
                }
            });
        }

        // Global Delete Confirmation
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74a3b',
                cancelButtonColor: '#858796',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // Auto-dismiss alerts and show SweetAlert for session messages
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);

            @if(session('success'))
                showNotification("{{ session('success') }}", 'success');
            @endif

            @if(session('error'))
                showNotification("{{ session('error') }}", 'error');
            @endif
        });
    </script>

    @stack('scripts')
</body>
</html>
