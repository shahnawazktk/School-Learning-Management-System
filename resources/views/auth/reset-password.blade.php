<x-guest-layout>
    <div class="mb-4">
        <p class="small text-uppercase text-muted fw-semibold mb-2">Security Update</p>
        <h3 class="fw-bold mb-2">Reset your password</h3>
        <p class="text-muted mb-0">Create a new password to secure your LMS account.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email Address</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                <div class="form-floating">
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
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
                        class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Re-enter password" />
                    <label for="password_confirmation">Re-enter password</label>
                </div>
            </div>
            @error('password_confirmation')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary fw-semibold">
                <i class="fas fa-key me-1"></i> Reset Password
            </button>
        </div>
    </form>
</x-guest-layout>
