<x-guest-layout>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-6">
            <p class="text-xs uppercase tracking-[0.2em] text-gray-500 dark:text-gray-400">
                LMS Access
            </p>
            <h3 class="mt-2 text-xl font-semibold text-gray-900 dark:text-gray-100">
                Sign in to continue
            </h3>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Use your school email and password to access your dashboard.
            </p>
        </div>

        <div class="space-y-4">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</label>
                <div class="mt-1 relative">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                        class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 pr-11 text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="name@school.edu" />
                    <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-400">
                        <i class="fas fa-envelope"></i>
                    </span>
                </div>
                @error('email')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                <div class="mt-1 relative">
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 pr-11 text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter password" />
                    <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-400">
                        <i class="fas fa-lock"></i>
                    </span>
                </div>
                @error('password')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <label for="remember_me" class="inline-flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <input id="remember_me" type="checkbox" name="remember"
                    class="rounded border-gray-300 dark:border-gray-700 text-blue-600 focus:ring-blue-500">
                Remember me
            </label>
            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300"
                    href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            @endif
        </div>

        <div class="mt-6">
            <button type="submit"
                class="w-full rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-md transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Sign In
            </button>
            <p class="mt-4 text-center text-sm text-gray-600 dark:text-gray-400">
                New to the portal?
                <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                    Create account
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
