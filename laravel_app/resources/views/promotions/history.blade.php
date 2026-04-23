@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
        <div>
            <h1 class="h3 mb-1 text-gray-800">
                <i class="bi bi-clock-history me-2 text-primary"></i>Promotion History
            </h1>
            <p class="text-muted small mb-0">Record of all past student batch promotions</p>
        </div>
        
        <a href="{{ route('promotions.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Promotions
        </a>
    </div>

    <div class="card shadow border-0 fade-in">
        <div class="card-header py-3 bg-white border-bottom">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="bi bi-list-check me-2"></i>Promotion Logs
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Date & Time</th>
                            <th>Action Details</th>
                            <th>Academic Year</th>
                            <th class="text-center">Affected Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td class="ps-4 text-muted small">
                                    {{ $log->created_at->format('M d, Y - h:i A') }}
                                </td>
                                <td>
                                    <span class="fw-semibold text-dark">{{ $log->action }}</span>
                                    @if(isset($log->payload['from_grade']) && isset($log->payload['to_grade']))
                                        <div class="small text-muted mt-1">
                                            From <span class="badge bg-secondary-soft text-secondary border border-secondary px-1">{{ $log->payload['from_grade'] }}</span>
                                            <i class="bi bi-arrow-right mx-1"></i>
                                            To <span class="badge bg-success-soft text-success border border-success px-1">{{ $log->payload['to_grade'] }}</span>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info-soft text-info border border-info px-2 py-1">
                                        {{ $log->payload['academic_year'] ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="fw-bold">{{ $log->payload['student_count'] ?? 0 }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <i class="bi bi-journal-x fs-1 text-muted opacity-25"></i>
                                    <p class="text-muted mt-3">No promotion history found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($logs->hasPages())
            <div class="card-footer bg-white py-3">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

    <style>
        .bg-secondary-soft { background-color: rgba(108, 117, 125, 0.1); }
        .bg-success-soft { background-color: rgba(25, 135, 84, 0.1); }
        .bg-info-soft { background-color: rgba(13, 202, 240, 0.1); }
    </style>
@endsection
