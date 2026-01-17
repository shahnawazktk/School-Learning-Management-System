<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }} | Intelligent School Management System</title>
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
            --primary-dark: #4338ca;
            --secondary: #10b981;
            --accent: #f59e0b;
            --dark: #1e293b;
            --light: #f8fafc;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--dark);
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
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
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes pulse-glow {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }

        /* Glass Morphism */
        .glass {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .glass-dark {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Gradient Text */
        .gradient-text {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Stats Counter */
        .stat-number {
            font-size: 3.5rem;
            font-weight: 900;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
        }

        /* Card Hover Effects */
        .portal-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .portal-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: 0.5s;
        }

        .portal-card:hover::before {
            left: 100%;
        }

        .portal-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(79, 70, 229, 0.15);
        }

        /* Feature Icon */
        .feature-icon {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 18px;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            position: relative;
        }

        .feature-icon::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 18px;
            background: currentColor;
            opacity: 0.1;
            z-index: -1;
        }

        /* Testimonial Cards */
        .testimonial-card {
            position: relative;
            overflow: hidden;
        }

        .testimonial-card::before {
            content: '"';
            position: absolute;
            top: -20px;
            left: -10px;
            font-size: 8rem;
            color: var(--primary);
            opacity: 0.1;
            font-family: serif;
            z-index: 0;
        }

        /* Navigation */
        .nav-link {
            position: relative;
            padding: 0.5rem 0;
            font-weight: 500;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        /* Button Styles */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 0.875rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.4);
        }

        .btn-secondary {
            background: white;
            color: var(--primary);
            padding: 0.875rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            border: 2px solid var(--primary);
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: var(--primary);
            color: white;
        }

        /* Hero Section */
        .hero-bg {
            background: linear-gradient(135deg,
                    rgba(79, 70, 229, 0.05) 0%,
                    rgba(16, 185, 129, 0.05) 50%,
                    rgba(245, 158, 11, 0.05) 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-bg::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(79, 70, 229, 0.1) 0%, transparent 70%);
            top: -300px;
            right: -200px;
            z-index: 0;
        }

        /* Stats Section */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
            position: relative;
            z-index: 1;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .hero-bg::before {
                display: none;
            }

            .stat-number {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <!-- Navigation -->
    <nav class="fixed w-full z-50 glass py-4">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <a href="{{ url('/') }}" class="flex items-center gap-3 hover:bg-gray-100  rounded-xl transition">
                    <div
                        class="bg-gradient-to-br from-indigo-600 to-emerald-500 p-3 rounded-2xl  shadow-lg flex items-center justify-center">
                        <img src="{{ asset('img/Smart-logo.png') }}" alt="Smart School Logo"
                            class="h-6 w-auto object-contain">
                    </div>

                    <div>
                        <h1 class="text-2xl font-black text-gray-900 tracking-tight">{{ env('APP_NAME') }}</h1>
                        <p class="text-xs text-gray-500 -mt-1">Intelligent School Management</p>
                    </div>
                </a>
            </div>

            <div class="hidden lg:flex items-center gap-8">
                <a href="#features" class="nav-link text-gray-700">Features</a>
                <a href="#portals" class="nav-link text-gray-700">Portals</a>
                <a href="#testimonials" class="nav-link text-gray-700">Testimonials</a>
                <a href="#contact" class="nav-link text-gray-700">Contact</a>
            </div>

            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-primary">
                        Dashboard <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-secondary">Login</a>
                    <a href="{{ route('register') }}" class="btn-primary">Get Started</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-bg pt-32 pb-24 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center max-w-4xl mx-auto">
                <span
                    class="inline-block px-4 py-2 rounded-full bg-indigo-100 text-indigo-600 font-semibold text-sm mb-6 animate-pulse-glow">
                    🚀 Trusted by 500+ Schools Worldwide
                </span>

                <h1 class="text-5xl md:text-7xl font-black text-gray-900 mb-6 leading-tight">
                    Transform Your School with <span class="gradient-text">Smart Management</span>
                </h1>

                <p class="text-xl text-gray-600 mb-10 leading-relaxed">
                    An all-in-one platform connecting <strong>Administrators, Teachers, Students, and Parents</strong>
                    in a seamless digital ecosystem designed for modern education.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-16">
                    <a href="{{ route('register') }}" class="btn-primary text-lg px-8 py-4">
                        Start Free Trial <i class="fas fa-rocket ml-2"></i>
                    </a>
                    <a href="#demo" class="btn-secondary text-lg px-8 py-4">
                        <i class="fas fa-play-circle mr-2"></i> Watch Demo
                    </a>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="stats-grid mt-16">
                <div class="glass p-8 rounded-3xl text-center">
                    <div class="stat-number">500+</div>
                    <p class="text-gray-600 font-medium mt-2">Schools Worldwide</p>
                </div>
                <div class="glass p-8 rounded-3xl text-center">
                    <div class="stat-number">50K+</div>
                    <p class="text-gray-600 font-medium mt-2">Active Users</p>
                </div>
                <div class="glass p-8 rounded-3xl text-center">
                    <div class="stat-number">99.8%</div>
                    <p class="text-gray-600 font-medium mt-2">Uptime</p>
                </div>
                <div class="glass p-8 rounded-3xl text-center">
                    <div class="stat-number">24/7</div>
                    <p class="text-gray-600 font-medium mt-2">Support</p>
                </div>
            </div>
        </div>

        <!-- Floating Elements -->
        <div
            class="absolute top-1/4 left-10 w-24 h-24 bg-gradient-to-br from-indigo-400 to-emerald-400 rounded-full animate-float opacity-20">
        </div>
        <div
            class="absolute bottom-1/4 right-10 w-32 h-32 bg-gradient-to-br from-amber-400 to-rose-400 rounded-full animate-float opacity-20 animation-delay-2000">
        </div>
    </section>

    <!-- Portals Section -->
    <section id="portals" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-4">
                    Four Portals, <span class="gradient-text">One Ecosystem</span>
                </h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                    Designed for every stakeholder in the educational journey
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Admin Portal -->
                <div class="portal-card glass p-8 rounded-3xl text-center">
                    <div class="feature-icon text-red-600 mx-auto">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Admin Portal</h3>
                    <p class="text-gray-600 mb-6">Complete control over finances, staff management, and institutional
                        settings.</p>
                    <ul class="text-left text-sm text-gray-500 space-y-2 mb-6">
                        <li class="flex items-center gap-2"><i class="fas fa-check text-green-500"></i> Financial
                            Management</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check text-green-500"></i> Staff
                            Administration</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check text-green-500"></i> Global Analytics
                        </li>
                    </ul>
                    <a href="#" class="inline-flex items-center text-indigo-600 font-semibold">
                        Explore <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Teacher Portal -->
                <div class="portal-card glass p-8 rounded-3xl text-center">
                    <div class="feature-icon text-blue-600 mx-auto">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Teacher Portal</h3>
                    <p class="text-gray-600 mb-6">Streamlined tools for attendance, grading, lesson planning, and
                        communication.</p>
                    <ul class="text-left text-sm text-gray-500 space-y-2 mb-6">
                        <li class="flex items-center gap-2"><i class="fas fa-check text-green-500"></i> Attendance
                            Management</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check text-green-500"></i> Gradebook &
                            Reports</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check text-green-500"></i> Lesson
                            Planning
                        </li>
                    </ul>
                    <a href="#" class="inline-flex items-center text-indigo-600 font-semibold">
                        Explore <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Student Portal -->
                <div class="portal-card glass p-8 rounded-3xl text-center">
                    <div class="feature-icon text-emerald-600 mx-auto">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Student Portal</h3>
                    <p class="text-gray-600 mb-6">Interactive learning platform with timetable, assignments, and
                        progress tracking.</p>
                    <ul class="text-left text-sm text-gray-500 space-y-2 mb-6">
                        <li class="flex items-center gap-2"><i class="fas fa-check text-green-500"></i> E-Learning
                            Modules</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check text-green-500"></i> Digital
                            Assignments</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check text-green-500"></i> Progress
                            Analytics</li>
                    </ul>
                    <a href="#" class="inline-flex items-center text-indigo-600 font-semibold">
                        Explore <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Parent Portal -->
                <div class="portal-card glass p-8 rounded-3xl text-center">
                    <div class="feature-icon text-purple-600 mx-auto">
                        <i class="fas fa-users-viewfinder"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Parent Portal</h3>
                    <p class="text-gray-600 mb-6">Stay connected with real-time updates, fee alerts, and performance
                        insights.</p>
                    <ul class="text-left text-sm text-gray-500 space-y-2 mb-6">
                        <li class="flex items-center gap-2"><i class="fas fa-check text-green-500"></i> Fee Management
                        </li>
                        <li class="flex items-center gap-2"><i class="fas fa-check text-green-500"></i> Performance
                            Reports</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check text-green-500"></i> Communication
                            Hub</li>
                    </ul>
                    <a href="#" class="inline-flex items-center text-indigo-600 font-semibold">
                        Explore <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-4">
                    Powerful Features for <span class="gradient-text">Modern Education</span>
                </h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                    Everything you need to run an efficient and engaging educational institution
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="glass p-8 rounded-3xl">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-emerald-500 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-chart-line text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Advanced Analytics</h3>
                    <p class="text-gray-600 mb-6">Real-time insights into student performance, attendance trends, and
                        institutional metrics.</p>
                </div>

                <div class="glass p-8 rounded-3xl">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-amber-500 to-rose-500 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-mobile-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Mobile First</h3>
                    <p class="text-gray-600 mb-6">Access all features from any device with our responsive
                        mobile-friendly interface.</p>
                </div>

                <div class="glass p-8 rounded-3xl">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-green-500 to-blue-500 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Enterprise Security</h3>
                    <p class="text-gray-600 mb-6">Bank-level security with role-based access control and data
                        encryption.</p>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="glass p-8 rounded-3xl">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-sync-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Automated Workflows</h3>
                    <p class="text-gray-600 mb-6">Automate routine tasks like fee reminders, report generation, and
                        attendance marking.</p>
                </div>

                <div class="glass p-8 rounded-3xl">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-comments text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Integrated Communication</h3>
                    <p class="text-gray-600 mb-6">Built-in messaging system for seamless communication between all
                        stakeholders.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section id="testimonials" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-4">
                    Trusted by <span class="gradient-text">Educational Leaders</span>
                </h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                    See what schools and educators are saying about our platform
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="testimonial-card glass p-8 rounded-3xl">
                    <div class="flex items-center gap-4 mb-6">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-indigo-400 to-emerald-400 rounded-full flex items-center justify-center text-white font-bold text-xl">
                            SJ
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">Sarah Johnson</h4>
                            <p class="text-gray-500 text-sm">Principal, Green Valley School</p>
                        </div>
                    </div>
                    <p class="text-gray-700 italic relative z-10">
                        "This platform transformed how we manage our school. The parent engagement has increased by
                        300%!"
                    </p>
                    <div class="flex text-amber-400 mt-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>

                <div class="testimonial-card glass p-8 rounded-3xl">
                    <div class="flex items-center gap-4 mb-6">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-amber-400 to-rose-400 rounded-full flex items-center justify-center text-white font-bold text-xl">
                            MR
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">Michael Roberts</h4>
                            <p class="text-gray-500 text-sm">Math Teacher, Lincoln Academy</p>
                        </div>
                    </div>
                    <p class="text-gray-700 italic relative z-10">
                        "Grading and attendance have never been easier. The interface is intuitive and saves me hours
                        every week."
                    </p>
                    <div class="flex text-amber-400 mt-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>

                <div class="testimonial-card glass p-8 rounded-3xl">
                    <div class="flex items-center gap-4 mb-6">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-purple-400 to-pink-400 rounded-full flex items-center justify-center text-white font-bold text-xl">
                            LP
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">Linda Patel</h4>
                            <p class="text-gray-500 text-sm">Parent & PTA President</p>
                        </div>
                    </div>
                    <p class="text-gray-700 italic relative z-10">
                        "Being able to track my child's progress in real-time has been incredible. The communication
                        features are amazing."
                    </p>
                    <div class="flex text-amber-400 mt-4">
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
    <section class="py-20 bg-gradient-to-br from-indigo-600 via-purple-600 to-emerald-600">
        <div class="max-w-5xl mx-auto px-6 text-center">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6">
                Ready to Transform Your School?
            </h2>
            <p class="text-xl text-indigo-100 mb-10 max-w-2xl mx-auto">
                Join thousands of educational institutions using our platform to streamline operations and enhance
                learning outcomes.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
                <a href="{{ route('register') }}"
                    class="bg-white text-indigo-600 px-10 py-4 rounded-2xl font-bold text-lg hover:bg-gray-100 transition shadow-2xl">
                    Start 30-Day Free Trial
                </a>
                <a href="#demo"
                    class="bg-transparent border-2 border-white text-white px-10 py-4 rounded-2xl font-bold text-lg hover:bg-white/10 transition">
                    <i class="fas fa-calendar mr-2"></i> Schedule Demo
                </a>
            </div>

            <p class="text-indigo-200 text-sm">
                No credit card required • Full support included • Cancel anytime
            </p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 glass-dark text-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="bg-white p-2 rounded-xl">
                            <i class="fas fa-graduation-cap text-indigo-600 text-2xl"></i>
                        </div>
                        <h2 class="text-2xl font-black">{{ env('APP_NAME') }}</h2>
                    </div>
                    <p class="text-gray-300">
                        Empowering educational institutions with intelligent technology solutions since 2018.
                    </p>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-6">Quick Links</h4>
                    <ul class="space-y-3">
                        <li><a href="#features" class="text-gray-300 hover:text-white transition">Features</a></li>
                        <li><a href="#portals" class="text-gray-300 hover:text-white transition">Portals</a></li>
                        <li><a href="#pricing" class="text-gray-300 hover:text-white transition">Pricing</a></li>
                        <li><a href="#contact" class="text-gray-300 hover:text-white transition">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-6">Legal</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Privacy Policy</a>
                        </li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Terms of Service</a>
                        </li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Cookie Policy</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-6">Contact</h4>
                    <ul class="space-y-3 text-gray-300">
                        <li class="flex items-center gap-2"><i class="fas fa-envelope"></i> support@schoolms.com</li>
                        <li class="flex items-center gap-2"><i class="fas fa-phone"></i> +1 (555) 123-4567</li>
                    </ul>
                    <div class="flex gap-4 mt-6">
                        <a href="#"
                            class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-white/20 transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-white/20 transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-white/20 transition">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-12 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} {{ env('APP_NAME') }}. All rights reserved.</p>
                <p class="text-sm mt-2">Powered by <a href="{{ env('APP_AUTHOR_URL') }}"
                        class="text-emerald-400 hover:text-emerald-300">{{ env('APP_AUTHOR_NAME') }}</a></p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            if (window.scrollY > 100) {
                nav.classList.remove('glass');
                nav.classList.add('glass-dark');
            } else {
                nav.classList.remove('glass-dark');
                nav.classList.add('glass');
            }
        });

        // Stats counter animation
        function animateCounter(element, target, duration) {
            let start = 0;
            const increment = target / (duration / 16);
            const timer = setInterval(() => {
                start += increment;
                if (start >= target) {
                    element.textContent = target + '+';
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(start) + '+';
                }
            }, 16);
        }

        // Initialize counters when in view
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counters = entry.target.querySelectorAll('.stat-number');
                    counters.forEach(counter => {
                        const target = parseInt(counter.textContent);
                        counter.textContent = '0';
                        animateCounter(counter, target, 2000);
                    });
                }
            });
        }, {
            threshold: 0.5
        });

        // Observe stats section
        const statsSection = document.querySelector('.stats-grid');
        if (statsSection) observer.observe(statsSection);

        // Add hover effect to portal cards
        document.querySelectorAll('.portal-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-15px) scale(1.02)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Initialize tooltips
        const tooltips = document.querySelectorAll('[data-tooltip]');
        tooltips.forEach(tooltip => {
            tooltip.addEventListener('mouseenter', function() {
                const tooltipText = this.getAttribute('data-tooltip');
                const tooltipEl = document.createElement('div');
                tooltipEl.className =
                    'absolute z-50 px-3 py-2 bg-gray-900 text-white text-sm rounded-lg whitespace-nowrap';
                tooltipEl.textContent = tooltipText;
                document.body.appendChild(tooltipEl);

                const rect = this.getBoundingClientRect();
                tooltipEl.style.top = (rect.top - 40) + 'px';
                tooltipEl.style.left = (rect.left + rect.width / 2 - tooltipEl.offsetWidth / 2) + 'px';

                this.tooltipElement = tooltipEl;
            });

            tooltip.addEventListener('mouseleave', function() {
                if (this.tooltipElement) {
                    this.tooltipElement.remove();
                }
            });
        });
    </script>
</body>

</html>
