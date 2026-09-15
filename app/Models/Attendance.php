<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'grade_id',
        'attendance_date',
        'status',
        'remarks',
        'marked_by',
    ];

    protected $casts = [
        'attendance_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function marker()
    {
        return $this->belongsTo(User::class, 'marked_by');
    }

    // Helper badge color
    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'present' => 'bg-success',
            'absent' => 'bg-danger',
            'late' => 'bg-warning text-dark',
            'excused' => 'bg-info text-dark',
            default => 'bg-secondary',
        };
    }
}
