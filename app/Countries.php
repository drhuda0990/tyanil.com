<?php

namespace App;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
  use LogsActivity;

  public function getActivitylogOptions(): LogOptions
  {
      return LogOptions::defaults()->logAll();
  }
       public $table = "countries";

     protected $guarded = [];
      public function trainees()
    {
        return $this->hasMany(Trainee::class,'nationality','country_code');
    }
}
