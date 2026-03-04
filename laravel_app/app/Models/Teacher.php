<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = ['name', 'phone', 'email'];

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'grade_subject_teacher');
    }

    public function grades()
    {
        return $this->belongsToMany(Grade::class, 'grade_subject_teacher');
    }
}
