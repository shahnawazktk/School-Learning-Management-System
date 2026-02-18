@extends('layouts.admin.app')
@section('page_title', 'Dashboard')

@section('content')
<style>
    .admin-dashboard .hero-card {
        border-radius: 18px;
        background: linear-gradient(120deg, #0b3a8f 0%, #2563eb 56%, #0ea5e9 100%);
        color: #fff;
    }
    .admin-dashboard .hero-metric {
        border: 1px solid rgba(255, 255, 255, 0.2);
        background: rgba(255, 255, 255, 0.16);
        border-radius: 12px;
        padding: .85rem;
        text-align: center;
    }
    .admin-dashboard .kpi-card {
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
        height: 100%;
    }
    .admin-dashboard .kpi-icon {
        width: 42px;
        height: 42px;
        border-radius: 11px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .admin-dashboard .section-card {
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
        overflow: hidden;
    }
    .admin-dashboard .section-card .card-header {
        background: #fff;
        border-bottom: 1px solid #e2e8f0;
    }
    .admin-dashboard .activity-item:last-child {
        border-bottom: 0 !important;
    }
</style>

<div class="container-fluid p-1 p-lg-2 admin-dashboard">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card hero-card border-0 shadow-sm">
                <div class="card-body p-4 p-lg-5">
                    <div class="d-flex flex-column flex-xl-row justify-content-between gap-4">
                        <div>
                            <h2 class="fw-bold mb-2">Welcome back, {{ auth()->user()->name }}</h2>
                            <p class="mb-2 opacity-75">School operations control center with live academic and people metrics.</p>
                            <small class="opacity-75">{{ now()->format('l, d M Y') }} | Attendance Rate {{ number_format($attendanceRate, 1) }}%</small>
                            <div class="d-flex gap-2 flex-wrap mt-3">
                                <a href="{{ route('admin.profile') }}" class="btn btn-light btn-sm fw-semibold"><i class="fas fa-school me-1"></i>School Profile</a>
                                <a href="{{ route('admin.users') }}" class="btn btn-outline-light btn-sm fw-semibold"><i class="fas fa-users me-1"></i>User Access</a>
                                <a href="{{ route('admin.settings') }}" class="btn btn-outline-light btn-sm fw-semibold"><i class="fas fa-sliders me-1"></i>System Settings</a>
                            </div>
                        </div>
                        <div class="row g-2" style="min-width: 280px; max-width: 420px;">
                            <div class="col-4">
                                <div class="hero-metric">
                                    <div class="h5 fw-bold mb-0">{{ $courseCount }}</div>
                                    <small>Courses</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="hero-metric">
                                    <div class="h5 fw-bold mb-0">{{ $enrollmentCount }}</div>
                                    <small>Enrollments</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="hero-metric">
                                    <div class="h5 fw-bold mb-0">{{ $upcomingExams }}</div>
                                    <small>Exams</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="hero-metric">
                                    <div class="h5 fw-bold mb-0">{{ $pendingSubmissions }}</div>
                                    <small>Pending Grading</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="hero-metric">
                                    <div class="h5 fw-bold mb-0">{{ $assignmentCount }}</div>
                                    <small>Assignments</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4" id="people-overview">
        <div class="col-md-6 col-xl-3">
            <div class="card kpi-card">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <small class="text-muted d-block mb-1">Total Teachers</small>
                        <h4 class="mb-1 fw-bold">{{ $teacherCount }}</h4>
                        <small class="text-success"><i class="fas fa-arrow-up me-1"></i>{{ $newTeachersThisMonth }} new this month</small>
                    </div>
                    <span class="kpi-icon bg-primary-subtle text-primary"><i class="fas fa-chalkboard-teacher"></i></span>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card kpi-card">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <small class="text-muted d-block mb-1">Total Students</small>
                        <h4 class="mb-1 fw-bold">{{ $studentCount }}</h4>
                        <small class="text-success"><i class="fas fa-arrow-up me-1"></i>{{ $newStudentsThisMonth }} new this month</small>
                    </div>
                    <span class="kpi-icon bg-success-subtle text-success"><i class="fas fa-user-graduate"></i></span>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card kpi-card">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <small class="text-muted d-block mb-1">Classes & Sections</small>
                        <h4 class="mb-1 fw-bold">{{ $classCount }}</h4>
                        <small class="text-muted"><i class="fas fa-layer-group me-1"></i>{{ $courseCount }} active courses</small>
                    </div>
                    <span class="kpi-icon bg-warning-subtle text-warning"><i class="fas fa-school"></i></span>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card kpi-card">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <small class="text-muted d-block mb-1">Subjects</small>
                        <h4 class="mb-1 fw-bold">{{ $subjectCount }}</h4>
                        <small class="text-success"><i class="fas fa-arrow-up me-1"></i>{{ $newSubjectsThisMonth }} new this month</small>
                    </div>
                    <span class="kpi-icon bg-info-subtle text-info"><i class="fas fa-book-open"></i></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4" id="academic-overview">
        <div class="col-lg-7">
            <div class="card section-card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-bolt me-2 text-primary"></i>Administrative Actions</h5>
                    <span class="badge text-bg-light">Core Operations</span>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 h-100">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge text-bg-primary"><i class="fas fa-school"></i></span>
                                    <h6 class="mb-0 fw-semibold">School Profile</h6>
                                </div>
                                <p class="text-muted mb-3 small">Manage school identity, contact details, and official configuration.</p>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.profile') }}" class="btn btn-primary btn-sm">Manage</a>
                                    <a href="{{ route('admin.settings') }}" class="btn btn-outline-secondary btn-sm">Settings</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 h-100">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge text-bg-success"><i class="fas fa-users"></i></span>
                                    <h6 class="mb-0 fw-semibold">User Access</h6>
                                </div>
                                <p class="text-muted mb-3 small">Control admin, teacher, student and parent accounts and security.</p>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.users') }}" class="btn btn-success btn-sm">Open Users</a>
                                    <a href="{{ route('admin.settings') }}" class="btn btn-outline-secondary btn-sm">Controls</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="border rounded-3 p-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                                <div>
                                    <h6 class="fw-semibold mb-1"><i class="fas fa-graduation-cap me-1 text-warning"></i>Academic Workload</h6>
                                    <small class="text-muted">Assignments: {{ $assignmentCount }} | Pending Grading: {{ $pendingSubmissions }} | Upcoming Exams: {{ $upcomingExams }}</small>
                                </div>
                                <a href="{{ route('admin.dashboard') }}#attendance-overview" class="btn btn-outline-primary btn-sm">View Trends</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card section-card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-history me-2 text-info"></i>Recent Activity</h5>
                    <span class="badge text-bg-light">{{ $recentActivity->count() }} items</span>
                </div>
                <div class="card-body">
                    @forelse($recentActivity as $activity)
                        <div class="activity-item d-flex align-items-start gap-3 py-2 border-bottom">
                            <span class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center flex-shrink-0" style="width:38px;height:38px;">
                                <i class="fas {{ $activity['icon'] }} text-primary"></i>
                            </span>
                            <div class="flex-grow-1">
                                <div class="fw-semibold">{{ $activity['title'] }}</div>
                                <small class="text-muted d-block">{{ $activity['description'] }}</small>
                            </div>
                            <small class="text-muted text-nowrap">{{ $activity['time']->diffForHumans() }}</small>
                        </div>
                    @empty
                        <div class="text-muted">No recent activity yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3" id="attendance-overview">
        <div class="col-xl-8">
            <div class="card section-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-chart-column me-2 text-primary"></i>Monthly Attendance Overview ({{ now()->year }})</h5>
                    <div class="btn-group btn-group-sm" role="group" aria-label="Chart Type">
                        <button type="button" class="btn btn-outline-secondary active" id="attendanceBarBtn">Bar</button>
                        <button type="button" class="btn btn-outline-secondary" id="attendanceLineBtn">Line</button>
                    </div>
                </div>
                <div class="card-body">
                    <div style="height: 330px;">
                        <canvas id="attendanceChart" data-labels='@json($monthlyAttendanceLabels)' data-values='@json($monthlyAttendanceData)'></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card section-card h-100">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-circle-info me-2 text-success"></i>Operational Snapshot</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Attendance Rate</span>
                        <span class="fw-semibold">{{ number_format($attendanceRate, 1) }}%</span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Active Courses</span>
                        <span class="fw-semibold">{{ $courseCount }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Total Enrollments</span>
                        <span class="fw-semibold">{{ $enrollmentCount }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Pending Grading</span>
                        <span class="fw-semibold text-danger">{{ $pendingSubmissions }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span class="text-muted">Upcoming Exams</span>
                        <span class="fw-semibold">{{ $upcomingExams }}</span>
                    </div>
                    <hr>
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.users') }}" class="btn btn-primary btn-sm"><i class="fas fa-users me-1"></i>Manage Users</a>
                        <a href="{{ route('admin.settings') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-sliders me-1"></i>System Settings</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (() => {
        const chartElement = document.getElementById('attendanceChart');
        if (!chartElement || typeof Chart === 'undefined') return;

        const labels = chartElement.dataset.labels ? JSON.parse(chartElement.dataset.labels) : [];
        const values = chartElement.dataset.values ? JSON.parse(chartElement.dataset.values) : [];
        const barBtn = document.getElementById('attendanceBarBtn');
        const lineBtn = document.getElementById('attendanceLineBtn');

        let chartType = 'bar';
        const ctx = chartElement.getContext('2d');
        let chart;

        const renderChart = () => {
            if (chart) chart.destroy();
            chart = new Chart(ctx, {
                type: chartType,
                data: {
                    labels,
                    datasets: [{
                        label: 'Attendance Rate (%)',
                        data: values,
                        borderWidth: 2,
                        borderColor: '#2563eb',
                        backgroundColor: chartType === 'bar' ? 'rgba(37, 99, 235, 0.7)' : 'rgba(14, 165, 233, 0.2)',
                        tension: 0.35,
                        fill: chartType === 'line'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: true }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            ticks: {
                                callback: (value) => value + '%'
                            }
                        }
                    }
                }
            });
        };

        const setActive = () => {
            if (!barBtn || !lineBtn) return;
            barBtn.classList.toggle('active', chartType === 'bar');
            lineBtn.classList.toggle('active', chartType === 'line');
        };

        if (barBtn) {
            barBtn.addEventListener('click', () => {
                chartType = 'bar';
                setActive();
                renderChart();
            });
        }

        if (lineBtn) {
            lineBtn.addEventListener('click', () => {
                chartType = 'line';
                setActive();
                renderChart();
            });
        }

        setActive();
        renderChart();
    })();
</script>
@endsection
