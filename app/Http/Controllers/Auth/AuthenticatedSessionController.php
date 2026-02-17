<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\ParentModel;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
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
        if ($user instanceof User) {
            $this->ensureRoleProfile($user);
        }

        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'teacher':
                return redirect()->route('teacher.dashboard');
            case 'student':
                return redirect()->route('student.dashboard');
            case 'parent':
                return redirect()->route('parent.dashboard');
            default:
                return redirect()->route('dashboard');
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

    private function ensureRoleProfile(User $user): void
    {
        if ($user->role === 'student') {
            Student::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'student_id' => $this->nextIdentity('students', 'student_id', 'STU'),
                    'enrollment_date' => now()->toDateString(),
                    'status' => 'active',
                ]
            );
            return;
        }

        if ($user->role === 'teacher') {
            Teacher::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'teacher_id' => $this->nextIdentity('teachers', 'teacher_id', 'TCH'),
                    'joining_date' => now()->toDateString(),
                    'status' => 'active',
                ]
            );
            return;
        }

        if ($user->role === 'parent') {
            $attributes = ['user_id' => $user->id];
            $values = [];
            if (Schema::hasColumn('parents', 'parent_id')) {
                $values['parent_id'] = $this->nextIdentity('parents', 'parent_id', 'PAR');
            }

            ParentModel::firstOrCreate($attributes, $values);
        }
    }

    private function nextIdentity(string $table, string $column, string $prefix): string
    {
        $year = now()->format('Y');

        for ($i = 1; $i <= 999999; $i++) {
            $candidate = $prefix . $year . str_pad((string) $i, 4, '0', STR_PAD_LEFT);
            $exists = DB::table($table)->where($column, $candidate)->exists();
            if (!$exists) {
                return $candidate;
            }
        }

        return $prefix . $year . now()->format('His');
    }
}
