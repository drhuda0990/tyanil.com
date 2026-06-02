<?php

namespace App;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
  use LogsActivity;
  protected $guarded = [];
  public function getActivitylogOptions(): LogOptions
  {
    return LogOptions::defaults()->logAll();
  }
  public function customer()
  {
    return $this->belongsTo(Customer::class);
  }
  public function discountCode()
  {
    return $this->belongsTo(Discount::class, 'discount_id');
  }
  public function service()
  {
    return $this->belongsTo(Service::class);
  }
}
