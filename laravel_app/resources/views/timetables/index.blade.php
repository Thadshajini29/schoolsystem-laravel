@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
        <div>
            <h1 class="h3 mb-1 text-gray-800">
                <i class="bi bi-calendar-event-fill me-2 text-primary"></i>School Timetable
            </h1>
            <p class="text-muted small mb-0">View and manage class schedules for grades</p>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4 fade-in">
        <div class="card-body">
            <form action="{{ route('timetables.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-9">
                    <label for="grade_id" class="form-label small fw-bold">Select Grade to View Schedule</label>
                    <select name="grade_id" id="grade_id" class="form-select border-primary" onchange="this.form.submit()">
                        <option value="">Choose Grade...</option>
                        @foreach($grades as $grade)
                            <option value="{{ $grade->id }}" {{ request('grade_id') == $grade->id ? 'selected' : '' }}>
                                {{ $grade->grade_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-grid">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-search me-2"></i>Fetch Schedule
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($selectedGrade)
        <div class="row g-4 mb-4 fade-in">
            @if(Auth::user()->isAdmin())
            <!-- Add Schedule Entry Form (Admin Only) -->
            <div class="col-lg-3">
                <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                    <div class="card-header bg-white border-bottom py-3">
                        <h6 class="m-0 fw-bold text-primary">Add Time Slot</h6>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('timetables.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="grade_id" value="{{ $selectedGrade->id }}">
                            
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Day of Week</label>
                                <select name="day" class="form-select form-select-sm" required>
                                    @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                        <option value="{{ $day }}">{{ $day }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold">Subject</label>
                                <select name="subject_id" class="form-select form-select-sm" required>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold">Teacher</label>
                                <select name="teacher_id" class="form-select form-select-sm" required>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row g-2 mb-4">
                                <div class="col-6">
                                    <label class="form-label small fw-bold">Start Time</label>
                                    <input type="time" name="time_start" class="form-control form-control-sm" required>
                                </div>
                                <div class="col-6">
                                    <label class="form-label small fw-bold">End Time</label>
                                    <input type="time" name="time_end" class="form-control form-control-sm" required>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-sm py-2">
                                    <i class="bi bi-plus-circle me-2"></i>Assign Slot
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif

            <!-- Timetable View -->
            <div class="{{ Auth::user()->isAdmin() ? 'col-lg-9' : 'col-lg-12' }}">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 fw-bold text-primary">
                            Weekly Schedule: {{ $selectedGrade->grade_name }}
                        </h6>
                        <button onclick="window.print()" class="btn btn-sm btn-outline-secondary d-print-none">
                            <i class="bi bi-printer me-1"></i> Print
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0 align-middle">
                                <thead class="bg-light">
                                    <tr class="text-center">
                                        <th style="width: 15%;">Day</th>
                                        <th style="width: 85%;">Scheduled Classes (Start Time Order)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($timetableData as $day => $entries)
                                        <tr>
                                            <td class="bg-light fw-bold text-center {{ now()->format('l') == $day ? 'text-primary' : '' }}">
                                                {{ $day }}
                                                @if(now()->format('l') == $day)
                                                    <span class="d-block small fw-normal text-muted">(Today)</span>
                                                @endif
                                            </td>
                                            <td class="p-2">
                                                @if($entries->count() > 0)
                                                    <div class="d-flex flex-wrap gap-3">
                                                        @foreach($entries as $entry)
                                                            <div class="timetable-slot shadow-sm rounded border-start border-4 {{ Auth::user()->isAdmin() ? 'border-primary' : 'border-info' }} p-2 bg-white flex-grow-1" style="min-width: 250px;">
                                                                <div class="d-flex justify-content-between">
                                                                    <div class="fw-bold">{{ $entry->subject->subject_name }}</div>
                                                                    @if(Auth::user()->isAdmin())
                                                                        <form action="{{ route('timetables.destroy', $entry) }}" method="POST" onsubmit="return confirm('Remove slot?')">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-link link-danger p-0 d-print-none">
                                                                                <i class="bi bi-x-circle-fill"></i>
                                                                            </button>
                                                                        </form>
                                                                    @endif
                                                                </div>
                                                                <div class="small text-muted mb-1">
                                                                    <i class="bi bi-person me-1"></i> {{ $entry->teacher->name }}
                                                                </div>
                                                                <div class="badge bg-light text-dark border p-2 w-100 text-start">
                                                                    <i class="bi bi-clock me-1"></i> 
                                                                    {{ date('h:i A', strtotime($entry->time_start)) }} - {{ date('h:i A', strtotime($entry->time_end)) }}
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <em class="text-muted small p-2">No classes scheduled</em>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5 fade-in bg-white rounded shadow-sm">
            <i class="bi bi-calendar3 fs-1 text-primary opacity-25"></i>
            <p class="text-muted mt-3 h5">Please select a Grade to view its weekly schedule.</p>
        </div>
    @endif

    <style>
        @media print {
            .sidebar, .topbar, .sticky-top, .d-print-none { display: none !important; }
            .col-lg-9 { width: 100% !important; margin: 0 !important; }
            .timetable-slot { border: 1px solid #ddd !important; box-shadow: none !important; }
        }
    </style>
@endsection
