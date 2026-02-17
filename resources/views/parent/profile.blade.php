@extends('layouts.parent.app')

@section('content')
<div class="page-header">
    <div class="header-title">
        <h1><i class="fas fa-user-circle"></i> My Profile</h1>
        <p>View and update your profile information</p>
    </div>
</div>

<div class="profile-container">
    <!-- Profile Overview -->
    <div class="profile-overview">
        <div class="profile-card main">
            <div class="profile-avatar">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>
            <div class="profile-info">
                <h2>{{ $user->name }}</h2>
                <p class="profile-email"><i class="fas fa-envelope"></i> {{ $user->email }}</p>
                <p class="profile-role"><i class="fas fa-user-tag"></i> Parent</p>
            </div>
        </div>

        <!-- Linked Children Summary -->
        <div class="linked-children-card">
            <h3><i class="fas fa-child"></i> Linked Children</h3>
            @php
                $children = \App\Models\ParentModel::where('user_id', auth()->id())->first()->students ?? collect();
            @endphp
            @if($children->count() > 0)
            <div class="children-list">
                @foreach($children as $child)
                <div class="child-item">
                    <div class="child-avatar-small">
                        {{ strtoupper(substr($child->user->name, 0, 1)) }}
                    </div>
                    <div class="child-info">
                        <span class="child-name">{{ $child->user->name }}</span>
                        <span class="child-class">{{ $child->class }} - {{ $child->section }}</span>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="no-children">No children linked yet</p>
            @endif
        </div>
    </div>

    <!-- Profile Details Form -->
    <div class="profile-form-section">
        <h2><i class="fas fa-edit"></i> Update Profile</h2>
        
        @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif

        <form method="POST" action="{{ route('parent.profile.update') }}" class="profile-form">
            @csrf
            @method('PUT')

            <div class="form-section">
                <h3>Personal Information</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="relationship"><i class="fas fa-heart"></i> Relationship to Child</label>
                        <select name="relationship" id="relationship" class="form-control">
                            <option value="">Select Relationship</option>
                            <option value="father" {{ $parent->relationship == 'father' ? 'selected' : '' }}>Father</option>
                            <option value="mother" {{ $parent->relationship == 'mother' ? 'selected' : '' }}>Mother</option>
                            <option value="guardian" {{ $parent->relationship == 'guardian' ? 'selected' : '' }}>Guardian</option>
                            <option value="other" {{ $parent->relationship == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="occupation"><i class="fas fa-briefcase"></i> Occupation</label>
                        <input type="text" name="occupation" id="occupation" class="form-control" 
                               value="{{ old('occupation', $parent->occupation) }}" placeholder="Your occupation">
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3>Contact Information</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="phone"><i class="fas fa-phone"></i> Phone Number</label>
                        <input type="text" name="phone" id="phone" class="form-control" 
                               value="{{ old('phone', $parent->phone) }}" placeholder="Your phone number">
                    </div>
                    <div class="form-group">
                        <label for="emergency_contact"><i class="fas fa-exclamation-circle"></i> Emergency Contact</label>
                        <input type="text" name="emergency_contact" id="emergency_contact" class="form-control" 
                               value="{{ old('emergency_contact', $parent->emergency_contact) }}" placeholder="Emergency contact number">
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3>Address</h3>
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label for="address"><i class="fas fa-home"></i> Street Address</label>
                        <input type="text" name="address" id="address" class="form-control" 
                               value="{{ old('address', $parent->address) }}" placeholder="Street address">
                    </div>
                    <div class="form-group">
                        <label for="city"><i class="fas fa-city"></i> City</label>
                        <input type="text" name="city" id="city" class="form-control" 
                               value="{{ old('city', $parent->city) }}" placeholder="City">
                    </div>
                    <div class="form-group">
                        <label for="state"><i class="fas fa-map"></i> State</label>
                        <input type="text" name="state" id="state" class="form-control" 
                               value="{{ old('state', $parent->state) }}" placeholder="State">
                    </div>
                    <div class="form-group">
                        <label for="zip_code"><i class="fas fa-mail-bulk"></i> ZIP Code</label>
                        <input type="text" name="zip_code" id="zip_code" class="form-control" 
                               value="{{ old('zip_code', $parent->zip_code) }}" placeholder="ZIP Code">
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </div>
        </form>
    </div>

    <!-- Account Information -->
    <div class="account-info">
        <h2><i class="fas fa-shield-alt"></i> Account Information</h2>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Account Status</span>
                <span class="info-value active"><i class="fas fa-check-circle"></i> Active</span>
            </div>
            <div class="info-item">
                <span class="info-label">Email Verified</span>
                <span class="info-value {{ $user->email_verified_at ? 'verified' : '' }}">
                    <i class="fas fa-{{ $user->email_verified_at ? 'check-circle' : 'exclamation-circle' }}"></i>
                    {{ $user->email_verified_at ? 'Verified' : 'Not Verified' }}
                </span>
            </div>
            <div class="info-item">
                <span class="info-label">Member Since</span>
                <span class="info-value">{{ $user->created_at->format('M d, Y') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Last Login</span>
                <span class="info-value">{{ $user->last_login_at ? $user->last_login_at->format('M d, Y - h:i A') : 'N/A' }}</span>
            </div>
        </div>
    </div>
</div>

<style>
    .page-header {
        margin-bottom: 2rem;
    }
    .header-title h1 {
        font-size: 1.8rem;
        color: #1e293b;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .header-title h1 i {
        color: var(--primary-color);
    }
    .header-title p {
        color: #64748b;
    }
    .profile-container {
        display: grid;
        gap: 1.5rem;
    }
    .profile-overview {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
    }
    .profile-card {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: var(--card-shadow);
    }
    .profile-card.main {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    }
    .profile-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: white;
        color: var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: 700;
        flex-shrink: 0;
    }
    .profile-info h2 {
        font-size: 1.8rem;
        color: white;
        margin-bottom: 0.5rem;
    }
    .profile-email, .profile-role {
        color: rgba(255,255,255,0.9);
        margin: 0.3rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .linked-children-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: var(--card-shadow);
    }
    .linked-children-card h3 {
        font-size: 1.1rem;
        color: #1e293b;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .children-list {
        display: flex;
        flex-direction: column;
        gap: 0.8rem;
    }
    .child-item {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        padding: 0.5rem;
        background: #f8fafc;
        border-radius: 8px;
    }
    .child-avatar-small {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--primary-color);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        flex-shrink: 0;
    }
    .child-info {
        display: flex;
        flex-direction: column;
    }
    .child-name {
        font-weight: 600;
        color: #1e293b;
    }
    .child-class {
        font-size: 0.8rem;
        color: #64748b;
    }
    .no-children {
        color: #64748b;
        font-style: italic;
    }
    .profile-form-section, .account-info {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: var(--card-shadow);
    }
    .profile-form-section h2, .account-info h2 {
        font-size: 1.3rem;
        color: #1e293b;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .profile-form-section h2 i, .account-info h2 i {
        color: var(--primary-color);
    }
    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .alert-success {
        background-color: #d1fae5;
        color: #059669;
    }
    .form-section {
        margin-bottom: 2rem;
    }
    .form-section h3 {
        font-size: 1.1rem;
        color: #1e293b;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #e2e8f0;
    }
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
    }
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    .form-group.full-width {
        grid-column: 1 / -1;
    }
    .form-group label {
        font-weight: 600;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .form-control {
        padding: 0.75rem;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: border-color var(--transition-speed);
    }
    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
    }
    .form-actions {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e2e8f0;
    }
    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        font-size: 0.95rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all var(--transition-speed);
    }
    .btn-primary {
        background-color: var(--primary-color);
        color: white;
    }
    .btn-primary:hover {
        background-color: var(--primary-dark);
        transform: translateY(-2px);
    }
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
    }
    .info-item {
        background: #f8fafc;
        padding: 1rem;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
    }
    .info-label {
        font-size: 0.85rem;
        color: #64748b;
    }
    .info-value {
        font-weight: 600;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }
    .info-value.active {
        color: #10b981;
    }
    .info-value.verified {
        color: #10b981;
    }

    @media (max-width: 768px) {
        .profile-overview {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
