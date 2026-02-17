<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-6">
            <p class="text-xs uppercase tracking-[0.2em] text-gray-500 dark:text-gray-400">
                New Admission
            </p>
            <h3 class="mt-2 text-xl font-semibold text-gray-900 dark:text-gray-100">
                Create LMS account
            </h3>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Register as a student, teacher, or parent to access your portal.
            </p>
        </div>

        <div class="space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name</label>
                <div class="mt-1 relative">
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                        class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 pr-11 text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter full name" />
                    <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-400">
                        <i class="fas fa-user"></i>
                    </span>
                </div>
                @error('name')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</label>
                <div class="mt-1 relative">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
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
                <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Register As</label>
                <div class="mt-1 relative">
                    <select id="role" name="role" required
                        class="w-full appearance-none rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 pr-11 text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="student" {{ old('role') === 'student' ? 'selected' : '' }}>Student</option>
                        <option value="teacher" {{ old('role') === 'teacher' ? 'selected' : '' }}>Teacher</option>
                        <option value="parent" {{ old('role') === 'parent' ? 'selected' : '' }}>Parent</option>
                    </select>
                    <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-400">
                        <i class="fas fa-user-tag"></i>
                    </span>
                </div>
                @error('role')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                <div class="mt-1 relative">
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 pr-11 text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Create password" />
                    <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-400">
                        <i class="fas fa-lock"></i>
                    </span>
                </div>
                @error('password')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm Password</label>
                <div class="mt-1 relative">
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 pr-11 text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Re-enter password" />
                    <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-400">
                        <i class="fas fa-shield-alt"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <button type="submit"
                class="w-full rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-md transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Create Account
            </button>
            <p class="mt-4 text-center text-sm text-gray-600 dark:text-gray-400">
                Already have an account?
                <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                    Sign in
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
