<x-guest-layout>
    <div class="mb-4">
        <p class="small text-uppercase text-muted fw-semibold mb-2">Security Check</p>
        <h3 class="fw-bold mb-2">Confirm your password</h3>
        <p class="text-muted mb-0">
            This is a secure area. Please confirm your password before continuing.
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="mb-4">
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

        <div class="d-grid">
            <button type="submit" class="btn btn-primary fw-semibold">
                <i class="fas fa-shield-alt me-1"></i> Confirm
            </button>
        </div>
    </form>
</x-guest-layout>
