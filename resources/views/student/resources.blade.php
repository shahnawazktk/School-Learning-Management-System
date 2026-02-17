@extends('layouts.student.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container-fluid p-4">
    <div class="row">
        @forelse($resources as $resource)
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                                @if($resource->type == 'video')
                                    <i class="fas fa-video fa-2x text-primary"></i>
                                @elseif($resource->type == 'document')
                                    <i class="fas fa-file-pdf fa-2x text-danger"></i>
                                @elseif($resource->type == 'lecture_notes')
                                    <i class="fas fa-file-alt fa-2x text-success"></i>
                                @else
                                    <i class="fas fa-file fa-2x text-secondary"></i>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-2">{{ $resource->title }}</h5>
                                <p class="text-muted mb-2">{{ $resource->description }}</p>
                                <div class="d-flex gap-3 mb-3">
                                    <small><i class="fas fa-book me-1"></i>{{ $resource->course->title ?? 'N/A' }}</small>
                                    <small><i class="fas fa-tag me-1"></i>{{ ucfirst(str_replace('_', ' ', $resource->type)) }}</small>
                                </div>
                                <a href="{{ route('student.resources.download', $resource->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-download me-1"></i>Download
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No study materials available</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
