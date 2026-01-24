<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Frontend\FrontendController;
// use App\Http\Controllers\Auth\AuthenticatedSessionController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
Route::resource('teachers', TeacherController::class);

Route::post('/admin/notifications/read', function () {
    auth()->user()->unreadNotifications->markAsRead();
    return back();
})->name('admin.notifications.read');

Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    // Route::get('/profile', [AdminController::class, 'profile'])
    //     ->name('admin.profile'); // ✅ FIX
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::put('/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');

    Route::get('/users', [AdminController::class, 'users'])
        ->name('admin.users');

    Route::get('/settings', [AdminController::class, 'settings'])
        ->name('admin.settings');

    Route::post('/logout', [AdminController::class, 'logout'])
        ->name('admin.logout');
});


Route::get('/', function () {
    return view('welcome');
});

// Login Routes (Breeze or your auth.php routes)
require __DIR__.'/auth.php';

// Role-based dashboards
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

Route::middleware(['auth', 'role:teacher'])->group(function () {
    Route::get('/teacher/dashboard', function () {
        return view('teacher.dashboard');
    })->name('teacher.dashboard');
});

Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/subjects', [StudentController::class, 'subjects'])->name('subjects');
    Route::get('/assignments', [StudentController::class, 'assignments'])->name('assignments');
    Route::get('/attendance', [StudentController::class, 'attendance'])->name('attendance');
    Route::get('/results', [StudentController::class, 'results'])->name('results');
    Route::get('/resources', [StudentController::class, 'resources'])->name('resources');
    Route::get('/profile', [StudentController::class, 'profile'])->name('profile');

    // API routes for AJAX functionality
    Route::post('/assignments/{assignment}/submit', [StudentController::class, 'submitAssignment'])->name('assignments.submit');
    Route::get('/resources/{resource}/download', [StudentController::class, 'downloadResource'])->name('resources.download');
});

Route::middleware(['auth', 'role:parent'])->group(function () {
    Route::get('/parent/dashboard', function () {
        return view('parent.dashboard');
    })->name('parent.dashboard');
});

// Universal dashboard route that redirects based on user role
Route::middleware('auth')->get('/dashboard', function () {
    $user = Auth::user();

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
            return redirect('/');
    }
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});