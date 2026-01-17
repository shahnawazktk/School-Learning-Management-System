<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request)
{
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => $request->role,
    ]);
}
// 🔔 Admin Notification
    $admin = User::where('role', 'admin')->first();
    if ($admin) {
        $admin->notify(new AdminNotification('New user registered'));
    }

    return redirect()->back();

}
