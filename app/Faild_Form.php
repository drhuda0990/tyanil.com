<?php

namespace App;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Model;

class Faild_Form extends Model
{
  use LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }
  public $table = "faild_forms";


  public function institutes(){
    return $this->belongsTo(Institute::class);
  }
  public function form(){
    return $this->belongsTo(Form::class , 'forms_id');
  }
  public function user(){
    return $this->belongsTo(User::class);
  }

}
