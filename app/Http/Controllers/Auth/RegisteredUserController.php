<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ParentModel;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'role' => ['required', 'in:student,teacher,parent'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'password' => Hash::make($request->password),
            ]);

            $this->ensureRoleProfile($user);

            return $user;
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
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
