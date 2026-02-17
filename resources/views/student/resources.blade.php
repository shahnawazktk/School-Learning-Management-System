@extends('layouts.student.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container-fluid p-4">
    @php
        $videoResources = $resources->where('type', 'video')->values();
        $nonVideoResources = $resources->where('type', '!=', 'video')->values();
        $totalResources = $resources->count();
        $courseVideos = $videoResources->groupBy('course_id');
    @endphp

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
                <div>
                    <h4 class="mb-1 fw-bold">Learning Resources</h4>
                    <p class="text-muted mb-0">Recorded lectures aur study materials ek jagah par available hain.</p>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <span class="badge text-bg-primary px-3 py-2">Total: {{ $totalResources }}</span>
                    <span class="badge text-bg-success px-3 py-2">Videos: {{ $videoResources->count() }}</span>
                    <span class="badge text-bg-secondary px-3 py-2">Materials: {{ $nonVideoResources->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="mb-1 fw-semibold"><i class="fas fa-play-circle text-primary me-2"></i>Recorded Video Lectures</h5>
            <p class="text-muted mb-0 small">Class recordings ko direct browser mein watch karein.</p>
        </div>
        <div class="card-body px-4 pb-4">
            <div class="row g-3">
                @forelse($videoResources as $resource)
                    <div class="col-12 col-md-6 col-xl-4">
                        <div class="card h-100 border-0 bg-light">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <span class="badge rounded-pill text-bg-primary me-2">Video</span>
                                    <small class="text-muted">{{ $resource->course->title ?? 'N/A' }}</small>
                                </div>
                                <h6 class="fw-semibold mb-2">{{ $resource->title }}</h6>
                                <p class="text-muted small mb-3">{{ $resource->description ?: 'Recorded lecture available for this course.' }}</p>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('student.resources.stream', $resource->id) }}" class="btn btn-primary btn-sm" target="_blank" rel="noopener">
                                        <i class="fas fa-play me-1"></i>Watch Now
                                    </a>
                                    <a href="{{ route('student.resources.download', $resource->id) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-download me-1"></i>Download
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-4">
                            <i class="fas fa-video-slash fa-2x text-muted mb-3"></i>
                            <p class="text-muted mb-0">Abhi koi recorded lecture available nahi hai.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="mb-1 fw-semibold"><i class="fas fa-folder-open text-success me-2"></i>Study Materials</h5>
            <p class="text-muted mb-0 small">Notes, PDFs, aur dusre downloadable resources.</p>
        </div>
        <div class="card-body px-4 pb-4">
            <div class="row g-3">
                @forelse($nonVideoResources as $resource)
                    @php
                        $relatedVideo = ($courseVideos[$resource->course_id] ?? collect())->first();
                        $videoUrl = null;
                        $isExternalVideo = false;

                        if ($relatedVideo) {
                            $isExternalVideo = filter_var($relatedVideo->file_path, FILTER_VALIDATE_URL) !== false;
                            $videoUrl = $isExternalVideo
                                ? $relatedVideo->file_path
                                : route('student.resources.stream', $relatedVideo->id);
                        }
                    @endphp
                    <div class="col-12 col-lg-6">
                        <div class="card h-100 border">
                            <div class="card-body">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="bg-light rounded p-3">
                                        @if($resource->type == 'document')
                                            <i class="fas fa-file-pdf fa-lg text-danger"></i>
                                        @elseif($resource->type == 'lecture_notes')
                                            <i class="fas fa-file-alt fa-lg text-success"></i>
                                        @elseif($resource->type == 'link')
                                            <i class="fas fa-link fa-lg text-info"></i>
                                        @else
                                            <i class="fas fa-file fa-lg text-secondary"></i>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 fw-semibold">{{ $resource->title }}</h6>
                                        <p class="text-muted small mb-2">{{ $resource->description ?: 'Course resource' }}</p>
                                        <div class="d-flex flex-wrap gap-2 mb-3">
                                            <span class="badge text-bg-light border">{{ $resource->course->title ?? 'N/A' }}</span>
                                            <span class="badge text-bg-light border">{{ ucfirst(str_replace('_', ' ', $resource->type)) }}</span>
                                        </div>
                                        @if($resource->type === 'link' && filter_var($resource->file_path, FILTER_VALIDATE_URL))
                                            <a href="{{ $resource->file_path }}" target="_blank" rel="noopener" class="btn btn-outline-info btn-sm">
                                                <i class="fas fa-external-link-alt me-1"></i>Open Link
                                            </a>
                                        @else
                                            <a href="{{ route('student.resources.download', $resource->id) }}" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-download me-1"></i>Download
                                            </a>
                                        @endif
                                        @if($resource->type === 'lecture_notes')
                                            @if($videoUrl)
                                                <button type="button"
                                                    class="btn btn-outline-success btn-sm ms-2 open-lecture-video"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#lectureVideoModal"
                                                    data-title="{{ $relatedVideo->title }}"
                                                    data-url="{{ $videoUrl }}"
                                                    data-external="{{ $isExternalVideo ? '1' : '0' }}">
                                                    <i class="fas fa-play-circle me-1"></i>Lecture Video
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-outline-secondary btn-sm ms-2" disabled>
                                                    <i class="fas fa-video-slash me-1"></i>No Video
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-4">
                            <i class="fas fa-folder-open fa-2x text-muted mb-3"></i>
                            <p class="text-muted mb-0">No study materials available</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="lectureVideoModal" tabindex="-1" aria-labelledby="lectureVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title" id="lectureVideoModalLabel">Lecture Video</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="ratio ratio-16x9 bg-dark" id="lectureVideoContainer"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalEl = document.getElementById('lectureVideoModal');
        const videoContainer = document.getElementById('lectureVideoContainer');
        const modalTitle = document.getElementById('lectureVideoModalLabel');

        function toEmbedUrl(url) {
            if (!url) return url;
            if (url.includes('youtube.com/watch?v=')) {
                return url.replace('watch?v=', 'embed/');
            }
            if (url.includes('youtu.be/')) {
                const videoId = url.split('youtu.be/')[1].split('?')[0];
                return 'https://www.youtube.com/embed/' + videoId;
            }
            if (url.includes('vimeo.com/') && !url.includes('player.vimeo.com/video/')) {
                const videoId = url.split('vimeo.com/')[1].split('?')[0];
                return 'https://player.vimeo.com/video/' + videoId;
            }
            return url;
        }

        document.querySelectorAll('.open-lecture-video').forEach(function (button) {
            button.addEventListener('click', function () {
                const title = this.getAttribute('data-title') || 'Lecture Video';
                const url = this.getAttribute('data-url');
                const isExternal = this.getAttribute('data-external') === '1';
                modalTitle.textContent = title;

                if (!url) {
                    videoContainer.innerHTML = '<div class="text-white d-flex align-items-center justify-content-center w-100">Video source not found.</div>';
                    return;
                }

                if (isExternal) {
                    const embedUrl = toEmbedUrl(url);
                    videoContainer.innerHTML = '<iframe src="' + embedUrl + '" title="Lecture Video" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>';
                } else {
                    videoContainer.innerHTML = '<video controls autoplay class="w-100 h-100"><source src="' + url + '">Your browser does not support the video tag.</video>';
                }
            });
        });

        modalEl.addEventListener('hidden.bs.modal', function () {
            videoContainer.innerHTML = '';
        });
    });
</script>
@endsection
