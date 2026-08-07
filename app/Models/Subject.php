<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_name',
        'subject_index',
        'subject_order',
        'subject_color',
        'subject_number',
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_subject');
    }

    public function grades()
    {
        return $this->belongsToMany(Grade::class, 'grade_subject');
    }
}
