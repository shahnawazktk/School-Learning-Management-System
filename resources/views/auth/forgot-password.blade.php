<x-guest-layout>
    <div class="mb-4">
        <p class="small text-uppercase text-muted fw-semibold mb-2">Password Recovery</p>
        <h3 class="fw-bold mb-2">Forgot your password?</h3>
        <p class="text-muted mb-0">
            Enter your email address and we will send you a secure reset link.
        </p>
    </div>

    @if (session('status'))
        <div class="alert alert-success py-2">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-4">
            <label for="email" class="form-label fw-semibold">Email Address</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                <div class="form-floating">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="form-control @error('email') is-invalid @enderror" placeholder="name@school.edu" />
                    <label for="email">name@school.edu</label>
                </div>
            </div>
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary fw-semibold">
                <i class="fas fa-paper-plane me-1"></i> Email Password Reset Link
            </button>
            <a href="{{ route('login') }}" class="btn btn-outline-secondary">Back to Login</a>
        </div>
    </form>
</x-guest-layout>
