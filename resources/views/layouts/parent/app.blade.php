<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Parent Portal') | School Management System</title>
    <link rel="icon" href="{{ asset('img/smart-icon.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/parent.css') }}">
</head>
<body>
    <div class="layout-container">
        <!-- Sidebar will be included here -->
        @include('layouts.parent.sidebar')
        
        <!-- Main Content Area -->
        <div class="main-content" id="mainContent">
            <!-- Header will be included here -->
            @include('layouts.parent.header')
            
            <!-- Dynamic Content Area -->
            <div class="content">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/parent.js') }}"></script>
    
    <!-- Page Specific Scripts -->
    @yield('scripts')
</body>
</html>