@extends('admin.layout')

@section('title', 'Bug Report #' . ($report['id'] ?? 'Details'))

@section('content')
    <div class="content-card">
        <div class="card-header-custom">
            <div>
                <h5><i class="bi bi-journal-text me-2"></i>Bug Report Details</h5>
                <p class="text-muted mb-0">Review the bug report entry submitted by a user, including reproduction steps and attached screenshot.</p>
            </div>
            <a href="{{ route('admin.bug-reports') }}" class="btn-admin-action view">
                <i class="bi bi-arrow-left"></i>Back to Bug Reports
            </a>
        </div>
        <div class="card-body-custom">
            <div class="row g-4">
                <div class="col-12">
                    <div class="mb-4">
                        <h6 class="mb-2">Title</h6>
                        <p class="fw-semibold">{{ $report['title'] }}</p>
                    </div>

                    <div class="row gy-3">
                        <div class="col-md-4">
                            <div class="small text-muted">Reported by</div>
                            @if(isset($report['user']))
                                <div class="fw-semibold">{{ $report['user']['username'] ?? 'Unknown' }}</div>
                                <div class="text-muted">{{ $report['user']['email'] ?? 'Unknown email' }}</div>
                            @else
                                <div class="text-muted">Unknown user</div>
                            @endif
                        </div>

                        <div class="col-md-4">
                            <div class="small text-muted">Severity</div>
                            <div class="fw-semibold text-capitalize">{{ $report['severity'] ?? 'medium' }}</div>
                        </div>

                        <div class="col-md-4">
                            <div class="small text-muted">Status</div>
                            <span class="badge badge-status {{ $report['status'] ?? 'pending' }}">
                                {{ str_replace('_', ' ', ucfirst($report['status'] ?? 'pending')) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="mb-4">
                        <h6>Description</h6>
                        <p class="text-muted">{{ $report['description'] }}</p>
                    </div>

                    @if(!empty($report['steps_to_reproduce']))
                        <div class="mb-4">
                            <h6>Steps to Reproduce</h6>
                            <p class="text-muted">{{ $report['steps_to_reproduce'] }}</p>
                        </div>
                    @endif

                    <div class="mb-4">
                        <h6>Reported On</h6>
                        <p class="text-muted">
                            {{ isset($report['created_at']) ? \Carbon\Carbon::parse($report['created_at'])->format('M j, Y g:i A') : 'N/A' }}
                        </p>
                    </div>

                    <div class="mb-4">
                        <h6>Screenshot</h6>
                        @if(!empty($report['screenshot_url']))
                            <a href="{{ $report['screenshot_url'] }}" target="_blank" rel="noopener noreferrer">
                                <img src="{{ $report['screenshot_url'] }}" alt="Bug screenshot" class="img-fluid rounded border" style="max-height: 520px; width: auto;">
                            </a>
                            <p class="text-muted small mt-2">Click the screenshot to view full size.</p>
                        @elseif(!empty($report['screenshot_path']))
                            <p class="text-muted">Screenshot path stored, but unable to generate a preview.</p>
                        @else
                            <p class="text-muted">No screenshot was attached to this bug report.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
