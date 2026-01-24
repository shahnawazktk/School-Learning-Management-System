@extends('layouts.student.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-file-alt text-primary"></i> Study Resources
                        </h4>
                        <div class="card-tools">
                            <select class="form-select form-select-sm" id="subjectFilter">
                                <option value="all">All Subjects</option>
                                @foreach ($enrollments ?? [] as $enrollment)
                                    <option value="{{ $enrollment->course_id ?? $enrollment->subject_id }}">
                                        {{ $enrollment->course->name ?? $enrollment->subject->name }}
                                    </option>
                                @endforeach
                            </select>
                            <select class="form-select form-select-sm" id="typeFilter">
                                <option value="all">All Types</option>
                                <option value="document">Documents</option>
                                <option value="video">Videos</option>
                                <option value="presentation">Presentations</option>
                                <option value="audio">Audio</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($resources->count() > 0)
                            <div class="row" id="resourcesContainer">
                                @foreach ($resources as $resource)
                                    <div class="col-lg-4 col-md-6 mb-4 resource-card"
                                        data-subject="{{ $resource->course_id }}" data-type="{{ $resource->type }}">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <div class="d-flex align-items-start mb-3">
                                                    <div class="resource-icon mr-3">
                                                        @if ($resource->type === 'video')
                                                            <i class="fas fa-play-circle text-danger"></i>
                                                        @elseif($resource->type === 'document')
                                                            <i class="fas fa-file-pdf text-danger"></i>
                                                        @elseif($resource->type === 'presentation')
                                                            <i class="fas fa-file-powerpoint text-warning"></i>
                                                        @elseif($resource->type === 'audio')
                                                            <i class="fas fa-volume-up text-info"></i>
                                                        @else
                                                            <i class="fas fa-file text-secondary"></i>
                                                        @endif
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="card-title mb-1">{{ $resource->title }}</h6>
                                                        <small
                                                            class="text-muted">{{ $resource->course->name ?? 'N/A' }}</small>
                                                    </div>
                                                </div>

                                                <p class="text-muted small mb-3">
                                                    {{ Str::limit($resource->description, 100) }}</p>

                                                <div class="resource-meta mb-3">
                                                    <div class="row text-center">
                                                        <div class="col-6">
                                                            <small class="text-muted d-block">Type</small>
                                                            <span
                                                                class="badge badge-outline">{{ ucfirst($resource->type) }}</span>
                                                        </div>
                                                        <div class="col-6">
                                                            <small class="text-muted d-block">Size</small>
                                                            <span
                                                                class="text-muted">{{ $resource->file_size ?? 'N/A' }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="resource-actions">
                                                    @if ($resource->type === 'video')
                                                        <button
                                                            class="btn btn-outline-primary btn-sm btn-block play-resource"
                                                            data-id="{{ $resource->id }}">
                                                            <i class="fas fa-play"></i> Watch Video
                                                        </button>
                                                    @else
                                                        <a href="{{ route('student.resources.download', $resource->id) }}"
                                                            class="btn btn-outline-success btn-sm btn-block"
                                                            target="_blank">
                                                            <i class="fas fa-download"></i> Download
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No Resources Available</h5>
                                <p class="text-muted">Study resources will be uploaded by your teachers and appear here.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Video Modal -->
    <div class="modal fade" id="videoModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-play-circle text-primary"></i> <span id="videoTitle"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="embed-responsive embed-responsive-16by9">
                        <video id="resourceVideo" class="embed-responsive-item" controls>
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .resource-icon {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                background-color: #f8f9fa;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.2rem;
            }

            .resource-actions .btn {
                width: 100%;
            }

            .badge-outline {
                background-color: transparent;
                color: #6c757d;
                border: 1px solid #6c757d;
            }

            .embed-responsive {
                position: relative;
                display: block;
                width: 100%;
                padding: 0;
                overflow: hidden;
            }

            .embed-responsive-item {
                position: absolute;
                top: 0;
                left: 0;
                bottom: 0;
                height: 100%;
                width: 100%;
                border: 0;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Filter functionality
                $('#subjectFilter, #typeFilter').on('change', function() {
                    const subjectFilter = $('#subjectFilter').val();
                    const typeFilter = $('#typeFilter').val();
                    const cards = $('.resource-card');

                    cards.each(function() {
                        const card = $(this);
                        const subjectMatch = subjectFilter === 'all' || card.data('subject') ==
                            subjectFilter;
                        const typeMatch = typeFilter === 'all' || card.data('type') === typeFilter;

                        if (subjectMatch && typeMatch) {
                            card.show();
                        } else {
                            card.hide();
                        }
                    });
                });

                // Play video functionality
                $('.play-resource').on('click', function() {
                    const resourceId = $(this).data('id');

                    // In a real application, you would fetch the video URL via AJAX
                    // For now, we'll show a placeholder
                    $('#videoTitle').text('Resource Video');
                    $('#resourceVideo').attr('src', ''); // Set actual video URL here
                    $('#videoModal').modal('show');
                });

                // Close video modal
                $('#videoModal').on('hidden.bs.modal', function() {
                    $('#resourceVideo').get(0).pause();
                    $('#resourceVideo').attr('src', '');
                });
            });
        </script>
    @endpush
@endsection
