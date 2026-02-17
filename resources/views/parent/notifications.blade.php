@extends('layouts.parent.app')

@section('title', 'Notifications - Parent Portal')

@push('styles')
<style>
    .notifications-container {
        padding: 20px;
    }
    
    .notification-header {
        margin-bottom: 24px;
    }
    
    .notification-header h2 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1f2937;
    }
    
    .notification-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .notification-item {
        display: flex;
        align-items: flex-start;
        padding: 16px;
        border-bottom: 1px solid #e5e7eb;
        transition: background-color 0.2s;
    }
    
    .notification-item:last-child {
        border-bottom: none;
    }
    
    .notification-item:hover {
        background-color: #f9fafb;
    }
    
    .notification-item.unread {
        background-color: #eff6ff;
    }
    
    .notification-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        flex-shrink: 0;
    }
    
    .notification-icon.info {
        background-color: #dbeafe;
        color: #2563eb;
    }
    
    .notification-icon.success {
        background-color: #d1fae5;
        color: #059669;
    }
    
    .notification-icon.warning {
        background-color: #fef3c7;
        color: #d97706;
    }
    
    .notification-content {
        flex: 1;
    }
    
    .notification-text {
        color: #374151;
        margin-bottom: 4px;
    }
    
    .notification-time {
        font-size: 0.875rem;
        color: #6b7280;
    }
    
    .empty-state {
        text-align: center;
        padding: 40px;
        color: #6b7280;
    }
    
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 16px;
        color: #d1d5db;
    }
    
    .pagination-wrapper {
        padding: 16px;
        display: flex;
        justify-content: center;
    }
</style>
@endpush

@section('content')
<div class="notifications-container">
    <div class="notification-header">
        <h2>Notifications</h2>
        <p class="text-muted">Stay updated with your children's activities</p>
    </div>
    
    <div class="notification-card">
        @if($notifications->count() > 0)
            @foreach($notifications as $notification)
                <div class="notification-item {{ $notification->read_at ? '' : 'unread' }}">
                    <div class="notification-icon info">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div class="notification-content">
                        <p class="notification-text">{{ $notification->data['message'] ?? 'Notification' }}</p>
                        <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            @endforeach
            
            @if($notifications->hasPages())
                <div class="pagination-wrapper">
                    {{ $notifications->links() }}
                </div>
            @endif
        @else
            <div class="empty-state">
                <i class="fas fa-bell-slash"></i>
                <p>No notifications yet</p>
            </div>
        @endif
    </div>
</div>
@endsection
