<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Admin Dashboard
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // Admin Profile
    public function profile()
    {
        return view('admin.profile');
    }

    // All Users
    public function users()
    {
        return view('admin.users.index');
    }

    // Settings
    public function settings()
    {
        return view('admin.settings');
    }

    // Logout
    public function logout(Request $request)
    {
        auth()->logout();
        return redirect('/login');
    }
}
