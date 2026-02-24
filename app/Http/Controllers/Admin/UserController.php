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
    public function index(Request $request): View
    {
        $role = strtolower((string) $request->query('role', ''));
        $approval = strtolower((string) $request->query('approval', ''));
        $search = trim((string) $request->query('q', ''));

        $role = in_array($role, ['admin', 'teacher', 'student', 'parent'], true) ? $role : '';
        $approval = in_array($approval, ['approved', 'pending'], true) ? $approval : '';

        $baseQuery = User::query()
            ->orderByRaw('CASE WHEN role != "admin" AND is_approved = 0 THEN 0 ELSE 1 END')
            ->latest();

        if ($role !== '') {
            $baseQuery->where('role', $role);
        }

        if ($search !== '') {
            $baseQuery->where(function ($builder) use ($search) {
                $builder->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $allCount = (clone $baseQuery)->count();

        $approvedCount = (clone $baseQuery)
            ->where(function ($builder) {
                $builder->where('role', 'admin')->orWhere('is_approved', true);
            })
            ->count();

        $pendingCount = (clone $baseQuery)
            ->where('role', '!=', 'admin')
            ->where('is_approved', false)
            ->count();

        $query = clone $baseQuery;

        if ($approval === 'approved') {
            $query->where(function ($builder) {
                $builder->where('role', 'admin')->orWhere('is_approved', true);
            });
        } elseif ($approval === 'pending') {
            $query->where('role', '!=', 'admin')->where('is_approved', false);
        }

        $users = $query->paginate(15)->appends([
            'role' => $role,
            'approval' => $approval,
            'q' => $search,
        ]);
        
        return view('admin.users.index', compact('users', 'role', 'approval', 'search', 'allCount', 'approvedCount', 'pendingCount'));
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
                'is_approved' => $validated['role'] === 'admin',
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

    public function approve(User $user): RedirectResponse
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Admin account approval cannot be changed.');
        }

        $user->update(['is_approved' => true]);

        return back()->with('success', $user->name . ' approved successfully.');
    }

    public function revoke(User $user): RedirectResponse
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Admin account approval cannot be changed.');
        }

        $user->update(['is_approved' => false]);

        return back()->with('success', $user->name . ' access revoked.');
    }

    public function bulkApproval(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'action' => ['required', 'in:approve,revoke'],
            'user_ids' => ['required', 'array', 'min:1'],
            'user_ids.*' => ['integer', 'exists:users,id'],
        ]);

        $targetValue = $validated['action'] === 'approve';

        $affected = User::query()
            ->whereIn('id', $validated['user_ids'])
            ->where('role', '!=', 'admin')
            ->update(['is_approved' => $targetValue]);

        if ($affected === 0) {
            return back()->with('error', 'No eligible users were selected for bulk update.');
        }

        $actionLabel = $targetValue ? 'approved' : 'revoked';

        return back()->with('success', $affected . ' user(s) ' . $actionLabel . ' successfully.');
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
