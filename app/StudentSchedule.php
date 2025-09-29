<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSchedule extends Model
{
    use HasFactory;
     protected $fillable = [
        'studentid',
        'day',
        'date',
        'time',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class,'studentid');
    }

}
