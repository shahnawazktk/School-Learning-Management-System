<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SchoolMS') }} - {{ $title ?? 'Authentication' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- Font Awesome for Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --primary-color: #1e40af;
                --secondary-color: #3b82f6;
                --accent-color: #10b981;
            }
            
            .gradient-bg {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
            
            .gradient-text {
                background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }
            
            .school-theme-bg {
                background: linear-gradient(rgba(30, 64, 175, 0.85), rgba(30, 64, 175, 0.9)), url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAwIiBoZWlnaHQ9IjYwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZGVmcz48cGF0dGVybiBpZD0iZ3JpZCIgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiBwYXR0ZXJuVW5pdHM9InVzZXJTcGFjZU9uVXNlIj48cGF0aCBkPSJNIDQwIDAgTCAwIDAgMCA0MCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSJyZ2JhKDI1NSwgMjU1LCAyNTUsIDAuMSkiIHN0cm9rZS13aWR0aD0iMSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0idXJsKCNncmlkKSIvPjwvc3ZnPg==');
            }
            
            .card-shadow {
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            }
            
            .floating {
                animation: floating 6s ease-in-out infinite;
            }
            
            @keyframes floating {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-20px); }
            }
            
            .pulse {
                animation: pulse 2s infinite;
            }
            
            @keyframes pulse {
                0% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7); }
                70% { box-shadow: 0 0 0 10px rgba(59, 130, 246, 0); }
                100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); }
            }
            
            .btn-primary {
                background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
                transition: all 0.3s ease;
            }
            
            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 20px rgba(30, 64, 175, 0.3);
            }
            
            .input-focus:focus {
                border-color: var(--secondary-color);
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            }
            
            .feature-card {
                transition: all 0.3s ease;
                border: 1px solid rgba(255, 255, 255, 0.1);
            }
            
            .feature-card:hover {
                transform: translateY(-5px);
                border-color: rgba(255, 255, 255, 0.3);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-50 dark:bg-gray-900">
        <!-- Background Pattern -->
        <div class="fixed inset-0 z-0 opacity-5">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAwIiBoZWlnaHQ9IjYwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZGVmcz48cGF0dGVybiBpZD0iZ3JpZCIgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiBwYXR0ZXJuVW5pdHM9InVzZXJTcGFjZU9uVXNlIj48cGF0aCBkPSJNIDQwIDAgTCAwIDAgMCA0MCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSJyZ2JhKDU5LCAxMzAsIDI0NiwgMC4xKSIgc3Ryb2tlLXdpZHRoPSIxIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI2dyaWQpIi8+PC9zdmc+');"></div>
        </div>
        
        <!-- Main Container -->
        <div class="min-h-screen flex flex-col lg:flex-row">
            <!-- Left Side - Branding & Info -->
            <div class="lg:w-1/2 p-8 lg:p-12 flex flex-col justify-center relative z-10 school-theme-bg text-white">
                <!-- Back to Home Link -->
                <div class="absolute top-6 left-6">
                    <a href="/" class="flex items-center text-white hover:text-gray-200 transition">
                        <i class="fas fa-arrow-left mr-2"></i>
                        <span>Back to Home</span>
                    </a>
                </div>
                
                <!-- School Logo & Name -->
                <div class="text-center lg:text-left mb-8">
                    <div class="flex flex-col items-center lg:items-start">
                        <div class="w-24 h-24 rounded-full bg-white flex items-center justify-center shadow-lg mb-4 floating">
                            <svg class="w-12 h-12 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path d="M12 14l9-5-9-5-9 5 9 5z" opacity="0.7" transform="translate(0 7)" />
                                <path d="M12 14l9-5-9-5-9 5 9 5z" opacity="0.4" transform="translate(0 14)" />
                            </svg>
                        </div>
                        <h1 class="text-3xl lg:text-4xl font-bold mb-2">{{ config('app.name', 'SchoolMS') }}</h1>
                        <p class="text-blue-100 text-lg">School Management System</p>
                    </div>
                </div>
                
                <!-- Features List -->
                <div class="mb-10">
                    <h2 class="text-2xl font-bold mb-6">Everything You Need to Manage Your School</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="feature-card p-4 rounded-lg">
                            <div class="flex items-start">
                                <div class="w-10 h-10 rounded-full bg-blue-500 bg-opacity-20 flex items-center justify-center mr-3">
                                    <i class="fas fa-users text-blue-300"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold mb-1">Student Management</h3>
                                    <p class="text-blue-100 text-sm">Track student records, attendance, and performance</p>
                                </div>
                            </div>
                        </div>
                        <div class="feature-card p-4 rounded-lg">
                            <div class="flex items-start">
                                <div class="w-10 h-10 rounded-full bg-green-500 bg-opacity-20 flex items-center justify-center mr-3">
                                    <i class="fas fa-chalkboard-teacher text-green-300"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold mb-1">Teacher Portal</h3>
                                    <p class="text-blue-100 text-sm">Manage classes, assignments, and grading</p>
                                </div>
                            </div>
                        </div>
                        <div class="feature-card p-4 rounded-lg">
                            <div class="flex items-start">
                                <div class="w-10 h-10 rounded-full bg-purple-500 bg-opacity-20 flex items-center justify-center mr-3">
                                    <i class="fas fa-file-invoice-dollar text-purple-300"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold mb-1">Fee Management</h3>
                                    <p class="text-blue-100 text-sm">Automated fee collection and tracking</p>
                                </div>
                            </div>
                        </div>
                        <div class="feature-card p-4 rounded-lg">
                            <div class="flex items-start">
                                <div class="w-10 h-10 rounded-full bg-orange-500 bg-opacity-20 flex items-center justify-center mr-3">
                                    <i class="fas fa-chart-line text-orange-300"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold mb-1">Analytics & Reports</h3>
                                    <p class="text-blue-100 text-sm">Comprehensive reports and insights</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial or Quote -->
                <div class="mt-auto pt-8 border-t border-blue-400 border-opacity-30">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center mr-4">
                            <i class="fas fa-quote-left text-blue-600"></i>
                        </div>
                        <div>
                            <p class="italic text-blue-100">"This system has transformed how we manage our school operations. Highly efficient and user-friendly!"</p>
                            <p class="mt-2 font-semibold">- School Administrator</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Side - Authentication Form -->
            <div class="lg:w-1/2 flex flex-col justify-center items-center p-6 lg:p-12 relative z-10">
                <!-- Form Container -->
                <div class="w-full max-w-md">
                    <!-- Form Header -->
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">
                            @if(request()->routeIs('login'))
                                Welcome Back
                            @elseif(request()->routeIs('register'))
                                Create Account
                            @elseif(request()->routeIs('password.request'))
                                Reset Password
                            @else
                                {{ $title ?? 'Authentication' }}
                            @endif
                        </h2>
                        <p class="text-gray-600 dark:text-gray-400">
                            @if(request()->routeIs('login'))
                                Sign in to access your school management dashboard
                            @elseif(request()->routeIs('register'))
                                Register to get started with our school management system
                            @elseif(request()->routeIs('password.request'))
                                Enter your email to reset your password
                            @else
                                Please complete the form below
                            @endif
                        </p>
                    </div>
                    
                    <!-- Form Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl card-shadow overflow-hidden">
                        <!-- Form Tab Indicators -->
                        <div class="flex border-b border-gray-200 dark:border-gray-700">
                            <a href="{{ route('login') }}" class="flex-1 py-4 text-center {{ request()->routeIs('login') ? 'text-blue-600 dark:text-blue-400 border-b-2 border-blue-600 dark:border-blue-400 font-medium' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300' }}">
                                <i class="fas fa-sign-in-alt mr-2"></i> Login
                            </a>
                            <a href="{{ route('register') }}" class="flex-1 py-4 text-center {{ request()->routeIs('register') ? 'text-blue-600 dark:text-blue-400 border-b-2 border-blue-600 dark:border-blue-400 font-medium' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300' }}">
                                <i class="fas fa-user-plus mr-2"></i> Register
                            </a>
                        </div>
                        
                        <!-- Form Content -->
                        <div class="p-6 md:p-8">
                            <!-- Session Status -->
                            @if (session('status'))
                                <div class="mb-6 p-4 rounded-lg bg-green-50 dark:bg-green-900 text-green-800 dark:text-green-200 border border-green-200 dark:border-green-700">
                                    <div class="flex items-center">
                                        <i class="fas fa-check-circle mr-3"></i>
                                        {{ session('status') }}
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Validation Errors -->
                            @if ($errors->any())
                                <div class="mb-6 p-4 rounded-lg bg-red-50 dark:bg-red-900 text-red-800 dark:text-red-200 border border-red-200 dark:border-red-700">
                                    <div class="flex items-center mb-2">
                                        <i class="fas fa-exclamation-triangle mr-3"></i>
                                        <span class="font-bold">Please fix the following errors:</span>
                                    </div>
                                    <ul class="list-disc pl-5 text-sm">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            
                            <!-- Form Slot -->
                            {{ $slot }}
                        </div>
                        
                        <!-- Form Footer -->
                        <div class="px-6 md:px-8 py-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
                            <!-- Social Login Options -->
                            <div class="text-center mb-4">
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Or continue with</p>
                                <div class="flex justify-center space-x-4">
                                    <a href="#" class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                                        <i class="fab fa-google"></i>
                                    </a>
                                    <a href="#" class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                                        <i class="fab fa-microsoft"></i>
                                    </a>
                                    <a href="#" class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                                        <i class="fab fa-apple"></i>
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Help Links -->
                            <div class="text-center text-sm text-gray-600 dark:text-gray-400">
                                @if(request()->routeIs('login'))
                                    <p>Don't have an account? <a href="{{ route('register') }}" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">Sign up</a></p>
                                    <p class="mt-1">
                                        <a href="{{ route('password.request') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Forgot your password?</a>
                                    </p>
                                @elseif(request()->routeIs('register'))
                                    <p>Already have an account? <a href="{{ route('login') }}" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">Sign in</a></p>
                                @elseif(request()->routeIs('password.request'))
                                    <p>Remember your password? <a href="{{ route('login') }}" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">Back to login</a></p>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Additional Info -->
                    <div class="mt-8 text-center text-sm text-gray-600 dark:text-gray-400">
                        <p>By continuing, you agree to our <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">Terms of Service</a> and <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">Privacy Policy</a>.</p>
                        <p class="mt-2">
                            <a href="#" class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:underline">
                                <i class="fas fa-question-circle mr-2"></i> Need help? Contact support
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <footer class="py-6 text-center text-gray-600 dark:text-gray-400 text-sm border-t border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 relative z-10">
            <div class="container mx-auto px-4">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'SchoolMS') }}. All rights reserved.</p>
                <p class="mt-1">School Management System v2.0</p>
            </div>
        </footer>
        
        <!-- Floating Elements -->
        <div class="fixed top-1/4 left-10 w-4 h-4 rounded-full bg-blue-500 opacity-20 floating" style="animation-delay: 0s;"></div>
        <div class="fixed top-1/3 right-20 w-6 h-6 rounded-full bg-purple-500 opacity-20 floating" style="animation-delay: 1s;"></div>
        <div class="fixed bottom-1/4 left-1/4 w-8 h-8 rounded-full bg-green-500 opacity-20 floating" style="animation-delay: 2s;"></div>
        
        <script>
            // Form input focus effects
            document.addEventListener('DOMContentLoaded', function() {
                const inputs = document.querySelectorAll('input[type="email"], input[type="password"], input[type="text"], input[type="number"]');
                
                inputs.forEach(input => {
                    // Add focus class
                    input.addEventListener('focus', function() {
                        this.parentElement.classList.add('input-focus');
                    });
                    
                    // Remove focus class
                    input.addEventListener('blur', function() {
                        this.parentElement.classList.remove('input-focus');
                    });
                    
                    // Add floating label effect if label exists
                    const label = this.parentElement.querySelector('label');
                    if (label && input.value) {
                        label.classList.add('text-blue-600', 'dark:text-blue-400', '-translate-y-6', 'scale-75');
                    }
                    
                    input.addEventListener('input', function() {
                        if (label) {
                            if (this.value) {
                                label.classList.add('text-blue-600', 'dark:text-blue-400', '-translate-y-6', 'scale-75');
                            } else {
                                label.classList.remove('text-blue-600', 'dark:text-blue-400', '-translate-y-6', 'scale-75');
                            }
                        }
                    });
                });
                
                // Password visibility toggle
                const passwordToggles = document.querySelectorAll('.password-toggle');
                passwordToggles.forEach(toggle => {
                    toggle.addEventListener('click', function() {
                        const input = this.parentElement.querySelector('input');
                        const icon = this.querySelector('i');
                        
                        if (input.type === 'password') {
                            input.type = 'text';
                            icon.classList.remove('fa-eye');
                            icon.classList.add('fa-eye-slash');
                        } else {
                            input.type = 'password';
                            icon.classList.remove('fa-eye-slash');
                            icon.classList.add('fa-eye');
                        }
                    });
                });
            });
        </script>
    </body>
</html>