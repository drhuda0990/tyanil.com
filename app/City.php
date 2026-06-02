<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class City extends Model
{use LogsActivity;

  public function getActivitylogOptions(): LogOptions
  {
      return LogOptions::defaults()->logAll();
  }

     protected $guarded = [];
}
