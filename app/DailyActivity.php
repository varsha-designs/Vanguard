<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\carbon;

class DailyActivity extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'faculty_id',
        'date',
        'in_time',
        'out_time',
        'activities',
        'hours_spent',
    ];
    protected $casts = [
        'activities' => 'array', // auto convert JSON <-> array
    ];

    public function student()
    {
        return $this->belongsTo(Student::class,'student_id','id');
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id','id');
    }
    protected static function booted()
    {
        static::saving(function ($activity) {
            if ($activity->in_time && $activity->out_time) {
                $in  = Carbon::parse($activity->in_time);
                $out = Carbon::parse($activity->out_time);
                $activity->hours_spent = $out->diffInMinutes($in) / 60; // decimal hours
            }
        });
    }
    public function getActivitiesAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setActivitiesAttribute($value)
    {
        $this->attributes['activities'] = json_encode($value);
    }
}
