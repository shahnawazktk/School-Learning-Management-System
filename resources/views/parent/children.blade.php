@extends('layouts.parent.app')

@section('content')
<div class="page-header">
    <div class="header-title">
        <h1><i class="fas fa-child"></i> My Children</h1>
        <p>View all your linked children and their academic information</p>
    </div>
</div>

<!-- Children Cards -->
<div class="children-grid">
    @forelse($students as $student)
    <div class="child-card">
        <div class="child-header">
            <div class="child-avatar">
                {{ strtoupper(substr($student->user->name, 0, 2)) }}
            </div>
            <div class="child-info">
                <h3>{{ $student->user->name }}</h3>
                <p class="student-id">ID: {{ $student->student_id }}</p>
            </div>
        </div>
        
        <div class="child-details">
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-graduation-cap"></i> Class</span>
                <span class="detail-value">{{ $student->class }} - {{ $student->section }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-hashtag"></i> Roll No</span>
                <span class="detail-value">{{ $student->roll_number }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-book"></i> Enrolled Courses</span>
                <span class="detail-value">{{ $student->enrollments->count() }}</span>
            </div>
        </div>

        <div class="child-actions">
            <a href="{{ route('parent.child.details', $student->id) }}" class="btn btn-primary">
                <i class="fas fa-eye"></i> View Details
            </a>
            <a href="{{ route('parent.child.grades', $student->id) }}" class="btn btn-success">
                <i class="fas fa-chart-line"></i> Grades
            </a>
        </div>
    </div>
    @empty
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fas fa-child"></i>
        </div>
        <h3>No Children Found</h3>
        <p>No children are linked to your account. Please contact the school administration.</p>
    </div>
    @endforelse
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
    .children-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.5rem;
    }
    .child-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: var(--card-shadow);
        transition: all var(--transition-speed);
    }
    .child-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--card-shadow-hover);
    }
    .child-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e2e8f0;
    }
    .child-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 700;
        flex-shrink: 0;
    }
    .child-info h3 {
        font-size: 1.3rem;
        color: #1e293b;
        margin-bottom: 0.2rem;
    }
    .student-id {
        color: #64748b;
        font-size: 0.9rem;
    }
    .child-details {
        margin-bottom: 1.5rem;
    }
    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
    }
    .detail-label {
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .detail-value {
        font-weight: 600;
        color: #1e293b;
    }
    .child-actions {
        display: flex;
        gap: 0.8rem;
    }
    .btn {
        padding: 0.6rem 1rem;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        font-size: 0.85rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        flex: 1;
        justify-content: center;
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
    .btn-success {
        background-color: #10b981;
        color: white;
    }
    .btn-success:hover {
        background-color: #059669;
        transform: translateY(-2px);
    }
    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 12px;
    }
    .empty-icon {
        font-size: 4rem;
        color: #d1d5db;
        margin-bottom: 1rem;
    }
    .empty-state h3 {
        color: #1e293b;
        margin-bottom: 0.5rem;
    }
    .empty-state p {
        color: #64748b;
    }
</style>
@endsection
