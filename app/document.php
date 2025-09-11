<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class document extends Model
{
    use HasFactory;
   protected $fillable =
   ['student_id',
    'file_name',
    'upload_file',];

    public function student()
{
    return $this->belongsTo(Student::class);
}

}
