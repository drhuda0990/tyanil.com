<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class AdditionalFeatures extends Model
{
    use LogsActivity;
    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
  {
      return LogOptions::defaults()->logAll();
  }
  
  public function service(){
    return $this->belongsTo(Service::class,'service_id');
  }
}
