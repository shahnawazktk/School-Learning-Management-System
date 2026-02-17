<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-4">
            <p class="small text-uppercase text-muted fw-semibold mb-2">
                New Admission
            </p>
            <h3 class="fw-bold mb-2">
                Create LMS account
            </h3>
            <p class="text-muted mb-0">
                Register as a student, teacher, or parent to access your portal.
            </p>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Full Name</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <div class="form-floating">
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                        class="form-control @error('name') is-invalid @enderror" placeholder="Enter full name" />
                    <label for="name">Enter full name</label>
                </div>
            </div>
            @error('name')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email Address</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                <div class="form-floating">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                        class="form-control @error('email') is-invalid @enderror" placeholder="name@school.edu" />
                    <label for="email">name@school.edu</label>
                </div>
            </div>
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="role" class="form-label fw-semibold">Register As</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                <div class="form-floating">
                    <select id="role" name="role" required
                        class="form-select @error('role') is-invalid @enderror">
                        <option value="student" {{ old('role') === 'student' ? 'selected' : '' }}>Student</option>
                        <option value="teacher" {{ old('role') === 'teacher' ? 'selected' : '' }}>Teacher</option>
                        <option value="parent" {{ old('role') === 'parent' ? 'selected' : '' }}>Parent</option>
                    </select>
                    <label for="role">Choose role</label>
                </div>
            </div>
            @error('role')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label fw-semibold">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <div class="form-floating">
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="form-control @error('password') is-invalid @enderror" placeholder="Create password" />
                    <label for="password">Create password</label>
                </div>
            </div>
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-shield-alt"></i></span>
                <div class="form-floating">
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="form-control" placeholder="Re-enter password" />
                    <label for="password_confirmation">Re-enter password</label>
                </div>
            </div>
        </div>

        <div>
            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                Create Account
            </button>
            <p class="text-center text-muted mt-3 mb-0">
                Already have an account?
                <a href="{{ route('login') }}" class="fw-semibold text-decoration-none">
                    Sign in
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
