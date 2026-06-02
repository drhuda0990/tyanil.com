<?php

namespace App;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
  use LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }
      protected $guarded = [];
        public function customer(){
    return $this->belongsTo(Customer::class,'customer_id');
  }

  public function service(){
    return $this->belongsTo(Service::class,'service_id');
  }
}
