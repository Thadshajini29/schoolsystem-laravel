<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = ['name', 'phone', 'email', 'image_path'];

    public function getImageUrlAttribute()
    {
        return $this->image_path ? asset('storage/' . $this->image_path) : asset('assets/img/default-avatar.png');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'grade_subject_teacher');
    }

    public function grades()
    {
        return $this->belongsToMany(Grade::class, 'grade_subject_teacher');
    }
}
