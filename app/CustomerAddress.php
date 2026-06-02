<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class CustomerAddress extends Model
{
    
    use HasFactory,LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }
    protected $guarded = [];

    public function customer()
    {
      return $this->belongsTo(Customer::class, 'customer_id');
    }
}
