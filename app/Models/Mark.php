<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'student_id',
        'subject_id',
        'grade_id',
        'marks_obtained',
        'total_marks',
        'grade_letter',
        'remarks',
    ];

    protected $casts = [
        'marks_obtained' => 'float',
        'total_marks' => 'float',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function getPercentageAttribute()
    {
        if ($this->total_marks > 0) {
            return round(($this->marks_obtained / $this->total_marks) * 100, 1);
        }
        return 0;
    }

    /**
     * Compute letter grade based on percentage
     */
    public static function calculateGradeLetter(float $obtained, float $total): string
    {
        if ($total <= 0) return 'F';
        $percentage = ($obtained / $total) * 100;

        if ($percentage >= 85) return 'A+';
        if ($percentage >= 75) return 'A';
        if ($percentage >= 65) return 'B';
        if ($percentage >= 50) return 'C';
        if ($percentage >= 35) return 'S';
        return 'F';
    }

    /**
     * Get badge class for grade letter
     */
    public function getGradeBadgeAttribute(): string
    {
        return match ($this->grade_letter) {
            'A+', 'A' => 'bg-success',
            'B' => 'bg-primary',
            'C' => 'bg-info text-dark',
            'S' => 'bg-warning text-dark',
            'F' => 'bg-danger',
            default => 'bg-secondary',
        };
    }
}
