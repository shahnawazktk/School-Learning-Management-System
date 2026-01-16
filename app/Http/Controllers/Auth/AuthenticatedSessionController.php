<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authenticate user
        $request->authenticate();

        // Regenerate session to prevent session fixation
        $request->session()->regenerate();

        // Redirect based on user role
        return $this->authenticated($request, Auth::user());
    }

    /**
     * Redirect users after login based on role.
     */
    protected function authenticated(Request $request, $user): RedirectResponse
    {
        switch ($user->role) {
            case 'admin':
                return redirect()->intended('/admin/dashboard');
            case 'teacher':
                return redirect()->intended('/teacher/dashboard');
            case 'student':
                return redirect()->intended('/student/dashboard');
            case 'parent':
                return redirect()->intended('/parent/dashboard');
            default:
                return redirect()->intended('/');
        }
    }

    /**
     * Destroy an authenticated session (logout).
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
