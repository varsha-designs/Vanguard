<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vanguard\Document;
use Vanguard\Course;
 use Vanguard\DailyActivity;
 use Vanguard\ActivityImage;


class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'full_name',
        'email',
        'whatsapp_number',
        'dob',
        'gender',
        'address',
        'college',
        'degree',
        'year_of_passing',
        'company',
        'role',
        'experience',
        'studentid',
    ];
    public function documents()
   {
    return $this->hasMany(Document::class);

   }
   public function courses()
{
    return $this->belongsToMany(Course::class, 'enrollments', 'student_id', 'course_id');
}
public function dailyactivities()
{
    return $this->belongsTo(DailyActivity::class);
}

public function activities()
{
    return $this->hasMany(DailyActivity::class, 'student_id');
}


}
