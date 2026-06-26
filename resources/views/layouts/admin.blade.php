<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin - Gangguan Pipa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.gangguan.index') }}">
                <i class="fas fa-tint"></i> Admin Gangguan Pipa
            </a>
            <a href="{{ route('public.dashboard') }}" class="btn btn-light btn-sm" target="_blank">
                <i class="fas fa-eye"></i> Dashboard
            </a>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>