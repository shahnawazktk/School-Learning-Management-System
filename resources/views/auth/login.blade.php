<x-guest-layout>
    @if (session('status'))
        <div class="alert alert-success py-2">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-4">
            <p class="small text-uppercase text-muted fw-semibold mb-2">
                LMS Access
            </p>
            <h3 class="fw-bold mb-2">
                Sign in to continue
            </h3>
            <p class="text-muted mb-0">
                Use your school email and password to access your dashboard.
            </p>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email Address</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                <div class="form-floating">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                        class="form-control @error('email') is-invalid @enderror" placeholder="name@school.edu" />
                    <label for="email">name@school.edu</label>
                </div>
            </div>
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label fw-semibold">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <div class="form-floating">
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="form-control @error('password') is-invalid @enderror" placeholder="Enter password" />
                    <label for="password">Enter password</label>
                </div>
            </div>
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-4">
            <div class="form-check">
                <input id="remember_me" type="checkbox" name="remember" class="form-check-input">
                <label for="remember_me" class="form-check-label">Remember me</label>
            </div>
            @if (Route::has('password.request'))
                <a class="small fw-semibold text-decoration-none" href="{{ route('password.request') }}">Forgot password?</a>
            @endif
        </div>

        <div>
            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                Sign In
            </button>
            <p class="text-center text-muted mt-3 mb-0">
                New to the portal?
                <a href="{{ route('register') }}" class="fw-semibold text-decoration-none">
                    Create account
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
