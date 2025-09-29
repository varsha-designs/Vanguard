<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacultySchedule extends Model
{
    use HasFactory;
    protected $fillable = ['faculty_id', 'studentid', 'day', 'date', 'time'];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'studentid');
    }
}
