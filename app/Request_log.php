<?php

namespace App;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Model;

class Request_log extends Model
{
  use LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }
  public $table = "request_logs";

  protected $casts = [
      'log_date' => 'datetime',
  ];

  public function course_trainee(){
    return $this->belongsTo(CourseTrainee::class);
  }

  public function user_id(){
    return $this->belongsTo(User::class);
  }

/*
  public function institutes(){
    return $this->belongsTo(Institute::class);
  }





  public function attachment(){
    //return $this->belongsTo(Attachment::class);
    return $this->belongsToMany(Attachment::class, 'attachment_lesson' , 'attachment_id' , 'lesson_id')
                ->distinct()
                ->withTimestamps();
  }
  */
}
