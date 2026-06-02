<?php

namespace App;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
  use LogsActivity;
  public function getActivitylogOptions(): LogOptions
  {
      return LogOptions::defaults()->logAll();
  }
  public $table = "discounts";
  protected $casts = [
      'date_1' => 'datetime',
      'date_2' => 'datetime',
  ];
  public function service(){
    return $this->belongsTo(Service::class);
  }
}
