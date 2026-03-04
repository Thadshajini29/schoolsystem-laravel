@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
        <div>
            <h1 class="h3 mb-1 text-gray-800">
                <i class="bi bi-activity me-2 text-primary"></i>System Activity Logs
            </h1>
            <p class="text-muted small mb-0">Monitor all administrative actions and system events</p>
        </div>
    </div>

    <div class="card shadow-sm border-0 fade-in">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3" style="width: 20%;">Timestamp</th>
                            <th style="width: 15%;">User</th>
                            <th style="width: 20%;">Action</th>
                            <th style="width: 25%;">Model Reference</th>
                            <th class="pe-4" style="width: 20%;">Details (Payload)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td class="ps-4">
                                    <span class="text-dark fw-semibold">{{ $log->created_at->format('d M, Y') }}</span>
                                    <span class="d-block small text-muted">{{ $log->created_at->format('h:i A') }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-person small"></i>
                                        </div>
                                        <span class="small fw-bold">{{ $log->user->user_name ?? 'System' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border px-2 py-1">
                                        {{ $log->action }}
                                    </span>
                                </td>
                                <td class="small">
                                    @if($log->model_type)
                                        <div class="text-muted text-uppercase" style="font-size: 10px;">{{ class_basename($log->model_type) }}</div>
                                        <div class="fw-semibold">ID: {{ $log->model_id }}</div>
                                    @else
                                        <span class="text-muted">General Action</span>
                                    @endif
                                </td>
                                <td class="pe-4">
                                    @if($log->payload)
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#payload_{{ $log->id }}">
                                            View Details
                                        </button>
                                        <div class="collapse mt-2" id="payload_{{ $log->id }}">
                                            <pre class="bg-light p-2 rounded small mb-0" style="font-size: 10px;">{{ json_encode($log->payload, JSON_PRETTY_PRINT) }}</pre>
                                        </div>
                                    @else
                                        <span class="text-muted small">No extra data</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <i class="bi bi-journal-x fs-1 text-muted opacity-25"></i>
                                    <p class="text-muted mt-2">No activity logs found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($logs->hasPages())
            <div class="card-footer bg-white py-3 border-0">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
@endsection
