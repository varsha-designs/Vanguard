<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vanguard\DailyActivity;

class ActivityImage extends Model
{
    use HasFactory;

     protected $fillable = ['activity_id', 'image_path'];

    public function activity() {
        return $this->belongsTo(DailyActivity::class,'activity_id');
    }
}
