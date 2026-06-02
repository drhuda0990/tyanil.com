<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class ServiceCategory extends Model
{
    use HasFactory, LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }
    public function services()
    {
      return $this->hasMany(Service::class,'service_category_id');
    }
    public function activateServices()
    {
      return $this->hasMany(Service::class,'service_category_id')->where('activate',1);
    }
    public function serviceSubCategories()
    {
      return $this->hasMany(ServiceCategory::class,'parent_main_category_id');
    }
    public function serviceActivateSubCategories()
    {
      return $this->hasMany(ServiceCategory::class,'parent_main_category_id')->where('activate',1)->orderBy('order_num');
    }
}
