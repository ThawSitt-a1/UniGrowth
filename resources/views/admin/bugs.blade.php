@extends('admin.layout')

@section('title', 'Bug Reports')

@section('content')
    <div class="content-card">
        <div class="card-header-custom">
            <h5><i class="bi bi-bug me-2"></i>Bug Reports</h5>
            <span class="badge bg-secondary">{{ count($reports ?? []) }} total</span>
        </div>
        <div class="card-body-custom p-0">
            @if(empty($reports))
                <div class="empty-state">
                    <i class="bi bi-bug"></i>
                    <p>No bug reports found.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-admin table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>User</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reports as $report)
                                <tr>
                                    <td class="fw-semibold">{{ $report['id'] }}</td>
                                    <td class="small text-muted" style="white-space: nowrap;">
                                        {{ isset($report['created_at']) ? \Carbon\Carbon::parse($report['created_at'])->format('M j, Y g:i A') : 'N/A' }}
                                    </td>
                                    <td class="small">
                                        @if(isset($report['user']))
                                            <span class="fw-medium">{{ $report['user']['username'] ?? 'Unknown' }}</span>
                                            <span class="text-muted d-block" style="font-size: 0.7rem;">
                                                {{ $report['user']['email'] ?? '' }}
                                            </span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td class="small" style="max-width: 300px; word-break: break-word;">
                                        <span class="text-muted">{{ Str::limit($report['description'] ?? 'No description', 120) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-status {{ $report['status'] ?? 'pending' }}">
                                            {{ str_replace('_', ' ', ucfirst($report['status'] ?? 'pending')) }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="actions-cell justify-content-end">
                                           <a href="{{ route('admin.bug-reports.show', $report['id']) }}" class="btn-admin-action view">
                                               <i class="bi bi-journal-text"></i>View
                                           </a>

                                           @if(($report['status'] ?? 'pending') !== 'resolved')
                                               <form method="POST" action="{{ route('admin.bug-reports.status', $report['id']) }}"
class="d-inline">
                                                   @csrf
                                                   <input type="hidden" name="status" value="resolved">
                                                   <button type="submit" class="btn-admin-action complete">
                                                       <i class="bi bi-check2"></i>Resolve
                                                   </button>
                                               </form>
                                           @endif

@if(($report['status'] ?? 'pending') !== 'reviewed')
                                               <form method="POST" action="{{ route('admin.bug-reports.status', $report['id']) }}" class="d-inline">
                                                   @csrf
                                                   <input type="hidden" name="status" value="reviewed">
                                                   <button type="submit" class="btn-admin-action view">
                                                       <i class="bi bi-eye"></i>Reviewed
                                                   </button>
                                               </form>
                                           @endif

                                           @if(($report['status'] ?? 'pending') === 'resolved')
                                               <form method="POST" action="{{ route('admin.bug-reports.delete', $report['id']) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this resolved bug report?');">
                                                   @csrf
                                                   <button type="submit" class="btn-admin-action delete">
                                                       <i class="bi bi-trash"></i>Delete
                                                   </button>
                                               </form>
                                           @endif
                                       </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
