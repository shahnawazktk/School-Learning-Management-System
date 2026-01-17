@extends('layouts.admin.app')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Admin Settings</h1>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <!-- Left Column: Personal Info -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Profile Information</h5>
                    </div>
                    <div class="card-body">
                        <form action="#" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name', auth()->user()->name) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ old('email', auth()->user()->email) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="profile_photo" class="form-label">Profile Photo</label>
                                <input type="file" name="profile_photo" id="profile_photo" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Column: Password Change -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Change Password</h5>
                    </div>
                    <div class="card-body">
                        <form action="#" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" name="current_password" id="current_password" class="form-control"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="password" name="new_password" id="new_password" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                    class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-warning">Change Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Optional: School Info Settings -->
        <div class="card mt-4">
            <div class="card-header">
                <h5>School Information</h5>
            </div>
            <div class="card-body">
                <form action="#" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="school_name" class="form-label">School Name</label>
                        <input type="text" name="school_name" id="school_name" class="form-control"
                            value="{{ old('school_name', $school->name ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="school_address" class="form-label">Address</label>
                        <textarea name="school_address" id="school_address" class="form-control" rows="2" required>{{ old('school_address', $school->address ?? '') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="school_contact" class="form-label">Contact</label>
                        <input type="text" name="school_contact" id="school_contact" class="form-control"
                            value="{{ old('school_contact', $school->contact ?? '') }}" required>
                    </div>

                    <button type="submit" class="btn btn-success">Update School Info</button>
                </form>
            </div>
        </div>
    </div>
@endsection
