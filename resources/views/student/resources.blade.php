@extends('layouts.student.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    :root {
        --primary: #4f46e5;
        --secondary: #0ea5e9;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --dark: #0f172a;
        --bg: #f8fafc;
        --card-bg: #ffffff;
    }

    body {
        font-family: 'Inter', sans-serif;
        background-color: var(--bg);
        color: #334155;
    }

    .resources-container {
        max-width: 1440px;
        margin: 0 auto;
        padding-bottom: 3rem;
    }

    /* Hero Section */
    .resources-hero {
        background: linear-gradient(135deg, #1e1b4b 0%, var(--primary) 100%);
        border-radius: 1.5rem;
        padding: 3rem;
        color: white;
        position: relative;
        overflow: hidden;
        margin-bottom: 2rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    .resources-hero::before {
        content: ''; position: absolute; top: -50%; left: -10%;
        width: 400px; height: 400px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
    }
    .resources-hero::after {
        content: ''; position: absolute; bottom: -30%; right: -5%;
        width: 300px; height: 300px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    .stat-pill {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 2rem;
        padding: 0.5rem 1.25rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }

    /* Tabs Styling */
    .nav-pills.custom-pills .nav-link {
        color: #64748b;
        font-weight: 600;
        border-radius: 1rem;
        padding: 0.75rem 1.5rem;
        transition: all 0.3s;
        border: 1px solid transparent;
        background: white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    .nav-pills.custom-pills .nav-link:hover {
        background: #f1f5f9;
        color: var(--dark);
    }
    .nav-pills.custom-pills .nav-link.active {
        background: var(--primary);
        color: white;
        box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
    }

    /* Resource Cards */
    .resource-card {
        background: var(--card-bg);
        border-radius: 1.25rem;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        height: 100%;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    .resource-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 20px -5px rgba(0,0,0,0.1);
        border-color: #cbd5e1;
    }
    
    .video-thumbnail-placeholder {
        height: 160px;
        background: repeating-linear-gradient(45deg, #f8fafc, #f8fafc 10px, #f1f5f9 10px, #f1f5f9 20px);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    .video-thumbnail-placeholder .play-btn {
        width: 50px; height: 50px;
        background: rgba(79, 70, 229, 0.9);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        color: white;
        font-size: 1.2rem;
        box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3);
        transition: transform 0.2s;
    }
    .resource-card:hover .play-btn { transform: scale(1.1); }

    .material-icon-box {
        width: 60px; height: 60px;
        border-radius: 1rem;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.75rem;
        flex-shrink: 0;
    }

    /* Notepad */
    .study-notepad {
        background: #fffbeb;
        border: 1px solid #fde68a;
        border-radius: 1.25rem;
        height: 100%;
        display: flex;
        flex-direction: column;
        box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.05);
    }
    .study-notepad-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px dashed #fcd34d;
        display: flex; justify-content: space-between; align-items: center;
        background: rgba(255,255,255,0.4);
        border-radius: 1.25rem 1.25rem 0 0;
    }
    .study-notepad-body {
        padding: 1.5rem;
        flex-grow: 1;
        outline: none;
        color: #78350f;
        font-size: 1rem;
        line-height: 1.6;
        min-height: 250px;
        background-image: linear-gradient(transparent 95%, #fde68a 95%);
        background-size: 100% 1.6rem;
        background-attachment: local;
    }
    .study-notepad-body[data-placeholder]:empty:before {
        content: attr(data-placeholder);
        color: #d97706;
        font-style: italic;
        pointer-events: none;
        display: block;
    }
    
    .course-badge {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 0.35rem 0.75rem;
        border-radius: 0.5rem;
    }

    /* Modal Styling */
    .modal-content.video-modal {
        background: #000;
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 1rem;
        overflow: hidden;
    }
    .modal-header.video-modal-header {
        border-bottom: 1px solid rgba(255,255,255,0.1);
        background: #111;
        color: white;
    }
    .btn-close-white { filter: invert(1) grayscale(100%) brightness(200%); }

</style>

<div class="container-fluid py-4 resources-container">
    @php
        $videoResources = $resources->where('type', 'video')->values();
        $nonVideoResources = $resources->where('type', '!=', 'video')->values();
        $totalResources = $resources->count();
        $courseVideos = $videoResources->groupBy('course_id');
    @endphp

    <!-- Hero Section -->
    <div class="resources-hero">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-7 mb-4 mb-lg-0">
                <span class="badge bg-white bg-opacity-25 text-white rounded-pill px-3 py-2 mb-3 fw-bold border border-white border-opacity-25 shadow-sm">
                    <i class="fas fa-book-reader me-2"></i> Study Center
                </span>
                <h1 class="display-5 fw-bold mb-3">Library & Resources</h1>
                <p class="fs-5 opacity-75 mb-0">Access all your recorded lectures, study notes, and supplementary materials in one organized place.</p>
            </div>
            <div class="col-lg-5 text-lg-end">
                <div class="d-flex flex-wrap gap-3 justify-content-lg-end">
                    <div class="stat-pill text-white">
                        <i class="fas fa-layer-group text-primary-light" style="color: #c7d2fe;"></i> 
                        <span>{{ $totalResources }} Total Files</span>
                    </div>
                    <div class="stat-pill text-white">
                        <i class="fas fa-video text-success-light" style="color: #6ee7b7;"></i> 
                        <span>{{ $videoResources->count() }} Lectures</span>
                    </div>
                    <div class="stat-pill text-white">
                        <i class="fas fa-file-pdf text-danger-light" style="color: #fca5a5;"></i> 
                        <span>{{ $nonVideoResources->count() }} Documents</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Layout -->
    <div class="row g-4 flex-xl-row-reverse" style="align-items: stretch;">
        
        <!-- Sidebar / Notepad Area -->
        <div class="col-xl-4 d-flex flex-column gap-4">
            
            <div class="study-notepad shadow-sm flex-grow-1" style="min-height: 400px; position: sticky; top: 2rem;">
                <div class="study-notepad-header">
                    <h5 class="fw-bold m-0 text-warning" style="text-shadow: 1px 1px 0px rgba(255,255,255,0.8);"><i class="fas fa-highlighter me-2"></i>My Private Notes</h5>
                    <span class="badge bg-white text-muted border border-warning px-2 py-1 shadow-sm"><i class="fas fa-cloud-arrow-up me-1"></i> Auto-saves</span>
                </div>
                <div class="study-notepad-body p-4" 
                     contenteditable="true" 
                     id="student_resources_notes_{{ Auth::id() }}"
                     data-placeholder="Take notes while watching a lecture or reading study materials. These notes are saved securely in your browser so you won't lose them when you leave the page. Click here to start typing..."></div>
            </div>
            
        </div>

        <!-- Main Content Area -->
        <div class="col-xl-8">
            
            <!-- Navigation Tabs -->
            <ul class="nav nav-pills custom-pills mb-4 gap-2" id="resourceTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active shadow-sm" id="videos-tab" data-bs-toggle="pill" data-bs-target="#videos" type="button" role="tab" aria-controls="videos" aria-selected="true">
                        <i class="fas fa-play-circle me-1"></i> Video Lectures
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link shadow-sm" id="materials-tab" data-bs-toggle="pill" data-bs-target="#materials" type="button" role="tab" aria-controls="materials" aria-selected="false">
                        <i class="fas fa-file-alt me-1"></i> Study Materials & Docs
                    </button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="resourceTabsContent">
                
                <!-- Video Lectures Tab -->
                <div class="tab-pane fade show active" id="videos" role="tabpanel" aria-labelledby="videos-tab">
                    <div class="row g-4">
                        @forelse($videoResources as $resource)
                            <div class="col-md-6">
                                <div class="resource-card h-100">
                                    <div class="video-thumbnail-placeholder">
                                        <a href="{{ route('student.resources.stream', $resource->id) }}" class="play-btn text-decoration-none" target="_blank" rel="noopener">
                                            <i class="fas fa-play" style="margin-left:4px;"></i>
                                        </a>
                                        <div class="position-absolute top-0 end-0 m-3">
                                            <span class="badge bg-dark bg-opacity-75 text-white backdrop-blur rounded-pill px-3 py-1 border border-light border-opacity-25 shadow-sm"><i class="fas fa-video me-1"></i> Video</span>
                                        </div>
                                    </div>
                                    <div class="card-body d-flex flex-column p-4">
                                        <div class="mb-3">
                                            <span class="course-badge"><i class="fas fa-graduation-cap text-primary me-1"></i> {{ $resource->course->title ?? 'General Course' }}</span>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-2">{{ $resource->title }}</h5>
                                        <p class="text-muted small mb-4 flex-grow-1">{{ $resource->description ?: 'Recorded lecture session.' }}</p>
                                        
                                        <div class="d-flex gap-2 mt-auto">
                                            <a href="{{ route('student.resources.stream', $resource->id) }}" class="btn btn-primary flex-grow-1 fw-bold text-decoration-none shadow-sm rounded-pill" target="_blank" rel="noopener">
                                                <i class="fas fa-play-circle me-1"></i> Watch Letcure
                                            </a>
                                            <a href="{{ route('student.resources.download', $resource->id) }}" class="btn btn-light border text-dark fw-bold px-3 shadow-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;" data-bs-toggle="tooltip" title="Download Offline">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="card border-0 shadow-sm rounded-4 text-center py-5 h-100 bg-white">
                                    <div class="d-inline-flex bg-light bg-opacity-50 text-muted p-4 rounded-circle mb-3 border shadow-sm">
                                        <i class="fas fa-video-slash fa-3x opacity-50"></i>
                                    </div>
                                    <h5 class="fw-bold text-dark">No Lectures Available</h5>
                                    <p class="text-muted mb-0">Recorded lectures will appear here once uploaded by instructors.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Study Materials Tab -->
                <div class="tab-pane fade" id="materials" role="tabpanel" aria-labelledby="materials-tab">
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
                                
                                // Dynamic styling based on type
                                $typeConfig = [
                                    'document' => ['icon' => 'fa-file-pdf', 'color' => 'danger'],
                                    'lecture_notes' => ['icon' => 'fa-file-signature', 'color' => 'success'],
                                    'link' => ['icon' => 'fa-link', 'color' => 'info']
                                ];
                                $config = $typeConfig[$resource->type] ?? ['icon' => 'fa-file-alt', 'color' => 'secondary'];
                            @endphp
                            
                            <div class="col-12">
                                <div class="resource-card p-4 flex-md-row align-items-md-center gap-4 border-0 shadow-sm mb-1 bg-white" style="border-radius: 1rem;">
                                    <div class="material-icon-box bg-{{ $config['color'] }} bg-opacity-10 text-{{ $config['color'] }} border border-{{ $config['color'] }} border-opacity-25 shadow-sm">
                                        <i class="fas {{ $config['icon'] }}"></i>
                                    </div>
                                    
                                    <div class="flex-grow-1">
                                        <div class="d-flex flex-wrap gap-2 mb-2">
                                            <span class="badge bg-light text-dark border"><i class="fas fa-graduation-cap text-muted me-1"></i> {{ $resource->course->title ?? 'General' }}</span>
                                            <span class="badge bg-{{ $config['color'] }} bg-opacity-10 text-{{ $config['color'] }} text-uppercase border border-{{ $config['color'] }} border-opacity-25 fw-bold" style="font-size: 0.65rem;">{{ str_replace('_', ' ', $resource->type) }}</span>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-1 fs-5">{{ $resource->title }}</h5>
                                        <p class="text-muted small mb-0">{{ $resource->description ?: 'Supplemental study material.' }}</p>
                                    </div>
                                    
                                    <div class="d-flex flex-wrap gap-2 mt-3 mt-md-0 justify-content-start justify-content-md-end flex-shrink-0">
                                        @if($resource->type === 'link' && filter_var($resource->file_path, FILTER_VALIDATE_URL))
                                            <a href="{{ $resource->file_path }}" target="_blank" rel="noopener" class="btn btn-outline-info rounded-pill fw-bold shadow-sm px-4">
                                                <i class="fas fa-external-link-alt me-1"></i> Visit
                                            </a>
                                        @else
                                            <a href="{{ route('student.resources.download', $resource->id) }}" class="btn btn-outline-primary rounded-pill fw-bold shadow-sm px-4">
                                                <i class="fas fa-download me-1"></i> Download
                                            </a>
                                        @endif
                                        
                                        @if($resource->type === 'lecture_notes' && $videoUrl)
                                            <button type="button"
                                                class="btn btn-success bg-opacity-10 text-success border-success rounded-pill fw-bold shadow-sm open-lecture-video px-4"
                                                data-bs-toggle="modal"
                                                data-bs-target="#lectureVideoModal"
                                                data-title="{{ $relatedVideo->title }}"
                                                data-url="{{ $videoUrl }}"
                                                data-external="{{ $isExternalVideo ? '1' : '0' }}">
                                                <i class="fas fa-play-circle me-1"></i> Linked Video
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="card border-0 shadow-sm rounded-4 text-center py-5 h-100 bg-white">
                                    <div class="d-inline-flex bg-light bg-opacity-50 text-muted p-4 rounded-circle mb-3 border shadow-sm">
                                        <i class="fas fa-folder-open fa-3x opacity-50"></i>
                                    </div>
                                    <h5 class="fw-bold text-dark">No Documents Available</h5>
                                    <p class="text-muted mb-0">Study materials, notes, or links will appear here.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal for Linked Videos -->
<div class="modal fade" id="lectureVideoModal" tabindex="-1" aria-labelledby="lectureVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content video-modal shadow-lg">
            <div class="modal-header video-modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold" id="lectureVideoModalLabel"><i class="fas fa-play-circle text-primary me-2"></i>Lecture Video</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 pt-2">
                <div class="ratio ratio-16x9 bg-black rounded-3 overflow-hidden shadow" id="lectureVideoContainer">
                    <!-- Video injected via JS -->
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // --- Modal Video Injection Logic ---
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
                modalTitle.innerHTML = '<i class="fas fa-play-circle text-primary me-2"></i>' + title;

                if (!url) {
                    videoContainer.innerHTML = '<div class="text-white d-flex align-items-center justify-content-center w-100 h-100 flex-column"><i class="fas fa-video-slash fa-2x mb-2 text-muted"></i><div>Video source not found.</div></div>';
                    return;
                }

                if (isExternal) {
                    const embedUrl = toEmbedUrl(url);
                    videoContainer.innerHTML = '<iframe src="' + embedUrl + '" title="Lecture Video" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen class="w-100 h-100 border-0"></iframe>';
                } else {
                    videoContainer.innerHTML = '<video controls autoplay class="w-100 h-100"><source src="' + url + '">Your browser does not support the video tag.</video>';
                }
            });
        });

        if(modalEl){
            modalEl.addEventListener('hidden.bs.modal', function () {
                videoContainer.innerHTML = '';
            });
        }

        // --- Editable Notes Logic ---
        const notepad = document.getElementById('student_resources_notes_{{ Auth::id() }}');
        if (notepad) {
            const storageKey = 'resources_notepad_student_v2_{{ Auth::id() }}';
            const savedContent = localStorage.getItem(storageKey);

            if (savedContent) {
                notepad.innerHTML = savedContent;
            }

            notepad.addEventListener('blur', function() {
                const content = this.innerHTML.trim();
                
                if (content && content !== '<br>' && content !== '<div><br></div>') {
                    localStorage.setItem(storageKey, content);
                    Swal.fire({
                        toast: true,
                        position: 'bottom-end',
                        icon: 'success',
                        title: 'Notes Saved!',
                        showConfirmButton: false,
                        timer: 1500,
                        background: '#10b981',
                        color: '#fff'
                    });
                } else {
                    localStorage.removeItem(storageKey);
                }
            });

            // Format shortcuts
            notepad.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 'b') { e.preventDefault(); document.execCommand('bold', false, null); }
                if ((e.ctrlKey || e.metaKey) && e.key === 'i') { e.preventDefault(); document.execCommand('italic', false, null); }
                if (e.key === 'Enter') { e.preventDefault(); document.execCommand('insertLineBreak'); }
            });
            
            // Enable tooltips
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        }
    });
</script>
@endsection
