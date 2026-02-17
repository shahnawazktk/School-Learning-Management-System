<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            min-height: 100vh;
            background: radial-gradient(circle at 10% 20%, #e0f2fe 0%, #eff6ff 35%, #f8fafc 65%);
        }

        .auth-shell {
            min-height: 100vh;
        }

        .auth-brand {
            width: 58px;
            height: 58px;
            border-radius: 14px;
            background: linear-gradient(135deg, #2563eb, #0891b2);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }

        .auth-card {
            border: 0;
            border-radius: 1rem;
            box-shadow: 0 18px 35px rgba(15, 23, 42, .12);
        }
    </style>
</head>
<body>
    <div class="container auth-shell py-4 py-md-5">
        <div class="row justify-content-center align-items-center min-vh-100 g-0">
            <div class="col-12 col-md-10 col-lg-7 col-xl-5">
                <div class="text-center mb-3">
                    <a href="/" class="text-decoration-none">
                        <span class="auth-brand"><i class="fas fa-graduation-cap"></i></span>
                    </a>
                    <h4 class="mt-3 mb-1 fw-bold text-dark">School LMS Portal</h4>
                    <p class="text-muted mb-0 small">Secure access for students, teachers, parents, and admins.</p>
                </div>

                <div class="card auth-card">
                    <div class="card-body p-4 p-md-5">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
