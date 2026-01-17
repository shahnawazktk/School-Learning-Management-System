<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\School; 

class AdminController extends Controller
{
    // Admin Dashboard
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // Admin Profile
    // public function profile()
    // {
    //     return view('admin.profile');
    // }
    public function profile()
{
    $school = School::first(); // assuming one school record
    return view('admin.profile', compact('school'));
}

public function updateProfile(Request $request)
{
    $request->validate([
        'school_name' => 'required|string|max:255',
        'school_address' => 'required|string|max:500',
        'school_contact' => 'required|string|max:20',
    ]);

    $school = School::first();
    $school->update([
        'name' => $request->school_name,
        'address' => $request->school_address,
        'contact' => $request->school_contact,
    ]);

    return back()->with('success', 'School information updated successfully!');
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
