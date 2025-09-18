<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_name',
        'course_code',
        'level',
        'section',
        'concepts',
        'project',
        'course_fee',
    ];

    public function students()
{
    return $this->belongsToMany(Student::class, 'enrollments', 'student_id', 'course_id');
}

}
