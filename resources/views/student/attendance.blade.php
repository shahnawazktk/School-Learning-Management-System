@extends('layouts.student.app')

@section('content')
    <div class="container-fluid">
        <!-- Attendance Statistics -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="avatar mx-auto mb-3"
                            style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-calendar-check fa-2x text-white"></i>
                        </div>
                        <h4 class="mb-1">{{ $attendancePercentage }}%</h4>
                        <p class="text-muted mb-0">Overall Attendance</p>
                        <small class="text-success">
                            <i class="fas fa-arrow-up"></i> Good standing
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="avatar mx-auto mb-3"
                            style="width: 60px; height: 60px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-user-check fa-2x text-white"></i>
                        </div>
                        <h4 class="mb-1">{{ $attendanceRecords->where('status', 'present')->count() }}</h4>
                        <p class="text-muted mb-0">Days Present</p>
                        <small class="text-muted">This period</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="avatar mx-auto mb-3"
                            style="width: 60px; height: 60px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-user-times fa-2x text-white"></i>
                        </div>
                        <h4 class="mb-1">{{ $attendanceRecords->where('status', 'absent')->count() }}</h4>
                        <p class="text-muted mb-0">Days Absent</p>
                        <small class="text-muted">This period</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="avatar mx-auto mb-3"
                            style="width: 60px; height: 60px; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-clock fa-2x text-white"></i>
                        </div>
                        <h4 class="mb-1">{{ $attendanceRecords->where('status', 'late')->count() }}</h4>
                        <p class="text-muted mb-0">Days Late</p>
                        <small class="text-muted">This period</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Chart -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-line text-primary"></i> Monthly Attendance Trend
                        </h5>
                    </div>
                    <div class="card-body">
                        <canvas id="attendanceChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Records Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-table text-primary"></i> Attendance Records
                        </h5>
                        <div class="card-tools">
                            <select class="form-select form-select-sm" id="periodFilter">
                                <option value="all">All Time</option>
                                <option value="month" selected>This Month</option>
                                <option value="semester">This Semester</option>
                                <option value="year">This Year</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($attendanceRecords->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Date</th>
                                            <th>Day</th>
                                            <th>Status</th>
                                            <th>Subject</th>
                                            <th>Time In</th>
                                            <th>Time Out</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($attendanceRecords as $record)
                                            <tr>
                                                <td>{{ $record->date->format('M d, Y') }}</td>
                                                <td>{{ $record->date->format('l') }}</td>
                                                <td>
                                                    <span
                                                        class="badge badge-{{ $record->status === 'present'
                                                            ? 'success'
                                                            : ($record->status === 'absent'
                                                                ? 'danger'
                                                                : ($record->status === 'late'
                                                                    ? 'warning'
                                                                    : 'secondary')) }}">
                                                        {{ ucfirst($record->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $record->course->name ?? 'N/A' }}</td>
                                                <td>{{ $record->time_in ? $record->time_in->format('H:i') : '-' }}</td>
                                                <td>{{ $record->time_out ? $record->time_out->format('H:i') : '-' }}</td>
                                                <td>
                                                    <small class="text-muted">{{ $record->remarks ?? '-' }}</small>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-calendar-check fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No Attendance Records</h5>
                                <p class="text-muted">Your attendance records will appear here once classes begin.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .avatar {
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .table th {
                border-top: none;
                font-weight: 600;
                color: #495057;
            }

            .table-hover tbody tr:hover {
                background-color: #f8f9fa;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            $(document).ready(function() {
                // Initialize attendance chart
                const ctx = document.getElementById('attendanceChart').getContext('2d');
                const attendanceChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json(array_keys($monthlyAttendance)),
                        datasets: [{
                            label: 'Attendance %',
                            data: @json(array_values($monthlyAttendance)),
                            borderColor: '#667eea',
                            backgroundColor: 'rgba(102, 126, 234, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#667eea',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 6,
                            pointHoverRadius: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100,
                                ticks: {
                                    callback: function(value) {
                                        return value + '%';
                                    }
                                },
                                grid: {
                                    color: 'rgba(0,0,0,0.05)'
                                }
                            },
                            x: {
                                grid: {
                                    color: 'rgba(0,0,0,0.05)'
                                }
                            }
                        },
                        elements: {
                            point: {
                                hoverBorderWidth: 3
                            }
                        }
                    }
                });

                // Period filter
                $('#periodFilter').on('change', function() {
                    const period = $(this).val();
                    // In a real application, you would make an AJAX call to filter the data
                    // For now, we'll just show a notification
                    toastr.info(`Filtering by ${period} - This feature would filter the attendance records.`);
                });
            });
        </script>
    @endpush
@endsection
