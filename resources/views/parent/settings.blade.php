esources/views/parent/settings.blade.php</path>
<content.>
@extends('layouts.parent.app')

@section('title', 'Settings - Parent Portal')

@push('styles')
<style>
    .settings-container {
        padding: 20px;
    }
    
    .settings-header {
        margin-bottom: 24px;
    }
    
    .settings-header h2 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1f2937;
    }
    
    .settings-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 24px;
        margin-bottom: 24px;
    }
    
    .settings-card h3 {
        font-size: 1.125rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .form-group {
        margin-bottom: 16px;
    }
    
    .form-group label {
        display: block;
        font-weight: 500;
        color: #374151;
        margin-bottom: 6px;
    }
    
    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 0.875rem;
        transition: border-color 0.2s;
    }
    
    .form-control:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }
    
    .btn {
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-primary {
        background-color: #2563eb;
        color: white;
        border: none;
    }
    
    .btn-primary:hover {
        background-color: #1d4ed8;
    }
    
    .toggle-wrapper {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .toggle-wrapper:last-child {
        border-bottom: none;
    }
    
    .toggle-label {
        font-weight: 500;
        color: #374151;
    }
    
    .toggle-description {
        font-size: 0.875rem;
        color: #6b7280;
        margin-top: 2px;
    }
    
    .toggle-switch {
        position: relative;
        width: 48px;
        height: 24px;
    }
    
    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    
    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #d1d5db;
        transition: 0.4s;
        border-radius: 24px;
    }
    
    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.4s;
        border-radius: 50%;
    }
    
    .toggle-switch input:checked + .toggle-slider {
        background-color: #2563eb;
    }
    
    .toggle-switch input:checked + .toggle-slider:before {
        transform: translateX(24px);
    }
</style>
@endpush

@section('content')
<div class="settings-container">
    <div class="settings-header">
        <h2>Settings</h2>
        <p class="text-muted">Manage your account preferences</p>
    </div>
    
    <form method="POST" action="{{ route('parent.profile.update') }}">
        @csrf
        @method('PUT')
        
        <div class="settings-card">
            <h3>Contact Information</h3>
            
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" class="form-control" value="{{ $parent->phone ?? '' }}" placeholder="Enter phone number">
            </div>
            
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" class="form-control" value="{{ $parent->address ?? '' }}" placeholder="Enter address">
            </div>
            
            <div class="form-group">
                <label for="emergency_contact">Emergency Contact</label>
                <input type="text" id="emergency_contact" name="emergency_contact" class="form-control" value="{{ $parent->emergency_contact ?? '' }}" placeholder="Enter emergency contact">
            </div>
        </div>
        
        <div class="settings-card">
            <h3>Notification Preferences</h3>
            
            <div class="toggle-wrapper">
                <div>
                    <div class="toggle-label">Email Notifications</div>
                    <div class="toggle-description">Receive notifications via email</div>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" name="email_notifications" value="1" {{ ($parent->email_notifications ?? true) ? 'checked' : '' }}>
                    <span class="toggle-slider"></span>
                </label>
            </div>
            
            <div class="toggle-wrapper">
                <div>
                    <div class="toggle-label">SMS Notifications</div>
                    <div class="toggle-description">Receive important updates via SMS</div>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" name="sms_notifications" value="1" {{ ($parent->sms_notifications ?? false) ? 'checked' : '' }}>
                    <span class="toggle-slider"></span>
                </label>
            </div>
            
            <div class="toggle-wrapper">
                <div>
                    <div class="toggle-label">Attendance Alerts</div>
                    <div class="toggle-description">Get notified when your child is marked absent</div>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" name="attendance_alerts" value="1" {{ ($parent->attendance_alerts ?? true) ? 'checked' : '' }}>
                    <span class="toggle-slider"></span>
                </label>
            </div>
            
            <div class="toggle-wrapper">
                <div>
                    <div class="toggle-label">Grade Updates</div>
                    <div class="toggle-description">Get notified about new grades</div>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" name="grade_updates" value="1" {{ ($parent->grade_updates ?? true) ? 'checked' : '' }}>
                    <span class="toggle-slider"></span>
                </label>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary">Save Settings</button>
    </form>
</div>
@endsection
