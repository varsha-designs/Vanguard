<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;
    protected $fillable = [
        'faculty_id',
        'name',
        'email_id',
        'phone_number',
        'father_name',
        'mother_name',
    ];
}
