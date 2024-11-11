<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CourseUser extends Model
{
    protected $fillable = ['user_id', 'course_id', 'progress', 'current_video_id'];

    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el curso
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_user')->withPivot('progress');
    }

    public function currentVideo()
    {
        return $this->belongsTo(Video::class, 'current_video_id');
    }
}
