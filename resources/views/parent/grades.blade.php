@extends('layouts.parent.app')

@section('content')
<div class="page-header">
    <div class="header-title">
        <h1><i class="fas fa-chart-line"></i> Academic Grades</h1>
        <p>View grades and academic performance for {{ $student->user->name }}</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('parent.child.details', $student->id) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Details
        </a>
    </div>
</div>

<!-- Grade Overview Cards -->
<div class="grades-overview">
    <div class="overview-card main">
        <div class="overview-icon">
            <i class="fas fa-star"></i>
        </div>
        <div class="overview-info">
            <h3>Average Grade</h3>
            <p class="overview-value">{{ round($avgPercentage ?? 0, 1) }}%</p>
            <p class="overview-label">Overall Performance</p>
        </div>
    </div>

    <div class="overview-card">
        <div class="overview-icon excellent">
            <i class="fas fa-award"></i>
        </div>
        <div class="overview-info">
            <h3>Excellent</h3>
            @php $excellent = $grades->filter(function($g) { return $g->percentage >= 90; })->count(); @endphp
            <p class="overview-value">{{ $excellent }}</p>
            <p class="overview-label">90% and above</p>
        </div>
    </div>

    <div class="overview-card">
        <div class="overview-icon good">
            <i class="fas fa-thumbs-up"></i>
        </div>
        <div class="overview-info">
            <h3>Good</h3>
            @php $good = $grades->filter(function($g) { return $g->percentage >= 75 && $g->percentage < 90; })->count(); @endphp
            <p class="overview-value">{{ $good }}</p>
            <p class="overview-label">75% - 89%</p>
        </div>
    </div>

    <div class="overview-card">
        <div class="overview-icon average">
            <i class="fas fa-minus"></i>
        </div>
        <div class="overview-info">
            <h3>Average</h3>
            @php $average = $grades->filter(function($g) { return $g->percentage >= 60 && $g->percentage < 75; })->count(); @endphp
            <p class="overview-value">{{ $average }}</p>
            <p class="overview-label">60% - 74%</p>
        </div>
    </div>

    <div class="overview-card">
        <div class="overview-icon needs-improvement">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="overview-info">
            <h3>Needs Improvement</h3>
            @php $needsWork = $grades->filter(function($g) { return $g->percentage < 60; })->count(); @endphp
            <p class="overview-value">{{ $needsWork }}</p>
            <p class="overview-label">Below 60%</p>
        </div>
    </div>
</div>

<!-- Grade Distribution Chart -->
<div class="chart-section">
    <h2><i class="fas fa-chart-bar"></i> Grade Distribution</h2>
    <div class="distribution-chart">
        <div class="chart-bar">
            <div class="bar-label">Excellent (90%+)</div>
            <div class="bar-container">
                <div class="bar-fill excellent" style="width: {{ $grades->count() > 0 ? ($excellent / $grades->count()) * 100 : 0 }}%"></div>
            </div>
            <div class="bar-value">{{ $excellent }}</div>
        </div>
        <div class="chart-bar">
            <div class="bar-label">Good (75-89%)</div>
            <div class="bar-container">
                <div class="bar-fill good" style="width: {{ $grades->count() > 0 ? ($good / $grades->count()) * 100 : 0 }}%"></div>
            </div>
            <div class="bar-value">{{ $good }}</div>
        </div>
        <div class="chart-bar">
            <div class="bar-label">Average (60-74%)</div>
            <div class="bar-container">
                <div class="bar-fill average" style="width: {{ $grades->count() > 0 ? ($average / $grades->count()) * 100 : 0 }}%"></div>
            </div>
            <div class="bar-value">{{ $average }}</div>
        </div>
        <div class="chart-bar">
            <div class="bar-label">Below 60%</div>
            <div class="bar-container">
                <div class="bar-fill needs-work" style="width: {{ $grades->count() > 0 ? ($needsWork / $grades->count()) * 100 : 0 }}%"></div>
            </div>
            <div class="bar-value">{{ $needsWork }}</div>
        </div>
    </div>
</div>

<!-- Grades Table -->
<div class="grades-section">
    <h2><i class="fas fa-list"></i> All Grades</h2>
    
    @if($grades->count() > 0)
    <div class="table-container">
        <table class="grades-table">
            <thead>
                <tr>
                    <th>Course</th>
                    <th>Type</th>
                    <th>Title</th>
                    <th>Score</th>
                    <th>Percentage</th>
                    <th>Grade</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($grades as $grade)
                <tr>
                    <td>
                        <div class="course-name">
                            <i class="fas fa-book"></i>
                            {{ $grade->course->name ?? 'N/A' }}
                        </div>
                    </td>
                    <td>
                        @if($grade->assignment)
                            <span class="type-badge assignment">
                                <i class="fas fa-tasks"></i> Assignment
                            </span>
                        @elseif($grade->exam)
                            <span class="type-badge exam">
                                <i class="fas fa-clipboard-list"></i> Exam
                            </span>
                        @else
                            <span class="type-badge">
                                <i class="fas fa-star"></i> Other
                            </span>
                        @endif
                    </td>
                    <td>{{ $grade->assignment->title ?? ($grade->exam->title ?? 'N/A') }}</td>
                    <td>
                        <span class="score">{{ $grade->score }}</span>
                        <span class="total">/ {{ $grade->total_score }}</span>
                    </td>
                    <td>
                        <div class="percentage-cell">
                            <span class="percentage-value {{ $grade->percentage >= 60 ? 'pass' : 'fail' }}">
                                {{ round($grade->percentage, 1) }}%
                            </span>
                        </div>
                    </td>
                    <td>
                        <span class="grade-badge {{ $grade->percentage >= 60 ? 'pass' : 'fail' }}">
                            {{ $grade->letter_grade ?? 'N/A' }}
                        </span>
                    </td>
                    <td>{{ $grade->created_at->format('M d, Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="pagination-wrapper">
        {{ $grades->links() }}
    </div>
    @else
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fas fa-chart-line"></i>
        </div>
        <h3>No Grades Available</h3>
        <p>No grades have been recorded yet for this student.</p>
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
    .grades-overview {
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
    .overview-card.main {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    }
    .overview-card.main .overview-icon,
    .overview-card.main h3,
    .overview-card.main .overview-value,
    .overview-card.main .overview-label {
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
    .overview-icon.excellent { background-color: #d1fae5; color: #059669; }
    .overview-icon.good { background-color: #dbeafe; color: #2563eb; }
    .overview-icon.average { background-color: #fef3c7; color: #d97706; }
    .overview-icon.needs-improvement { background-color: #fee2e2; color: #dc2626; }
    .overview-info h3 {
        font-size: 0.85rem;
        color: #64748b;
        margin-bottom: 0.2rem;
    }
    .overview-card.main h3 {
        color: rgba(255,255,255,0.9);
    }
    .overview-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e293b;
    }
    .overview-label {
        font-size: 0.75rem;
        color: #9ca3af;
    }
    .overview-card.main .overview-label {
        color: rgba(255,255,255,0.8);
    }
    .chart-section, .grades-section {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: var(--card-shadow);
    }
    .chart-section h2, .grades-section h2 {
        font-size: 1.3rem;
        color: #1e293b;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .chart-section h2 i, .grades-section h2 i {
        color: var(--primary-color);
    }
    .distribution-chart {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    .chart-bar {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .bar-label {
        width: 150px;
        font-weight: 600;
        color: #64748b;
        font-size: 0.9rem;
    }
    .bar-container {
        flex: 1;
        height: 24px;
        background: #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
    }
    .bar-fill {
        height: 100%;
        border-radius: 12px;
        transition: width 0.3s;
    }
    .bar-fill.excellent { background: linear-gradient(90deg, #10b981, #059669); }
    .bar-fill.good { background: linear-gradient(90deg, #3b82f6, #2563eb); }
    .bar-fill.average { background: linear-gradient(90deg, #f59e0b, #d97706); }
    .bar-fill.needs-work { background: linear-gradient(90deg, #ef4444, #dc2626); }
    .bar-value {
        width: 40px;
        font-weight: 700;
        color: #1e293b;
    }
    .table-container {
        overflow-x: auto;
    }
    .grades-table {
        width: 100%;
        border-collapse: collapse;
    }
    .grades-table th, .grades-table td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid #e2e8f0;
    }
    .grades-table th {
        background-color: #f8fafc;
        font-weight: 600;
        color: #64748b;
    }
    .grades-table tr:hover {
        background-color: #f8fafc;
    }
    .course-name {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
    }
    .type-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.3rem 0.6rem;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    .type-badge.assignment { background: #dbeafe; color: #2563eb; }
    .type-badge.exam { background: #ede9fe; color: #7c3aed; }
    .type-badge { background: #e2e8f0; color: #475569; }
    .score {
        font-weight: 700;
        color: #1e293b;
    }
    .total {
        color: #9ca3af;
    }
    .percentage-cell {
        font-weight: 600;
    }
    .percentage-value.pass { color: #10b981; }
    .percentage-value.fail { color: #ef4444; }
    .grade-badge {
        display: inline-block;
        padding: 0.3rem 0.6rem;
        border-radius: 4px;
        font-weight: 700;
        font-size: 0.9rem;
    }
    .grade-badge.pass {
        background-color: #d1fae5;
        color: #059669;
    }
    .grade-badge.fail {
        background-color: #fee2e2;
        color: #dc2626;
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
        .grades-overview {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .grades-overview {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
