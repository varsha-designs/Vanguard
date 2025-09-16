<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vanguard\Document;

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


}
