<x-guest-layout>
    <div class="mb-4">
        <p class="small text-uppercase text-muted fw-semibold mb-2">Email Verification</p>
        <h3 class="fw-bold mb-2">Verify your email address</h3>
        <p class="text-muted mb-0">
            We sent a verification link to your email. Click it to activate your account.
            If you did not receive it, request another link below.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success py-2">
            A new verification link has been sent to your email address.
        </div>
    @endif

    <div class="d-grid gap-2">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <button type="submit" class="btn btn-primary w-100 fw-semibold">
                <i class="fas fa-paper-plane me-1"></i> Resend Verification Email
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="btn btn-outline-secondary w-100">
                <i class="fas fa-right-from-bracket me-1"></i> Log Out
            </button>
        </form>
    </div>
</x-guest-layout>
