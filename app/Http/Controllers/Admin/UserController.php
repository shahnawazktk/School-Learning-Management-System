<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParentModel;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use App\Notifications\AdminNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::query()
            ->latest()
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', 'in:admin,teacher,student,parent'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
            ]);

            $this->ensureRoleProfile($user);

            return $user;
        });

        $admin = User::where('role', 'admin')
            ->where('id', '!=', $user->id)
            ->first();

        if ($admin) {
            $admin->notify(new AdminNotification('New user created by admin: ' . $user->name . ' (' . $user->role . ')'));
        }

        return back()->with('success', 'User created successfully.');
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
