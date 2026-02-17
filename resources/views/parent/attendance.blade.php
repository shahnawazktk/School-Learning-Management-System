@extends('layouts.parent.app')

@section('content')
<div class="page-header">
    <div class="header-title">
        <h1><i class="fas fa-calendar-check"></i> Attendance Records</h1>
        <p>View attendance history for {{ $student->user->name }}</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('parent.child.details', $student->id) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Details
        </a>
    </div>
</div>

<!-- Attendance Overview Cards -->
<div class="attendance-overview">
    <div class="overview-card total">
        <div class="overview-icon">
            <i class="fas fa-calendar-alt"></i>
        </div>
        <div class="overview-info">
            <h3>Total Classes</h3>
            <p class="overview-value">{{ $totalClasses }}</p>
        </div>
    </div>

    <div class="overview-card present">
        <div class="overview-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="overview-info">
            <h3>Present</h3>
            <p class="overview-value">{{ $presentCount }}</p>
        </div>
    </div>

    <div class="overview-card absent">
        <div class="overview-icon">
            <i class="fas fa-times-circle"></i>
        </div>
        <div class="overview-info">
            <h3>Absent</h3>
            <p class="overview-value">{{ $absentCount }}</p>
        </div>
    </div>

    <div class="overview-card late">
        <div class="overview-icon">
            <i class="fas fa-clock"></i>
        </div>
        <div class="overview-info">
            <h3>Late</h3>
            <p class="overview-value">{{ $lateCount }}</p>
        </div>
    </div>

    <div class="overview-card percentage">
        <div class="overview-icon">
            <i class="fas fa-percentage"></i>
        </div>
        <div class="overview-info">
            <h3>Attendance Rate</h3>
            <p class="overview-value">{{ $attendancePercentage }}%</p>
        </div>
    </div>
</div>

<!-- Attendance Progress Bar -->
<div class="progress-section">
    <h2><i class="fas fa-chart-pie"></i> Attendance Overview</h2>
    <div class="progress-bars">
        <div class="progress-item">
            <div class="progress-label">
                <span>Present</span>
                <span class="progress-value">{{ $totalClasses > 0 ? round(($presentCount / $totalClasses) * 100) : 0 }}%</span>
            </div>
            <div class="progress-track">
                <div class="progress-fill present" style="width: {{ $totalClasses > 0 ? ($presentCount / $totalClasses) * 100 : 0 }}%"></div>
            </div>
        </div>
        <div class="progress-item">
            <div class="progress-label">
                <span>Absent</span>
                <span class="progress-value">{{ $totalClasses > 0 ? round(($absentCount / $totalClasses) * 100) : 0 }}%</span>
            </div>
            <div class="progress-track">
                <div class="progress-fill absent" style="width: {{ $totalClasses > 0 ? ($absentCount / $totalClasses) * 100 : 0 }}%"></div>
            </div>
        </div>
        <div class="progress-item">
            <div class="progress-label">
                <span>Late</span>
                <span class="progress-value">{{ $totalClasses > 0 ? round(($lateCount / $totalClasses) * 100) : 0 }}%</span>
            </div>
            <div class="progress-track">
                <div class="progress-fill late" style="width: {{ $totalClasses > 0 ? ($lateCount / $totalClasses) * 100 : 0 }}%"></div>
            </div>
        </div>
    </div>
</div>

<!-- Attendance Records Table -->
<div class="attendance-section">
    <h2><i class="fas fa-list"></i> Attendance History</h2>
    
    @if($attendanceRecords->count() > 0)
    <div class="table-container">
        <table class="attendance-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Course</th>
                    <th>Status</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendanceRecords as $record)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($record->date)->format('M d, Y (l)') }}</td>
                    <td>{{ $record->course->name ?? 'N/A' }}</td>
                    <td>
                        @if($record->status == 'present')
                            <span class="status-badge present">
                                <i class="fas fa-check"></i> Present
                            </span>
                        @elseif($record->status == 'absent')
                            <span class="status-badge absent">
                                <i class="fas fa-times"></i> Absent
                            </span>
                        @elseif($record->status == 'late')
                            <span class="status-badge late">
                                <i class="fas fa-clock"></i> Late
                            </span>
                        @else
                            <span class="status-badge">{{ ucfirst($record->status) }}</span>
                        @endif
                    </td>
                    <td>{{ $record->notes ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="pagination-wrapper">
        {{ $attendanceRecords->links() }}
    </div>
    @else
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fas fa-calendar-times"></i>
        </div>
        <h3>No Attendance Records</h3>
        <p>No attendance records found for this student.</p>
    </div>
    @endif
</div>

<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
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
        transition: all var(--transition-speed);
    }
    .btn-secondary {
        background-color: #6b7280;
        color: white;
    }
    .btn-secondary:hover {
        background-color: #4b5563;
        transform: translateY(-2px);
    }
    .attendance-overview {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    .overview-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: var(--card-shadow);
        transition: all var(--transition-speed);
    }
    .overview-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--card-shadow-hover);
    }
    .overview-card.percentage {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    }
    .overview-card.percentage .overview-icon,
    .overview-card.percentage h3,
    .overview-card.percentage .overview-value {
        color: white;
    }
    .overview-icon {
        width: 45px;
        height: 45px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        flex-shrink: 0;
    }
    .overview-card.total .overview-icon { background-color: #dbeafe; color: #2563eb; }
    .overview-card.present .overview-icon { background-color: #d1fae5; color: #059669; }
    .overview-card.absent .overview-icon { background-color: #fee2e2; color: #dc2626; }
    .overview-card.late .overview-icon { background-color: #fef3c7; color: #d97706; }
    .overview-info h3 {
        font-size: 0.85rem;
        color: #64748b;
        margin-bottom: 0.2rem;
    }
    .overview-card.percentage h3 {
        color: rgba(255,255,255,0.9);
    }
    .overview-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e293b;
    }
    .progress-section, .attendance-section {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: var(--card-shadow);
    }
    .progress-section h2, .attendance-section h2 {
        font-size: 1.3rem;
        color: #1e293b;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .progress-section h2 i, .attendance-section h2 i {
        color: var(--primary-color);
    }
    .progress-bars {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    .progress-item {
        width: 100%;
    }
    .progress-label {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }
    .progress-track {
        height: 12px;
        background: #e2e8f0;
        border-radius: 6px;
        overflow: hidden;
    }
    .progress-fill {
        height: 100%;
        border-radius: 6px;
        transition: width 0.3s;
    }
    .progress-fill.present { background-color: #10b981; }
    .progress-fill.absent { background-color: #ef4444; }
    .progress-fill.late { background-color: #f59e0b; }
    .table-container {
        overflow-x: auto;
    }
    .attendance-table {
        width: 100%;
        border-collapse: collapse;
    }
    .attendance-table th, .attendance-table td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid #e2e8f0;
    }
    .attendance-table th {
        background-color: #f8fafc;
        font-weight: 600;
        color: #64748b;
    }
    .attendance-table tr:hover {
        background-color: #f8fafc;
    }
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.85rem;
    }
    .status-badge.present {
        background-color: #d1fae5;
        color: #059669;
    }
    .status-badge.absent {
        background-color: #fee2e2;
        color: #dc2626;
    }
    .status-badge.late {
        background-color: #fef3c7;
        color: #d97706;
    }
    .pagination-wrapper {
        margin-top: 1.5rem;
        display: flex;
        justify-content: center;
    }
    .empty-state {
        text-align: center;
        padding: 3rem;
        background: #f8fafc;
        border-radius: 12px;
    }
    .empty-icon {
        font-size: 3rem;
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

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            gap: 1rem;
        }
        .attendance-overview {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .attendance-overview {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
