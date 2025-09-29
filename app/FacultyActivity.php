<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vanguard\faculty;

class FacultyActivity extends Model
{
    use HasFactory;
   protected $fillable = [
        'faculty_id',
        'activities',
        'images',
        'date',
        'in_time',
    'out_time',
    'hours_spend',
    'new_learning',
        'todo_list',
    ];

    // Cast arrays to JSON
    protected $casts = [
        'activities' => 'array',
        'images' => 'array',
        'date' => 'date',
    ];

    // Relationship with Faculty
    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

}
