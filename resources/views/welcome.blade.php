<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }} | Intelligent School Management</title>
    <link rel="icon" href="{{ asset('img/smart-icon.png') }}" type="image/png">

    <!-- Fonts & Icons -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
        :root {
            --primary: #4f46e5;
            --primary-light: #6366f1;
            --primary-dark: #4338ca;
            --secondary: #10b981;
            --secondary-light: #34d399;
            --accent: #f59e0b;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #64748b;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--dark);
            background: #ffffff;
            overflow-x: hidden;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
        }

        /* Custom Animations */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        @keyframes pulse-ring {
            0% {
                transform: scale(0.8);
                opacity: 0.8;
            }

            100% {
                transform: scale(1.2);
                opacity: 0;
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-shimmer {
            position: relative;
            overflow: hidden;
        }

        .animate-shimmer::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            animation: shimmer 2s infinite;
        }

        .animate-pulse-ring {
            animation: pulse-ring 2s infinite;
        }

        /* Glass Effect */
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .glass-dark {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Gradient Backgrounds */
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        }

        .gradient-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        }

        .gradient-secondary {
            background: linear-gradient(135deg, var(--secondary) 0%, #059669 100%);
        }

        .gradient-accent {
            background: linear-gradient(135deg, var(--accent) 0%, #d97706 100%);
        }

        /* Gradient Text */
        .gradient-text {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .gradient-text-reverse {
            background: linear-gradient(135deg, var(--secondary) 0%, var(--primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Custom Components */
        .feature-card {
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 10px;
            background: white;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary);
            transform: scaleY(0);
            transition: transform 0.4s ease;
        }

        .feature-card:hover::before {
            transform: scaleY(1);
        }

        .portal-card {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            transition: all 0.4s ease;
        }

        .portal-card:hover {
            transform: translateY(-5px);
        }

        .portal-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }

        .stat-card {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            padding: 2rem;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(transparent, rgba(79, 70, 229, 0.1), transparent 30%);
            animation: rotate 4s linear infinite;
        }

        @keyframes rotate {
            100% {
                transform: rotate(360deg);
            }
        }

        /* Custom Navigation */
        .nav-link {
            position: relative;
            padding: 0.5rem 1rem;
            color: var(--dark);
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 1rem;
            right: 1rem;
            height: 2px;
            background: var(--primary);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .nav-link:hover::after {
            transform: scaleX(1);
        }

        .nav-link.active {
            color: var(--primary);
            font-weight: 600;
        }

        .nav-link.active::after {
            transform: scaleX(1);
        }

        /* Custom Buttons */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.875rem 2rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            font-weight: 600;
            border-radius: 12px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
            border: none;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.4);
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.875rem 2rem;
            background: white;
            color: var(--primary);
            font-weight: 600;
            border-radius: 12px;
            border: 2px solid var(--primary);
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
        }

        .btn-accent {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.875rem 2rem;
            background: linear-gradient(135deg, var(--accent) 0%, #d97706 100%);
            color: white;
            font-weight: 600;
            border-radius: 12px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
            cursor: pointer;
            text-decoration: none;
        }

        .btn-accent:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
        }

        /* Custom Shadows */
        .shadow-soft {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .shadow-medium {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .shadow-hard {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Custom Shapes */
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(40px);
            opacity: 0.3;
            z-index: -1;
        }

        .wave-shape {
            position: absolute;
            width: 100%;
            overflow: hidden;
            line-height: 0;
            transform: rotate(180deg);
        }

        .wave-shape svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 80px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem !important;
                line-height: 1.2 !important;
            }

            .section-title {
                font-size: 2rem !important;
            }

            .stat-grid {
                grid-template-columns: repeat(2, 1fr) !important;
            }
        }

        @media (max-width: 480px) {
            .stat-grid {
                grid-template-columns: 1fr !important;
            }

            .hero-title {
                font-size: 2rem !important;
            }
        }

        /* Custom Utilities */
        .text-balance {
            text-wrap: balance;
        }

        .perspective-1000 {
            perspective: 1000px;
        }

        .backface-hidden {
            backface-visibility: hidden;
        }

        .transform-style-3d {
            transform-style: preserve-3d;
        }
    </style>
</head>

<body class="bg-gray-90">
    <!-- Header & Navigation -->
    <header class="sticky top-0 z-50 glass shadow-medium">
        <nav class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <div class="gradient-primary p-3 rounded-xl shadow-lg ">
                        <img src="{{ asset('img/Smart-logo.png') }}" alt="Smart School Logo" class="h-8 w-auto">
                    </div>
                    <div>
                        <h1 class="text-1xl font-bold text-gray-900">{{ env('APP_NAME') }}</h1>
                        {{-- <p class="text-xs text-gray-600 -mt-1">Intelligent School Management</p> --}}
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-8">
                    <a href="#home" class="nav-link active">Home</a>
                    <a href="#features" class="nav-link">Features</a>
                    <a href="#portals" class="nav-link">Portals</a>
                    <a href="#pricing" class="nav-link">Pricing</a>
                    <a href="#testimonials" class="nav-link">Testimonials</a>
                    <div class="relative group">
                        <button class="nav-link flex items-center">
                            Solutions <i class="fas fa-chevron-down ml-2 text-xs"></i>
                        </button>
                        <div
                            class="absolute left-0 mt-2 w-56 bg-white rounded-xl shadow-hard py-3 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-primary">
                                <i class="fas fa-school mr-3"></i>K-12 Schools
                            </a>
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-primary">
                                <i class="fas fa-university mr-3"></i>Colleges
                            </a>
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-primary">
                                <i class="fas fa-graduation-cap mr-3"></i>Universities
                            </a>
                        </div>
                    </div>
                </div>

                <!-- CTA Buttons -->
                <div class="hidden lg:flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-primary">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-secondary px-4 py-2 text-sm">Sign In</a>
                        <a href="{{ route('register') }}" class="btn-primary px-4 py-2 text-sm">Get Started</a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-button" class="lg:hidden p-2 rounded-lg text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="lg:hidden hidden py-4 border-t">
                <div class="flex flex-col space-y-3">
                    <a href="#home" class="nav-link active px-4">Home</a>
                    <a href="#features" class="nav-link px-4">Features</a>
                    <a href="#portals" class="nav-link px-4">Portals</a>
                    <a href="#pricing" class="nav-link px-4">Pricing</a>
                    <a href="#testimonials" class="nav-link px-4">Testimonials</a>
                    <div class="px-4">
                        <div class="text-sm font-semibold text-gray-900 mb-2">Solutions</div>
                        <div class="space-y-2 pl-4">
                            <a href="#" class="block text-gray-600 hover:text-primary">K-12 Schools</a>
                            <a href="#" class="block text-gray-600 hover:text-primary">Colleges</a>
                            <a href="#" class="block text-gray-600 hover:text-primary">Universities</a>
                        </div>
                    </div>
                    <div class="pt-4 border-t">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn-primary w-full">
                                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                            </a>
                        @else
                            <div class="flex space-x-3">
                                <a href="{{ route('login') }}" class="btn-secondary flex-1 text-center">Sign In</a>
                                <a href="{{ route('register') }}" class="btn-primary flex-1 text-center">Get Started</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section id="home" class="relative overflow-hidden bg-gradient-to-br from-gray-50 to-indigo-50 pt-8 pb-20">
        <!-- Background Blobs -->
        {{-- <div class="blob bg-indigo-200 w-96 h-96 top-10 left-10 animate-float"></div>
        <div class="blob bg-purple-200 w-80 h-80 bottom-10 right-10 animate-float" style="animation-delay: 2s;"></div>
        <div class="blob bg-blue-200 w-64 h-64 top-1/2 right-1/4 animate-float" style="animation-delay: 4s;"></div> --}}

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-6xl mx-auto">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <!-- Hero Content -->
                    <div class="animate__animated animate__fadeInUp">
                        <div
                            class="inline-flex items-center px-4 py-2 rounded-full bg-indigo-100 text-indigo-600 font-semibold text-sm mb-6">
                            <i class="fas fa-star mr-2"></i> Trusted by 500+ Schools Worldwide
                        </div>

                        <h1 class="hero-title text-5xl md:text-6xl font-black text-gray-900 mb-6 leading-tight">
                            Transform Your School with <span class="gradient-text">Smart Management</span>
                        </h1>

                        <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                            An all-in-one intelligent platform that seamlessly connects administrators, teachers,
                            students, and parents in a unified digital ecosystem.
                        </p>

                        <div class="flex flex-wrap gap-4 mb-12">
                            <a href="{{ route('register') }}" class="btn-primary">
                                <i class="fas fa-rocket mr-2"></i> Start Free Trial
                            </a>
                            <a href="#demo" class="btn-secondary">
                                <i class="fas fa-play-circle mr-2"></i> Watch Demo
                            </a>
                        </div>

                        <!-- Trust Indicators -->
                        <div class="flex flex-wrap items-center gap-6">
                            <div class="flex items-center">
                                <div class="flex -space-x-2">
                                    <div class="w-10 h-10 rounded-full border-2 border-white bg-indigo-600"></div>
                                    <div class="w-10 h-10 rounded-full border-2 border-white bg-emerald-600"></div>
                                    <div class="w-10 h-10 rounded-full border-2 border-white bg-amber-600"></div>
                                    <div class="w-10 h-10 rounded-full border-2 border-white bg-purple-600"></div>
                                </div>
                                <span class="ml-4 text-gray-600 font-medium">500+ Schools Trust Us</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-shield-alt text-emerald-500 mr-2"></i>
                                <span>Bank-Level Security</span>
                            </div>
                        </div>
                    </div>

                    <!-- Hero Visual -->
                    <div class="relative animate__animated animate__fadeIn">
                        <div class="relative perspective-1000">
                            <!-- Main Dashboard Preview -->
                            <div
                                class="bg-white rounded-3xl shadow-hard p-8 transform rotate-3 hover:rotate-0 transition-transform duration-500">
                                <div class="flex items-center justify-between mb-6">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-3 h-3 rounded-full bg-red-400"></div>
                                        <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                                        <div class="w-3 h-3 rounded-full bg-green-400"></div>
                                    </div>
                                    <div class="text-sm text-gray-500">Dashboard Preview</div>
                                </div>
                                <div class="grid grid-cols-3 gap-4 mb-6">
                                    <div class="h-4 bg-gradient-to-r from-indigo-400 to-indigo-300 rounded-full"></div>
                                    <div class="h-4 bg-gradient-to-r from-emerald-400 to-emerald-300 rounded-full">
                                    </div>
                                    <div class="h-4 bg-gradient-to-r from-amber-400 to-amber-300 rounded-full"></div>
                                </div>
                                <div class="space-y-4">
                                    <div class="h-24 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-4">
                                        <div class="flex justify-between items-center">
                                            <div class="w-1/3 h-3 bg-blue-200 rounded-full"></div>
                                            <div
                                                class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-400 to-blue-600">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="h-24 bg-gradient-to-r from-emerald-50 to-green-50 rounded-xl p-4">
                                        <div class="flex justify-between items-center">
                                            <div class="w-1/2 h-3 bg-emerald-200 rounded-full"></div>
                                            <div
                                                class="w-8 h-8 rounded-full bg-gradient-to-r from-emerald-400 to-emerald-600">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Floating Elements -->
                            <div
                                class="absolute -top-6 -right-6 w-32 h-32 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-2xl shadow-xl animate-float">
                            </div>
                            <div class="absolute -bottom-6 -left-6 w-24 h-24 bg-gradient-to-br from-emerald-500 to-cyan-500 rounded-2xl shadow-xl animate-float"
                                style="animation-delay: 3s;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid stat-grid grid-cols-4 gap-8">
                <div class="stat-card bg-gradient-to-br from-indigo-50 to-white text-center">
                    <div class="stat-number text-5xl font-black text-indigo-600 mb-2">500+</div>
                    <p class="text-gray-600 font-medium">Schools Worldwide</p>
                </div>
                <div class="stat-card bg-gradient-to-br from-emerald-50 to-white text-center">
                    <div class="stat-number text-5xl font-black text-emerald-600 mb-2">50K+</div>
                    <p class="text-gray-600 font-medium">Active Users</p>
                </div>
                <div class="stat-card bg-gradient-to-br from-amber-50 to-white text-center">
                    <div class="stat-number text-5xl font-black text-amber-600 mb-2">99.8%</div>
                    <p class="text-gray-600 font-medium">System Uptime</p>
                </div>
                <div class="stat-card bg-gradient-to-br from-purple-50 to-white text-center">
                    <div class="stat-number text-5xl font-black text-purple-600 mb-2">24/7</div>
                    <p class="text-gray-600 font-medium">Support Available</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Portals Section -->
    <section id="portals" class="py-8 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="section-title text-4xl md:text-5xl font-black text-gray-900 mb-4">
                    Four Portals, <span class="gradient-text">One Ecosystem</span>
                </h2>
                <p class="text-xl text-gray-600">
                    Designed specifically for each stakeholder in the educational journey
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Admin Portal -->
                <div class="portal-card bg-white shadow-medium hover:shadow-hard">
                    <div class="p-8">
                        <div class="w-16 h-16 gradient-primary rounded-2xl flex items-center justify-center mb-6">
                            <i class="fas fa-user-shield text-2xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Admin Portal</h3>
                        <p class="text-gray-600 mb-6">Complete control over finances, staff management, and
                            institutional settings.</p>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-check-circle text-emerald-500 mr-3"></i>
                                Financial Management
                            </li>
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-check-circle text-emerald-500 mr-3"></i>
                                Staff Administration
                            </li>
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-check-circle text-emerald-500 mr-3"></i>
                                Global Analytics
                            </li>
                        </ul>
                        <a href="#"
                            class="inline-flex items-center text-indigo-600 font-semibold hover:text-indigo-700">
                            Explore Portal <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>

                <!-- Teacher Portal -->
                <div class="portal-card bg-white shadow-medium hover:shadow-hard">
                    <div class="p-8">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center mb-6">
                            <i class="fas fa-chalkboard-teacher text-2xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Teacher Portal</h3>
                        <p class="text-gray-600 mb-6">Streamlined tools for attendance, grading, lesson planning, and
                            communication.</p>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-check-circle text-emerald-500 mr-3"></i>
                                Attendance Management
                            </li>
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-check-circle text-emerald-500 mr-3"></i>
                                Gradebook & Reports
                            </li>
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-check-circle text-emerald-500 mr-3"></i>
                                Lesson Planning
                            </li>
                        </ul>
                        <a href="#"
                            class="inline-flex items-center text-indigo-600 font-semibold hover:text-indigo-700">
                            Explore Portal <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>

                <!-- Student Portal -->
                <div class="portal-card bg-white shadow-medium hover:shadow-hard">
                    <div class="p-8">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-green-500 rounded-2xl flex items-center justify-center mb-6">
                            <i class="fas fa-user-graduate text-2xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Student Portal</h3>
                        <p class="text-gray-600 mb-6">Interactive learning platform with timetable, assignments, and
                            progress tracking.</p>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-check-circle text-emerald-500 mr-3"></i>
                                E-Learning Modules
                            </li>
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-check-circle text-emerald-500 mr-3"></i>
                                Digital Assignments
                            </li>
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-check-circle text-emerald-500 mr-3"></i>
                                Progress Analytics
                            </li>
                        </ul>
                        <a href="#"
                            class="inline-flex items-center text-indigo-600 font-semibold hover:text-indigo-700">
                            Explore Portal <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>

                <!-- Parent Portal -->
                <div class="portal-card bg-white shadow-medium hover:shadow-hard">
                    <div class="p-8">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mb-6">
                            <i class="fas fa-users-viewfinder text-2xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Parent Portal</h3>
                        <p class="text-gray-600 mb-6">Stay connected with real-time updates, fee alerts, and
                            performance insights.</p>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-check-circle text-emerald-500 mr-3"></i>
                                Fee Management
                            </li>
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-check-circle text-emerald-500 mr-3"></i>
                                Performance Reports
                            </li>
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-check-circle text-emerald-500 mr-3"></i>
                                Communication Hub
                            </li>
                        </ul>
                        <a href="#"
                            class="inline-flex items-center text-indigo-600 font-semibold hover:text-indigo-700">
                            Explore Portal <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-8 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="section-title text-4xl md:text-5xl font-black text-gray-900 mb-4">
                    Powerful Features for <span class="gradient-text-reverse">Modern Education</span>
                </h2>
                <p class="text-xl text-gray-600">
                    Everything you need to run an efficient and engaging educational institution
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                <div class="feature-card p-8">
                    <div class="w-14 h-14 gradient-primary rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-chart-line text-2xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Advanced Analytics</h3>
                    <p class="text-gray-600 mb-6">Real-time insights into student performance, attendance trends, and
                        institutional metrics.</p>
                    <a href="#" class="text-indigo-600 font-semibold hover:text-indigo-700">
                        Learn More <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <div class="feature-card p-8">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-amber-500 to-orange-500 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-mobile-alt text-2xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Mobile First</h3>
                    <p class="text-gray-600 mb-6">Access all features from any device with our responsive
                        mobile-friendly interface.</p>
                    <a href="#" class="text-indigo-600 font-semibold hover:text-indigo-700">
                        Learn More <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <div class="feature-card p-8">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-green-500 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-shield-alt text-2xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Enterprise Security</h3>
                    <p class="text-gray-600 mb-6">Bank-level security with role-based access control and data
                        encryption.</p>
                    <a href="#" class="text-indigo-600 font-semibold hover:text-indigo-700">
                        Learn More <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <div class="feature-card p-8">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-sync-alt text-2xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Automated Workflows</h3>
                    <p class="text-gray-600 mb-6">Automate routine tasks like fee reminders, report generation, and
                        attendance marking.</p>
                    <a href="#" class="text-indigo-600 font-semibold hover:text-indigo-700">
                        Learn More <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <div class="feature-card p-8">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-comments text-2xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Integrated Communication</h3>
                    <p class="text-gray-600 mb-6">Built-in messaging system for seamless communication between all
                        stakeholders.</p>
                    <a href="#" class="text-indigo-600 font-semibold hover:text-indigo-700">
                        Learn More <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-8 bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-900">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-8">
                <h2 class="text-4xl md:text-5xl font-black text-white mb-4">
                    Trusted by <span class="gradient-text">Educational Leaders</span>
                </h2>
                <p class="text-xl text-indigo-200">
                    See what schools and educators are saying about our platform
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-8">
                    <div class="flex items-center mb-6">
                        <div
                            class="w-16 h-16 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold text-xl mr-4">
                            SJ
                        </div>
                        <div>
                            <h4 class="font-bold text-white">Sarah Johnson</h4>
                            <p class="text-indigo-200 text-sm">Principal, Green Valley School</p>
                        </div>
                    </div>
                    <p class="text-white/90 italic mb-6">
                        "This platform transformed how we manage our school. The parent engagement has increased by 300%
                        and administrative tasks are now 70% faster!"
                    </p>
                    <div class="flex text-amber-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-8">
                    <div class="flex items-center mb-6">
                        <div
                            class="w-16 h-16 rounded-full bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center text-white font-bold text-xl mr-4">
                            MR
                        </div>
                        <div>
                            <h4 class="font-bold text-white">Michael Roberts</h4>
                            <p class="text-indigo-200 text-sm">Math Teacher, Lincoln Academy</p>
                        </div>
                    </div>
                    <p class="text-white/90 italic mb-6">
                        "Grading and attendance have never been easier. The interface is intuitive and saves me hours
                        every week. Highly recommended!"
                    </p>
                    <div class="flex text-amber-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-8">
                    <div class="flex items-center mb-6">
                        <div
                            class="w-16 h-16 rounded-full bg-gradient-to-br from-emerald-500 to-green-500 flex items-center justify-center text-white font-bold text-xl mr-4">
                            LP
                        </div>
                        <div>
                            <h4 class="font-bold text-white">Linda Patel</h4>
                            <p class="text-indigo-200 text-sm">Parent & PTA President</p>
                        </div>
                    </div>
                    <p class="text-white/90 italic mb-6">
                        "Being able to track my child's progress in real-time has been incredible. The communication
                        features keep us connected with teachers."
                    </p>
                    <div class="flex text-amber-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-4xl md:text-5xl font-black text-white mb-6">
                    Ready to Transform Your School?
                </h2>
                <p class="text-xl text-indigo-100 mb-10">
                    Join thousands of educational institutions using our platform to streamline operations and enhance
                    learning outcomes.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
                    <a href="{{ route('register') }}" class="btn-accent px-10 py-4 text-lg">
                        <i class="fas fa-rocket mr-2"></i> Start 30-Day Free Trial
                    </a>
                    <a href="#demo"
                        class="btn-secondary px-10 py-4 text-lg bg-white/10 border-white text-white hover:bg-white hover:text-indigo-600">
                        <i class="fas fa-calendar mr-2"></i> Schedule Demo
                    </a>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-2xl mx-auto">
                    <div class="text-center">
                        <i class="fas fa-credit-card text-white/60 text-2xl mb-2"></i>
                        <p class="text-white text-sm">No credit card required</p>
                    </div>
                    <div class="text-center">
                        <i class="fas fa-headset text-white/60 text-2xl mb-2"></i>
                        <p class="text-white text-sm">Full support included</p>
                    </div>
                    <div class="text-center">
                        <i class="fas fa-clock text-white/60 text-2xl mb-2"></i>
                        <p class="text-white text-sm">Cancel anytime</p>
                    </div>
                    <div class="text-center">
                        <i class="fas fa-shield-alt text-white/60 text-2xl mb-2"></i>
                        <p class="text-white text-sm">Data protected</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white pt-16 pb-8">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 lg:grid-cols-5 gap-8 mb-12">
                <!-- Company Info -->
                <div class="lg:col-span-2">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="gradient-primary p-3 rounded-xl">
                            <img src="{{ asset('img/Smart-logo.png') }}" alt="Smart School Logo" class="h-8 w-auto">
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold">{{ env('APP_NAME') }}</h2>
                            <p class="text-gray-400">Intelligent School Management System</p>
                        </div>
                    </div>
                    <p class="text-gray-400 mb-8 max-w-md">
                        Empowering educational institutions with comprehensive LMS solutions since 2018. Streamline
                        administration, enhance learning experiences, and connect all stakeholders.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#"
                            class="social-icon w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-indigo-600 transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#"
                            class="social-icon w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#"
                            class="social-icon w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-400 transition-colors">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#"
                            class="social-icon w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-pink-600 transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-bold mb-6 text-white">Quick Links</h3>
                    <ul class="space-y-3">
                        <li><a href="#home"
                                class="footer-link text-gray-400 hover:text-white flex items-center transition-colors">
                                <i class="fas fa-chevron-right text-xs mr-3 text-indigo-400"></i>Home
                            </a></li>
                        <li><a href="#features"
                                class="footer-link text-gray-400 hover:text-white flex items-center transition-colors">
                                <i class="fas fa-chevron-right text-xs mr-3 text-indigo-400"></i>Features
                            </a></li>
                        <li><a href="#portals"
                                class="footer-link text-gray-400 hover:text-white flex items-center transition-colors">
                                <i class="fas fa-chevron-right text-xs mr-3 text-indigo-400"></i>Portals
                            </a></li>
                        <li><a href="#pricing"
                                class="footer-link text-gray-400 hover:text-white flex items-center transition-colors">
                                <i class="fas fa-chevron-right text-xs mr-3 text-indigo-400"></i>Pricing
                            </a></li>
                    </ul>
                </div>

                <!-- Solutions -->
                <div>
                    <h3 class="text-lg font-bold mb-6 text-white">Solutions</h3>
                    <ul class="space-y-3">
                        <li><a href="#"
                                class="footer-link text-gray-400 hover:text-white flex items-center transition-colors">
                                <i class="fas fa-school text-xs mr-3 text-emerald-400"></i>K-12 Schools
                            </a></li>
                        <li><a href="#"
                                class="footer-link text-gray-400 hover:text-white flex items-center transition-colors">
                                <i class="fas fa-university text-xs mr-3 text-emerald-400"></i>Colleges
                            </a></li>
                        <li><a href="#"
                                class="footer-link text-gray-400 hover:text-white flex items-center transition-colors">
                                <i class="fas fa-graduation-cap text-xs mr-3 text-emerald-400"></i>Universities
                            </a></li>
                        <li><a href="#"
                                class="footer-link text-gray-400 hover:text-white flex items-center transition-colors">
                                <i class="fas fa-chalkboard-teacher text-xs mr-3 text-emerald-400"></i>Training Centers
                            </a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="text-lg font-bold mb-6 text-white">Contact Us</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt text-indigo-400 mt-1 mr-3"></i>
                            <span class="text-gray-400">123 Education Street,<br>Tech City, TC 10101</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone text-indigo-400 mr-3"></i>
                            <span class="text-gray-400">+1 (555) 123-4567</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope text-indigo-400 mr-3"></i>
                            <span class="text-gray-400">support@schoolms.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Newsletter -->
            <div class="border-t border-gray-800 pt-8 mb-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-center">
                    <div class="lg:col-span-2">
                        <h3 class="text-lg font-bold mb-2 text-white">Stay Updated</h3>
                        <p class="text-gray-400">Subscribe to our newsletter for the latest updates and educational
                            insights.</p>
                    </div>
                    <div class="flex">
                        <input type="email" placeholder="Your email address"
                            class="flex-grow px-4 py-3 rounded-l-lg bg-gray-800 border border-gray-700 text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                        <button
                            class="bg-indigo-600 hover:bg-indigo-700 px-6 py-3 rounded-r-lg font-medium transition-colors">
                            <i class="fas fa-paper-plane mr-2"></i>Subscribe
                        </button>
                    </div>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-gray-800 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="text-gray-400 text-sm mb-4 md:mb-0">
                        <p>&copy; {{ date('Y') }} {{ env('APP_NAME') }}. All rights reserved.</p>
                    </div>
                    <div class="flex space-x-6 text-sm">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">Privacy Policy</a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">Terms of
                            Service</a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">Cookie Policy</a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">Sitemap</a>
                    </div>
                </div>
                <div class="text-center text-gray-500 text-xs mt-6">
                    <p>Powered by <a href="{{ env('APP_AUTHOR_URL') }}"
                            class="text-emerald-400 hover:text-emerald-300">{{ env('APP_AUTHOR_NAME') }}</a> | ISO
                        27001 Certified | GDPR Compliant</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="back-to-top"
        class="fixed bottom-8 right-8 w-12 h-12 gradient-primary rounded-full shadow-lg text-white hidden items-center justify-center hover:shadow-xl transition-all">
        <i class="fas fa-chevron-up"></i>
    </button>

    <!-- JavaScript -->
    <script>
        // Mobile Menu Toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            const icon = mobileMenuButton.querySelector('i');
            icon.classList.toggle('fa-bars');
            icon.classList.toggle('fa-times');
        });

        // Smooth Scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;

                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    // Close mobile menu if open
                    mobileMenu.classList.add('hidden');
                    mobileMenuButton.querySelector('i').classList.replace('fa-times', 'fa-bars');

                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Back to Top Button
        const backToTopButton = document.getElementById('back-to-top');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                backToTopButton.classList.remove('hidden');
                backToTopButton.classList.add('flex');
            } else {
                backToTopButton.classList.remove('flex');
                backToTopButton.classList.add('hidden');
            }
        });

        backToTopButton.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Active Navigation
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('.nav-link');

        window.addEventListener('scroll', () => {
            let current = '';
            const scrollPosition = window.scrollY + 100;

            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.add('active');
                }
            });
        });

        // Navbar Scroll Effect
        const header = document.querySelector('header');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                header.classList.add('shadow-xl');
                header.classList.remove('shadow-medium');
            } else {
                header.classList.remove('shadow-xl');
                header.classList.add('shadow-medium');
            }
        });

        // Counter Animation
        const counters = document.querySelectorAll('.stat-number');
        const speed = 200;

        const animateCounter = (counter) => {
            const target = parseInt(counter.textContent);
            const count = +counter.innerText;
            const increment = target / speed;

            if (count < target) {
                counter.innerText = Math.ceil(count + increment);
                setTimeout(() => animateCounter(counter), 1);
            } else {
                counter.innerText = target + (counter.textContent.includes('+') ? '+' : '');
            }
        };

        // Intersection Observer for Counters
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    counters.forEach(counter => {
                        counter.innerText = '0';
                        animateCounter(counter);
                    });
                }
            });
        }, {
            threshold: 0.5
        });

        // Observe stats section
        const statsSection = document.querySelector('.stat-grid');
        if (statsSection) {
            observer.observe(statsSection);
        }

        // Newsletter Form
        const newsletterForm = document.querySelector('footer form');
        if (newsletterForm) {
            newsletterForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const emailInput = newsletterForm.querySelector('input[type="email"]');
                if (emailInput.value) {
                    emailInput.value = '';
                    alert('Thank you for subscribing to our newsletter!');
                }
            });
        }

        // Card Hover Effects
        document.querySelectorAll('.feature-card, .portal-card').forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-10px)';
            });

            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>

</html>
