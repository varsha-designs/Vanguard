<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vanguard\Faculty;
use Vanguard\student;


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
        'start_date',
    'end_date',
    ];

    public function students()
{
    return $this->belongsToMany(Student::class, 'enrollments', 'course_id','student_id');
}



}
