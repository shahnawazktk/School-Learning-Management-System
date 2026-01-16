<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }} | Professional School Management</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; overflow-x: hidden; }
        .hero-gradient { background: radial-gradient(circle at top right, #eef2ff 0%, #ffffff 50%, #f8fafc 100%); }
        .role-card { transition: all 0.3s ease; border: 2px solid transparent; }
        .role-card:hover { border-color: #4f46e5; transform: scale(1.02); }
        .glass-nav { backdrop-filter: blur(12px); background: rgba(255, 255, 255, 0.8); }
        .blob { position: absolute; width: 600px; height: 600px; background: linear-gradient(135deg, rgba(79, 70, 229, 0.07) 0%, rgba(59, 130, 246, 0.07) 100%); filter: blur(100px); border-radius: 50%; z-index: -1; }
    </style>
</head>
<body class="hero-gradient min-h-screen">

    <div class="blob -top-20 -left-20"></div>
    <div class="blob bottom-0 -right-20"></div>

    <nav class="sticky top-0 z-50 glass-nav border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="bg-indigo-600 p-2 rounded-xl shadow-lg shadow-indigo-200">
                    <i class="fas fa-graduation-cap text-white text-xl"></i>
                </div>
                <span class="text-2xl font-extrabold text-gray-900 tracking-tight italic">
                    {{ env('APP_NAME') }}<span class="text-indigo-600">.</span>
                </span>
            </div>
            
            <div class="hidden md:flex items-center gap-8 text-sm font-bold text-gray-600 uppercase tracking-widest">
                <a href="#roles" class="hover:text-indigo-600 transition">Portals</a>
                <a href="#features" class="hover:text-indigo-600 transition">Modules</a>
            </div>

            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-6 py-2.5 bg-indigo-600 text-white font-bold rounded-xl shadow-md hover:bg-indigo-700 transition duration-300">
                        Dashboard <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-6 py-2.5 text-indigo-600 font-bold border-2 border-indigo-600 rounded-xl hover:bg-indigo-50 transition">@lang('Login')</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 pt-16 pb-12 text-center">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-5xl md:text-7xl font-black text-gray-900 leading-tight mb-6">
                One Platform. <span class="text-indigo-600 underline decoration-indigo-200">Total Control.</span>
            </h1>
            <p class="text-xl text-gray-600 mb-10 leading-relaxed">
                Smart school management system designed to connect <span class="font-bold text-gray-800">Administrators, Teachers, Students,</span> and <span class="font-bold text-gray-800">Parents</span> in a single digital ecosystem.
            </p>
        </div>

        <section id="roles" class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="role-card bg-white p-8 rounded-[2rem] shadow-sm text-center">
                <div class="w-16 h-16 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl shadow-inner">
                    <i class="fas fa-user-shield"></i>
                </div>
                <h3 class="font-extrabold text-gray-900 text-lg uppercase tracking-tighter">Admin Portal</h3>
                <p class="text-gray-500 text-sm mt-2">Finances, Staff Control & Global Settings.</p>
            </div>

            <div class="role-card bg-white p-8 rounded-[2rem] shadow-sm text-center">
                <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl shadow-inner">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <h3 class="font-extrabold text-gray-900 text-lg uppercase tracking-tighter">Teacher Portal</h3>
                <p class="text-gray-500 text-sm mt-2">Attendance, Grading & Lesson Planning.</p>
            </div>

            <div class="role-card bg-white p-8 rounded-[2rem] shadow-sm text-center">
                <div class="w-16 h-16 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl shadow-inner">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <h3 class="font-extrabold text-gray-900 text-lg uppercase tracking-tighter">Student Portal</h3>
                <p class="text-gray-500 text-sm mt-2">E-Learning, Timetable & Progress Reports.</p>
            </div>

            <div class="role-card bg-white p-8 rounded-[2rem] shadow-sm text-center">
                <div class="w-16 h-16 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl shadow-inner">
                    <i class="fas fa-users-viewfinder"></i>
                </div>
                <h3 class="font-extrabold text-gray-900 text-lg uppercase tracking-tighter">Parent Portal</h3>
                <p class="text-gray-500 text-sm mt-2">Fee Alerts, Performance & Circulars.</p>
            </div>
        </section>

        <div class="mt-16 flex flex-col md:flex-row justify-center items-center gap-6">
            <div class="text-left">
                <h4 class="text-2xl font-bold text-gray-900">Ready to transform your school?</h4>
                <p class="text-gray-500">Join 2,000+ students and educators today.</p>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('register') }}" class="px-10 py-4 bg-gray-900 text-white font-bold rounded-2xl hover:bg-indigo-700 transition shadow-xl">
                    Get Started Free
                </a>
                <a href="{{ env('APP_FB') }}" class="px-10 py-4 bg-white border border-gray-200 text-gray-700 font-bold rounded-2xl hover:bg-gray-50 transition">
                    Learn More
                </a>
            </div>
        </div>
    </main>

    <footer class="mt-20 py-12 bg-white border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-12 items-center">
            <div>
                <span class="text-xl font-bold text-indigo-600">{{ env('APP_NAME') }}</span>
                <p class="text-gray-400 text-sm mt-2">Building the future of education with smart technology.</p>
            </div>
            <div class="text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} All Rights Reserved. <br>
                Powered by <a href="{{ env('APP_AUTHOR_URL') }}" class="font-bold text-gray-900">{{ env('APP_AUTHOR_NAME') }}</a>
            </div>
            <div class="flex justify-end gap-4 text-gray-400">
                <a href="#" class="hover:text-indigo-600"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="hover:text-indigo-600"><i class="fab fa-twitter"></i></a>
                <a href="#" class="hover:text-indigo-600"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>