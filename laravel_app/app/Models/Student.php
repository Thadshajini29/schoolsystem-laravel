<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'father_name',
        'student_name',
        'admission_no',
        'grade_id',
        'nic_num',
        'birth_date',
        'gender',
        'phone_no',
        'address',
        'file_path',
        'original_name',
        'file_size',
        'admission_date',
        'academic_year',
    ];

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'student_subject');
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }
}
